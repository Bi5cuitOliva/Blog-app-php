<?php
// buffering
ob_start();
include("db.php");

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = $conn->query("SELECT title, content, created_at FROM posts WHERE id = $post_id");

if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
} else {
    // Handle the case where the post is not found
    echo "<h2>Post not found.</h2>";
    exit;
}
?>

<div id="colorlib-main">
    <section class="ftco-section">
        <div class="container">
            <h2 class="mb-4"><?php echo htmlspecialchars($post['title']); ?></h2>
            <p><i class="icon-calendar mr-2"></i><?php echo date("F j, Y", strtotime($post['created_at'])); ?></p>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <p><a href="index.php" class="btn-custom">Back to Blog </a></p>
        </div>
    </section>
</div>

<?php 
$content = ob_get_clean();
include ("frontlayout.php");
?>
