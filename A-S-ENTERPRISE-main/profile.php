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
require_once "backend/db_connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

try {
    // Fetch logged-in user's profile
    $stmt = $conn->prepare("SELECT up.*, u.username FROM user_profiles up LEFT JOIN users u ON up.user_id = u.id WHERE up.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile = $result->fetch_assoc() ?: [
        'user_id' => $user_id,
        'username' => 'DefaultUser',
        'name' => 'Default User',
        'avatar_path' => 'uploads/avatars/default.jpg',
        'bio' => 'No bio yet',
        'location' => 'Not specified'
    ];

    // Fetch pending friend requests received
    $stmt = $conn->prepare("
        SELECT fr.id, fr.sender_id, u.username, up.avatar_path, up.name
        FROM friend_requests fr
        JOIN users u ON fr.sender_id = u.id
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE fr.receiver_id = ? AND fr.status = 'pending'
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $friend_requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch friends (accepted friend requests)
    $stmt = $conn->prepare("
        SELECT u.id, u.username, up.avatar_path, up.name
        FROM users u
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE u.id IN (
            SELECT receiver_id FROM friend_requests WHERE sender_id = ? AND status = 'accepted'
            UNION
            SELECT sender_id FROM friend_requests WHERE receiver_id = ? AND status = 'accepted'
        )
    ");
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $friends = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch friend suggestions (users not yet friends)
    $stmt = $conn->prepare("
        SELECT u.id, u.username, up.avatar_path, up.name
        FROM users u
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE u.id NOT IN (
            SELECT receiver_id FROM friend_requests WHERE sender_id = ? AND status IN ('pending', 'accepted')
            UNION
            SELECT sender_id FROM friend_requests WHERE receiver_id = ? AND status IN ('pending', 'accepted')
        ) AND u.id != ?
        LIMIT 5
    ");
    $stmt->bind_param("iii", $user_id, $user_id, $user_id);
    $stmt->execute();
    $friend_suggestions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch notifications
    $stmt = $conn->prepare("
        SELECT n.id, n.type, n.message, n.is_read, n.created_at,
               u.username as sender_username, up.avatar_path as sender_avatar
        FROM notifications n
        LEFT JOIN users u ON n.sender_id = u.id
        LEFT JOIN user_profiles up ON u.id = up.user_id
        WHERE n.receiver_id = ?
        ORDER BY n.created_at DESC
        LIMIT 10
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $notifications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Handle AJAX requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        header('Content-Type: application/json');
        
        switch ($_POST['action']) {
            case 'send_friend_request':
                $receiver_id = intval($_POST['receiver_id']);
                
                // Check if request already exists
                $stmt = $conn->prepare("SELECT id FROM friend_requests WHERE sender_id = ? AND receiver_id = ?");
                $stmt->bind_param("ii", $user_id, $receiver_id);
                $stmt->execute();
                $existing = $stmt->get_result()->fetch_assoc();
                
                if (!$existing) {
                    $stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, status) VALUES (?, ?, 'pending')");
                    $stmt->bind_param("ii", $user_id, $receiver_id);
                    $stmt->execute();
                    
                    // Create notification
                    $stmt = $conn->prepare("INSERT INTO notifications (receiver_id, sender_id, type, message) VALUES (?, ?, 'friend_request', 'sent you a friend request')");
                    $stmt->bind_param("ii", $receiver_id, $user_id);
                    $stmt->execute();
                    
                    echo json_encode(['success' => true, 'message' => 'Friend request sent!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Friend request already exists']);
                }
                break;
                
            case 'accept_friend_request':
                $request_id = intval($_POST['request_id']);
                
                $stmt = $conn->prepare("UPDATE friend_requests SET status = 'accepted' WHERE id = ? AND receiver_id = ?");
                $stmt->bind_param("ii", $request_id, $user_id);
                $stmt->execute();
                
                // Create notification for sender
                $stmt = $conn->prepare("SELECT sender_id FROM friend_requests WHERE id = ?");
                $stmt->bind_param("i", $request_id);
                $stmt->execute();
                $sender_id = $stmt->get_result()->fetch_assoc()['sender_id'];
                
                $stmt = $conn->prepare("INSERT INTO notifications (receiver_id, sender_id, type, message) VALUES (?, ?, 'friend_accepted', 'accepted your friend request')");
                $stmt->bind_param("ii", $sender_id, $user_id);
                $stmt->execute();
                
                echo json_encode(['success' => true, 'message' => 'Friend request accepted!']);
                break;
                
            case 'decline_friend_request':
                $request_id = intval($_POST['request_id']);
                
                $stmt = $conn->prepare("UPDATE friend_requests SET status = 'declined' WHERE id = ? AND receiver_id = ?");
                $stmt->bind_param("ii", $request_id, $user_id);
                $stmt->execute();
                
                echo json_encode(['success' => true, 'message' => 'Friend request declined']);
                break;
                
            case 'mark_notification_read':
                $notification_id = intval($_POST['notification_id']);
                
                $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND receiver_id = ?");
                $stmt->bind_param("ii", $notification_id, $user_id);
                $stmt->execute();
                
                echo json_encode(['success' => true]);
                break;
        }
        exit;
    }

} catch (Exception $e) {
    $error_message = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Social Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
        }
        .friend-card, .suggestion-card {
            transition: transform 0.2s;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .friend-card:hover, .suggestion-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .notification-item {
            border-left: 4px solid #007bff;
            background: white;
            margin-bottom: 1rem;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .notification-item.unread {
            border-left-color: #ffc107;
            background: #fff9c4;
        }
        .btn-social {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            transition: all 0.3s;
        }
        .btn-social:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-users"></i> Social Network</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error_message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success_message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Profile Card -->
            <div class="col-lg-4 mb-4">
                <div class="profile-card text-center">
                    <img src="<?= htmlspecialchars($profile['avatar_path'] ?? 'uploads/avatars/default.jpg') ?>" 
                         alt="Avatar" class="avatar mb-3">
                    <h3><?= htmlspecialchars($profile['name'] ?? $profile['username']) ?></h3>
                    <p class="mb-1">@<?= htmlspecialchars($profile['username']) ?></p>
                    <p class="mb-3"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($profile['location']) ?></p>
                    <p class="mb-4"><?= htmlspecialchars($profile['bio']) ?></p>
                    <button class="btn btn-light btn-sm">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>

                <!-- Friend Requests -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-user-plus"></i> Friend Requests (<?= count($friend_requests) ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($friend_requests)): ?>
                            <p class="text-muted text-center">No pending friend requests</p>
                        <?php else: ?>
                            <?php foreach ($friend_requests as $request): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="<?= htmlspecialchars($request['avatar_path'] ?? 'uploads/avatars/default.jpg') ?>" 
                                         alt="Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0"><?= htmlspecialchars($request['name'] ?? $request['username']) ?></h6>
                                        <small class="text-muted">@<?= htmlspecialchars($request['username']) ?></small>
                                    </div>
                                    <div>
                                        <button class="btn btn-success btn-sm me-1" onclick="handleFriendRequest(<?= $request['id'] ?>, 'accept')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="handleFriendRequest(<?= $request['id'] ?>, 'decline')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Friends List -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-users"></i> Friends (<?= count($friends) ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($friends)): ?>
                            <p class="text-muted text-center">No friends yet. Send some friend requests!</p>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($friends as $friend): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="friend-card card h-100">
                                            <div class="card-body d-flex align-items-center">
                                                <img src="<?= htmlspecialchars($friend['avatar_path'] ?? 'uploads/avatars/default.jpg') ?>" 
                                                     alt="Avatar" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1"><?= htmlspecialchars($friend['name'] ?? $friend['username']) ?></h6>
                                                    <small class="text-muted">@<?= htmlspecialchars($friend['username']) ?></small>
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
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-user-friends"></i> People You May Know</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($friend_suggestions)): ?>
                            <p class="text-muted text-center">No suggestions available</p>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($friend_suggestions as $suggestion): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="suggestion-card card h-100">
                                            <div class="card-body d-flex align-items-center">
                                                <img src="<?= htmlspecialchars($suggestion['avatar_path'] ?? 'uploads/avatars/default.jpg') ?>" 
                                                     alt="Avatar" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><?= htmlspecialchars($suggestion['name'] ?? $suggestion['username']) ?></h6>
                                                    <small class="text-muted">@<?= htmlspecialchars($suggestion['username']) ?></small>
                                                </div>
                                                <button class="btn btn-social btn-sm" onclick="sendFriendRequest(<?= $suggestion['id'] ?>)">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-bell"></i> Recent Notifications</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($notifications)): ?>
                            <p class="text-muted text-center">No notifications</p>
                        <?php else: ?>
                            <?php foreach ($notifications as $notification): ?>
                                <div class="notification-item <?= $notification['is_read'] ? '' : 'unread' ?>" 
                                     onclick="markAsRead(<?= $notification['id'] ?>)">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= htmlspecialchars($notification['sender_avatar'] ?? 'uploads/avatars/default.jpg') ?>" 
                                             alt="Avatar" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <p class="mb-1">
                                                <strong><?= htmlspecialchars($notification['sender_username'] ?? 'System') ?></strong>
                                                <?= htmlspecialchars($notification['message']) ?>
                                            </p>
                                            <small class="text-muted"><?= date('M j, Y g:i A', strtotime($notification['created_at'])) ?></small>
                                        </div>
                                        <?php if (!$notification['is_read']): ?>
                                            <span class="badge bg-warning">New</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function sendFriendRequest(receiverId) {
            fetch('profile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=send_friend_request&receiver_id=${receiverId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }

        function handleFriendRequest(requestId, action) {
            const actionMap = {
                'accept': 'accept_friend_request',
                'decline': 'decline_friend_request'
            };

            fetch('profile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=${actionMap[action]}&request_id=${requestId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }

        function markAsRead(notificationId) {
            fetch('profile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=mark_notification_read&notification_id=${notificationId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`[onclick="markAsRead(${notificationId})"]`).classList.remove('unread');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Auto-refresh notifications every 30 seconds
        setInterval(() => {
            // Only reload if no modals are open
            if (!document.querySelector('.modal.show')) {
                window.location.reload();
            }
        }, 30000);
    </script>
</body>
</html>