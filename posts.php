<?php
// Start the session
session_start();
include("db.php"); // Ensure this file contains your database connection setup

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login or show an error message
    header("Location: login.php");
    exit;
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user ID from session
    $user_id = $_SESSION['user_id'];
    // Get form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_name = $_POST['author_name'];

    // Insert post into the database
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, author_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $author_name); // "isss" means one integer and three strings

    if ($stmt->execute()) {
        // Redirect to dashboard after successfully adding the post
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
        }

        .card h3 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 96%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #00A693;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Welcome to the posts page</h2>

<div class="card">
    <h3>Add a New Post</h3>
    <form action="" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        
        <label for="author_name">Author Name:</label>
        <input type="text" id="author_name" name="author_name" required>
        
        <button type="submit">Save Post</button>
    </form>
</div>

<?php
// Include footer or additional layout if necessary
$conn->close(); // Close the connection when done
?>
</body>
</html>
