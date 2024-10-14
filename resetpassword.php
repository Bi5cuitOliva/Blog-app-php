<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $token = $_GET['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT * FROM users WHERE password_reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($new_password === $confirm_password && strlen($new_password) >= 8) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update the user's password
            $update_sql = "UPDATE users SET password = ?, password_reset_token = '' WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $hashed_password, $user['id']);
            $update_stmt->execute();
            
            // Clear the password reset token
            $clear_token_sql = "UPDATE users SET password_reset_token = '' WHERE id = ?";
            $clear_token_stmt = $conn->prepare($clear_token_sql);
            $clear_token_stmt->bind_param("i", $user['id']);
            $clear_token_stmt->execute();
            
            echo "Your password has been successfully reset. Please log in with your new password.";
        } else {
            echo "Passwords do not match or are too short.";
        }
    } else {
        echo "Invalid token";
    }
}
?>