<?php
// Set session cookie lifetime to 6 months (180 days)
$six_months_in_seconds = 180 * 24 * 60 * 60; // 180 days * 24 hours * 60 minutes * 60 seconds
session_set_cookie_params([
    'lifetime' => $six_months_in_seconds,
    'path' => '/',
    'domain' => '', // Leave empty for current domain
    'secure' => true, // Use true if HTTPS is enabled
    'httponly' => true, // Prevent JavaScript access to session cookie
    'samesite' => 'Lax' // Helps prevent CSRF attacks
]);

// Start the session
session_start();
require_once "db_connect.php";

$db = Database::getInstance();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

try {
    // Fetch logged-in user's profile
    $stmt = $db->prepare("SELECT up.*, u.username FROM user_profiles up LEFT JOIN users u ON up.user_id = u.id WHERE up.user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC) ?: [
        'user_id' => $user_id,
        'username' => 'DefaultUser',
        'name' => 'Default User',
        'avatar_path' => 'uploads/avatars/default.jpg',
        'bio' => 'No bio yet',
        'location' => 'Not specified'
    ];

    // Fetch pending friend requests received
    $stmt = $db->prepare("
        SELECT fr.id, fr.sender_id, u.username, up.avatar_path, up.name
        FROM friend_requests fr
        JOIN users u ON fr.sender_id = u.id
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE fr.receiver_id = :user_id AND fr.status = 'pending'
    ");
    $stmt->execute(['user_id' => $user_id]);
    $friend_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch friends (accepted friend requests)
    $stmt = $db->prepare("
        SELECT u.id, u.username, up.avatar_path, up.name
        FROM users u
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE u.id IN (
            SELECT receiver_id FROM friend_requests WHERE sender_id = :user_id AND status = 'accepted'
            UNION
            SELECT sender_id FROM friend_requests WHERE receiver_id = :user_id AND status = 'accepted'
        )
    ");
    $stmt->execute(['user_id' => $user_id]);
    $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch friend suggestions (users not yet friends)
    $stmt = $db->prepare("
        SELECT u.id, u.username, up.avatar_path, up.name
        FROM users u
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE u.id NOT IN (
            SELECT receiver_id FROM friend_requests WHERE sender_id = :user_id AND status IN ('pending', 'accepted')
            UNION
            SELECT sender_id FROM friend_requests WHERE receiver_id = :user_id AND status IN ('pending', 'accepted')
        ) AND u.id != :user_id
        LIMIT 5
    ");
    $stmt->execute(['user_id' => $user_id]);
    $friend_suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch notifications
    $stmt = $db->prepare("
        SELECT n.*, u.username as sender_username, up.avatar_path as sender_avatar
        FROM notifications n
        LEFT JOIN users u ON n.sender_id = u.id
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE n.user_id = :user_id
        ORDER BY n.created_at DESC
        LIMIT 10
    ");
    $stmt->execute(['user_id' => $user_id]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle POST requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'send_friend_request':
                    $receiver_id = (int)$_POST['receiver_id'];
                    
                    // Check if request already exists
                    $stmt = $db->prepare("SELECT id FROM friend_requests WHERE sender_id = :sender_id AND receiver_id = :receiver_id");
                    $stmt->execute(['sender_id' => $user_id, 'receiver_id' => $receiver_id]);
                    
                    if (!$stmt->fetch()) {
                        // Send friend request
                        $stmt = $db->prepare("INSERT INTO friend_requests (sender_id, receiver_id, status, created_at) VALUES (:sender_id, :receiver_id, 'pending', NOW())");
                        $stmt->execute(['sender_id' => $user_id, 'receiver_id' => $receiver_id]);
                        
                        // Create notification
                        $stmt = $db->prepare("INSERT INTO notifications (user_id, sender_id, type, message, created_at) VALUES (:user_id, :sender_id, 'friend_request', 'sent you a friend request', NOW())");
                        $stmt->execute(['user_id' => $receiver_id, 'sender_id' => $user_id]);
                        
                        $success_message = "Friend request sent successfully!";
                    } else {
                        $error_message = "Friend request already exists!";
                    }
                    break;

                case 'accept_friend_request':
                    $request_id = (int)$_POST['request_id'];
                    
                    // Update friend request status
                    $stmt = $db->prepare("UPDATE friend_requests SET status = 'accepted' WHERE id = :id AND receiver_id = :user_id");
                    $stmt->execute(['id' => $request_id, 'user_id' => $user_id]);
                    
                    // Get sender info for notification
                    $stmt = $db->prepare("SELECT sender_id FROM friend_requests WHERE id = :id");
                    $stmt->execute(['id' => $request_id]);
                    $sender_id = $stmt->fetchColumn();
                    
                    if ($sender_id) {
                        // Create notification
                        $stmt = $db->prepare("INSERT INTO notifications (user_id, sender_id, type, message, created_at) VALUES (:user_id, :sender_id, 'friend_accepted', 'accepted your friend request', NOW())");
                        $stmt->execute(['user_id' => $sender_id, 'sender_id' => $user_id]);
                    }
                    
                    $success_message = "Friend request accepted!";
                    break;

                case 'decline_friend_request':
                    $request_id = (int)$_POST['request_id'];
                    
                    // Update friend request status
                    $stmt = $db->prepare("UPDATE friend_requests SET status = 'declined' WHERE id = :id AND receiver_id = :user_id");
                    $stmt->execute(['id' => $request_id, 'user_id' => $user_id]);
                    
                    $success_message = "Friend request declined!";
                    break;

                case 'remove_friend':
                    $friend_id = (int)$_POST['friend_id'];
                    
                    // Remove friendship (update all related requests to 'removed')
                    $stmt = $db->prepare("
                        UPDATE friend_requests 
                        SET status = 'removed' 
                        WHERE ((sender_id = :user_id AND receiver_id = :friend_id) 
                               OR (sender_id = :friend_id AND receiver_id = :user_id)) 
                               AND status = 'accepted'
                    ");
                    $stmt->execute(['user_id' => $user_id, 'friend_id' => $friend_id]);
                    
                    $success_message = "Friend removed successfully!";
                    break;

                case 'mark_notification_read':
                    $notification_id = (int)$_POST['notification_id'];
                    
                    // Mark notification as read
                    $stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id AND user_id = :user_id");
                    $stmt->execute(['id' => $notification_id, 'user_id' => $user_id]);
                    break;
            }
            
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Social Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .notification-item {
            border-left: 4px solid #007bff;
            background-color: #f8f9fa;
        }
        .notification-item.unread {
            background-color: #e3f2fd;
            border-left-color: #2196f3;
        }
        .friend-card {
            transition: transform 0.2s;
        }
        .friend-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-users"></i> Social Network</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                <a class="nav-link active" href="profile.php"><i class="fas fa-user"></i> Profile</a>
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Profile Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?php echo htmlspecialchars($profile['avatar_path']); ?>" alt="Avatar" class="avatar mb-3">
                        <h4><?php echo htmlspecialchars($profile['name']); ?></h4>
                        <p class="text-muted">@<?php echo htmlspecialchars($profile['username']); ?></p>
                        <p><?php echo htmlspecialchars($profile['bio']); ?></p>
                        <p class="text-muted"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($profile['location']); ?></p>
                        <a href="edit_profile.php" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5><i class="fas fa-bell"></i> Recent Notifications</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($notifications)): ?>
                            <p class="text-muted">No notifications yet.</p>
                        <?php else: ?>
                            <?php foreach ($notifications as $notification): ?>
                                <div class="notification-item p-2 mb-2 rounded <?php echo $notification['is_read'] ? '' : 'unread'; ?>">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo htmlspecialchars($notification['sender_avatar'] ?: 'uploads/avatars/default.jpg'); ?>" 
                                             alt="Avatar" class="avatar-sm me-2">
                                        <div class="flex-grow-1">
                                            <small>
                                                <strong><?php echo htmlspecialchars($notification['sender_username']); ?></strong>
                                                <?php echo htmlspecialchars($notification['message']); ?>
                                            </small>
                                            <br>
                                            <small class="text-muted"><?php echo date('M j, g:i A', strtotime($notification['created_at'])); ?></small>
                                        </div>
                                        <?php if (!$notification['is_read']): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="action" value="mark_notification_read">
                                                <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-8">
                <!-- Friend Requests -->
                <?php if (!empty($friend_requests)): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fas fa-user-plus"></i> Friend Requests</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($friend_requests as $request): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card friend-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo htmlspecialchars($request['avatar_path'] ?: 'uploads/avatars/default.jpg'); ?>" 
                                                         alt="Avatar" class="avatar-sm me-3">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($request['name']); ?></h6>
                                                        <small class="text-muted">@<?php echo htmlspecialchars($request['username']); ?></small>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="action" value="accept_friend_request">
                                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i> Accept
                                                        </button>
                                                    </form>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="action" value="decline_friend_request">
                                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                                            <i class="fas fa-times"></i> Decline
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Friends List -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-users"></i> Friends (<?php echo count($friends); ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($friends)): ?>
                            <p class="text-muted">No friends yet. Start by sending friend requests!</p>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($friends as $friend): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card friend-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo htmlspecialchars($friend['avatar_path'] ?: 'uploads/avatars/default.jpg'); ?>" 
                                                         alt="Avatar" class="avatar-sm me-3">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($friend['name']); ?></h6>
                                                        <small class="text-muted">@<?php echo htmlspecialchars($friend['username']); ?></small>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="user_profile.php?id=<?php echo $friend['id']; ?>">
                                                                <i class="fas fa-user"></i> View Profile
                                                            </a></li>
                                                            <li><a class="dropdown-item" href="messages.php?user=<?php echo $friend['id']; ?>">
                                                                <i class="fas fa-envelope"></i> Send Message
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form method="POST" class="d-inline">
                                                                    <input type="hidden" name="action" value="remove_friend">
                                                                    <input type="hidden" name="friend_id" value="<?php echo $friend['id']; ?>">
                                                                    <button type="submit" class="dropdown-item text-danger" 
                                                                            onclick="return confirm('Are you sure you want to remove this friend?')">
                                                                        <i class="fas fa-user-minus"></i> Remove Friend
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Friend Suggestions -->
                <?php if (!empty($friend_suggestions)): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-user-friends"></i> People You May Know</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($friend_suggestions as $suggestion): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card friend-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo htmlspecialchars($suggestion['avatar_path'] ?: 'uploads/avatars/default.jpg'); ?>" 
                                                         alt="Avatar" class="avatar-sm me-3">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($suggestion['name']); ?></h6>
                                                        <small class="text-muted">@<?php echo htmlspecialchars($suggestion['username']); ?></small>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="action" value="send_friend_request">
                                                        <input type="hidden" name="receiver_id" value="<?php echo $suggestion['id']; ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-user-plus"></i> Add Friend
                                                        </button>
                                                    </form>
                                                    <a href="user_profile.php?id=<?php echo $suggestion['id']; ?>" class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>