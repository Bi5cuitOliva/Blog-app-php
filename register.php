<?php
include("db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $conn->real_escape_string($_POST["username"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users(username , email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email,$password);

    if ($stmt->execute()) {

        header("Location:dashboard.php");
        exit();
    }else{
        echo"Error registering user" .$stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    
    .container {
        width: 100%;
        max-width: 600px;
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
    
    input[type="text"], input[type="email"], input[type="password"] {
        width: 96%;
        padding: 10px;
        margin-bottom: 15px;
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
    
    .register-link {
        text-align: center;
        margin-top: 20px;
    }
</style>
    </head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input id="username" type="text" name="username" required>

            <label for="email">Email:</label>
            <input id="email" type="email" name="email" required>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Register</button>
        </form>
        
        <div class="register-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>