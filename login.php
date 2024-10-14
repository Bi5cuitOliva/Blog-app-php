<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Store user ID and username in session
            $_SESSION["user_id"] = $user["id"]; // Assuming 'id' is the primary key in your users table
            $_SESSION["username"] = $user["username"];
            header("Location: dashboard.php");
            exit(); 
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Username not found";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    
    .container {
        width: 100%;
        max-width: 400px;
        margin: auto;
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    
    form {
        display: flex;
        flex-direction: column;
    }
    
    label {
        margin-bottom: 10px;
    }
    
    input[type="text"], input[type="password"] {
        width: 96%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    button:hover {
        background-color: #0056b3;
    }
    
    .forgot-password {
        text-align: center;
        margin-top: 20px;
    }
    
    .register-link {
        text-align: right;
        margin-top: 20px;
    }
</style>
        
   
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input id="username" type="text" name="username" required>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        
        <div class="forgot-password">
            <p>Forgot password? <a href="forgotpassword.php">Click here</a></p>
        </div>
        
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>
