<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Buffering
ob_start();
include("db.php");

// Fetch contact information from the database
$sql = "SELECT * FROM contacts ORDER BY created_at DESC"; // Fetch contacts
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start outputting contact info
    echo '<div class="container mt-4">';
    echo '<h2 class="text-center">Contact Messages</h2>';
    echo '<table class="table table-bordered mt-4">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Name</th>';
    echo '<th>Email</th>';
    echo '<th>Subject</th>';
    echo '<th>Message</th>';
    echo '<th>Date</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Loop through and display each contact message
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
        echo '<td>' . htmlspecialchars($row['message']) . '</td>';
        echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<div class="container mt-4"><h2 class="text-center">No contact messages found.</h2></div>';
}

// Clean output buffer and include layout
$content = ob_get_clean();
include("layout.php");

// Close the database connection
$conn->close();
?>