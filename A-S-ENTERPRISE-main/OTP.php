<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

// Check if the user is already verified
if (isset($_SESSION['verified']) && $_SESSION['verified'] === true) {
    header("Location: index.php");
    exit();
}

// Generate a random OTP
function generateOTP($length = 6) {
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}

// Send OTP via Email using PHPMailer
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Use your SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'abhijitdey3322@gmail.com'; // Your Gmail address
        $mail->Password = 'jdzfoyglnsdvknbf'; // Your Gmail app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('placeholder@example.com', 'A S ENTERPRISE'); // Placeholder email and name
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for A S ENTERPRISE';

        $mail->Body = "
        <html>
        <body>
            <p>Dear Valued Customer,</p>

            <p>We hope this message finds you well. You are in the process of accessing a secure section of our services at A S ENTERPRISE. For your protection, we have generated a One-Time Password (OTP) to verify your identity.</p>

            <p><strong>Your OTP code is: <span style='font-size: 18px;'>$otp</span></strong></p>

            <p>Please enter this code within the next 1 minute to complete your access. If you did not initiate this request, please disregard this email.</p>

            <p>Thank you for choosing A S ENTERPRISE. We value your trust and look forward to serving you.</p>

            <p>Best Regards,<br>A S ENTERPRISE Team</p>
        </body>
        </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Set the specific email address to send the OTP
$specificEmail = 'spam92686@gmail.com';

// If form is submitted, handle the OTP generation and sending
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_otp'])) {
    $otp = generateOTP();
    
    // Store OTP in session along with expiry time
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 60; // OTP valid for 1 minute

    // Send OTP to the specific email
    $success = sendOTP($specificEmail, $otp);
    echo json_encode(['success' => $success]);
    exit();
}

// If OTP is entered, verify it
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
    $input_otp = implode('', $_POST['otp']); // Collect OTP from inputs
    $stored_otp = $_SESSION['otp'] ?? null;
    $otp_expiry = $_SESSION['otp_expiry'] ?? null;

    if ($stored_otp && $input_otp === $stored_otp) {
        if (time() <= $otp_expiry) {
            // OTP is correct and within the time limit
            $_SESSION['verified'] = true;
            unset($_SESSION['otp']);
            unset($_SESSION['otp_expiry']);
            header("Location: index.php");
            exit();
        } else {
            echo '<script>alert("OTP has expired.");</script>';
        }
    } else {
        echo '<script>alert("Invalid OTP.");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #006769;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        #welcome {
            color: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
        }
        #welcome div {
            color: white;
            font-size: 30px;
        }
        #otpForm {
            width: auto;
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .message {
            color: #555;
            font-size: 14px;
            margin-top: 10px;
        }
        .inputs {
            margin-top: 20px;
        }
        .inputs input {
            width: 40px;
            height: 40px;
            text-align: center;
            border: 1px solid #ccc;
            margin: 0 5px;
            font-size: 20px;
        }
        .inputs input:focus {
            border-color: #007bff;
            outline: none;
        }
        .action {
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        .hidden {
            display: none;
        }
        .timer {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }
        .progress-container {
            width: 100%;
            height: 5px;
            background: #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }
        .progress-bar {
            height: 100%;
            width: 0;
            background: #007bff;
            border-radius: 5px;
            transition: width 0.5s;
        }
        .button {
            padding: 15px 20px;
            font-size: 20px;
            font-weight: 700;
            background: transparent;
            border: none;
            position: relative;
            color: #f0f0f0;
            z-index: 1;
            width: 200px;
        }

        .button::after,
        .button::before {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            z-index: -99999;
            transition: all .4s;
        }

        .button::before {
            transform: translate(0%, 0%);
            width: 100%;
            height: 100%;
            background: #28282d;
            border-radius: 10px;
        }

        .button::after {
            transform: translate(10px, 10px);
            width: 35px;
            height: 35px;
            background: #ffffff15;
            backdrop-filter: blur(5px);
            border-radius: 50px;
        }

        .button:hover::before {
            transform: translate(5%, 20%);
            width: 110%;
            height: 110%;
        }

        .button:hover::after {
            border-radius: 10px;
            transform: translate(0, 0);
            width: 100%;
            height: 100%;
        }

        .button:active::after {
            transition: 0s;
            transform: translate(0, 5%);
        }
    </style>
</head>
<body>
    <div id="welcome" class="container">
        <div class="title">Welcome to A S ENTERPRISE</div>
        <button id="verifyButton" class="action button" onclick="sendOTP()">Verify</button>
    </div>
    <div id="otpForm" class="hidden container">
        <div class="title">OTP Verification Code</div>
        <p class="message">We have sent a verification code to your email.</p>
        <form method="post" action="">
            <div class="inputs">
                <input type="text" name="otp[]" maxlength="1" required>
                <input type="text" name="otp[]" maxlength="1" required>
                <input type="text" name="otp[]" maxlength="1" required>
                <input type="text" name="otp[]" maxlength="1" required>
                <input type="text" name="otp[]" maxlength="1" required>
                <input type="text" name="otp[]" maxlength="1" required>
            </div>
            <button type="submit" class="action button">Submit OTP</button>
            <p id="timer" class="timer"></p>
            <div class="progress-container">
                <div id="progressBar" class="progress-bar"></div>
            </div>
        </form>
    </div>

    <script>
        function sendOTP() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('welcome').classList.add('hidden');
                        document.getElementById('otpForm').classList.remove('hidden');
                        startTimer();
                        startProgressBar();
                    } else {
                        alert('Failed to send OTP. Please try again.');
                    }
                }
            };
            xhr.send('send_otp=1');
        }

        function startTimer() {
            var timer = document.getElementById('timer');
            var timeLeft = 60;
            timer.textContent = '1:00';

            var interval = setInterval(function() {
                timeLeft--;
                var minutes = Math.floor(timeLeft / 60);
                var seconds = timeLeft % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                timer.textContent = minutes + ':' + seconds;

                if (timeLeft <= 0) {
                    clearInterval(interval);
                    timer.textContent = 'Time expired';
                    // Optionally, disable the OTP form here
                }
            }, 1000);
        }

        function startProgressBar() {
            var progressBar = document.getElementById('progressBar');
            var progress = 0;
            var interval = setInterval(function() {
                progress += 100 / 60; // 60 seconds duration
                progressBar.style.width = progress + '%';
                if (progress >= 100) {
                    clearInterval(interval);
                }
            }, 1000);
        }

        document.querySelectorAll('.inputs input').forEach((input, index, inputs) => {
            input.addEventListener('keyup', (event) => {
                if (event.target.value.length >= event.target.maxLength) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });
        });
    </script>
</body>
</html>
