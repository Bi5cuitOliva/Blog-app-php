<?php
session_start();
include("db.php");
require_once 'vendor/autoload.php';

use Mtr\Client;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Generate a random token
        $token = bin2hex(random_bytes(32));
        
        // Update the user's password reset token
        $update_sql = "UPDATE users SET password_reset_token = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $token, $user['id']);
        $update_result = $update_stmt->execute();
        
        if (!$update_result) {
            echo "Error updating password reset token: " . $conn->error;
        } else {
            // Send email with reset link using PHPMailer and Mailtrap
            sendResetEmailPHPMailerMailtrap($user['email'], $token);
            
            echo "Check your email for password reset instructions.";
        }
    } else {
        echo "User not found";
    }
    
    $stmt->close();
    $update_stmt->close();
} else {
    // Handle GET request
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $token = $_GET['token'];
        
        if (!empty($token)) {
            $sql = "SELECT * FROM users WHERE password_reset_token = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Allow the user to change their password
                ?>
                <h2>Reset Password</h2>
                <form action="" method="post">
                    <input type="password" name="new_password" required>
                    <button type="submit">Change Password</button>
                </form>
                <?php
            } else {
                echo "Invalid token";
            }
        } else {
            echo "Token is missing";
        }
        
        $stmt->close();
    } else {
        echo "Invalid request method";
    }
}

function sendResetEmailPHPMailerMailtrap($to_email, $token) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->Port = 2525;
        $mail->SMTPAuth = true;
        $mail->Username = 'YOUR_MAILTRAP_USERNAME'; // Replace with your Mailtrap username
        $mail->Password = 'YOUR_MAILTRAP_PASSWORD'; // Replace with your Mailtrap password
        
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('your-email@example.com', 'Your App Name');
        $mail->addAddress($to_email, 'Recipient Name'); // Add a recipient
        $mail->Subject = 'Password Reset Instructions';
        $mail->Body = "
        Dear User,
        
        To reset your password, please click on the following link:
        http://127.0.0.1/Blog%20app/resetpassword.php?token=$token
        
        If you did not request this email, please ignore it.
        ";
        $mail->AltBody = 'This is a plain-text message body'; // optional
        
        $mail->send();
        
        // Log the email to Mailtrap
        $client = new Client();
        $client->setApiKey('YOUR_MAILTRAP_API_KEY'); // Replace with your Mailtrap API key
        
        $email = $client->emails()->create([
            'from' => [
                'name' => 'Your App Name',
                'email' => 'your-app-name@yourdomain.com'
            ],
            'to' => [
                'email' => $to_email,
                'name' => ''
            ],
            'subject' => 'Password Reset Instructions',
            'text' => $mail->Body,
            'html' => $mail->Body
        ]);
        
        echo "Message has been sent successfully";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$conn->close();
?>