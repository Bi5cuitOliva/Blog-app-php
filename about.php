<?php

// Buffering
ob_start();
include("db.php");

// Fetch contact information from the database
$sql = "SELECT * FROM aboutus ORDER BY created_at DESC"; // Fetch about
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-card {
            border: none; /* Remove default border */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Add a shadow */
            transition: transform 0.2s; /* Add transition for hover effect */
        }

        .custom-card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
        }

        .card-title {
            font-size: 1.5rem; /* Larger title font */
            color: #007bff; /* Custom color for title */
        }

        .card-text {
            font-size: 1rem; /* Custom text size */
            color: #333; /* Darker text color */
        }
    </style>
    <title>About Us</title>
</head>
<body>

<?php
if ($result->num_rows > 0) {
    // Start outputting contact info
    echo '<div class="container mt-4">';
    echo '<h2 class="text-center">About Us</h2>';
    echo '<div class="row justify-content-center mt-4">'; // Center the row

    // Loop through and display each contact message in a card
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card custom-card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['mission']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($row['what_we_do']) . '</p>';
        echo '<p class="card-text"><small class="text-muted">Date: ' . htmlspecialchars($row['created_at']) . '</small></p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>'; // Close row
    echo '</div>'; // Close container
} else {
    echo '<div class="container mt-4"><h2 class="text-center">No about messages found.</h2></div>';
}
?>

<div id="colorlib-page">
    <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
    <aside id="colorlib-aside" role="complementary" class="js-fullheight">
        <nav id="colorlib-main-menu" role="navigation">
            <ul>
                <li class="colorlib-active"><a href="index.php">Home</a></li>
                <li><a href="fashion.html">Fashion</a></li>
                <li><a href="travel.html">Travel</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>

        <div class="colorlib-footer">
            <h1 id="colorlib-logo" class="mb-4"><a href="index.html" style="background-image: url(images/bg_1.jpg);">Andrea <span>Moore</span></a></h1>
            <div class="mb-4">
                <h3>Subscribe for newsletter</h3>
                <form action="#" class="colorlib-subscribe-form">
                    <div class="form-group d-flex">
                        <div class="icon"><span class="icon-paper-plane"></span></div>
                        <input type="text" class="form-control" placeholder="Enter Email Address">
                    </div>
                </form>
            </div>
            <p class="pfooter">
                Copyright &copy;<script>
                    document.write(new Date().getFullYear());
                </script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            </p>
        </div>
    </aside> <!-- END COLORLIB-ASIDE -->

<?php
// Clean output buffer and include layout
$content = ob_get_clean();
include("frontlayout.php");

// Close the database connection
$conn->close();
?>
</body>
</html>
