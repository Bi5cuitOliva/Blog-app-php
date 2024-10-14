<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Buffering
ob_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and escape special characters
    $mission = $conn->real_escape_string(trim($_POST['mission']));
    $what_we_do = $conn->real_escape_string(trim($_POST['what_we_do']));

    // Prepare the SQL statement
    $sql = "INSERT INTO aboutus (mission, what_we_do) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Prepare error: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("ss", $mission, $what_we_do);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to a thank you page or display a success message
        header("Location: dashboard.php"); // Adjust the redirect as needed
        exit();
    } else {
        echo "Error sending message: " . htmlspecialchars($stmt->error);
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>


        <!-- content -->
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <h2 class="text-center mb-4">About Us</h2>
        <form action="about.php" method="POST"> 
            <div class="form-group">
                <label for="mission">Mission</label>
                <textarea class="form-control" id="mission" name="mission" rows="3" placeholder="Enter your mission" required></textarea>
            </div>
            <div class="form-group">
                <label for="what_we_do">What We Do</label>
                <textarea class="form-control" id="what_we_do" name="what_we_do" rows="5" placeholder="Describe what we do" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>
</div>


<?php
$content = ob_get_clean();
include("layout.php");
?>