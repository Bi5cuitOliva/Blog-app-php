<?php
// buffering
ob_start();
include("db.php");

// SQL query to count users
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);

// Fetch the result
$total_users = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];
} else {
    $total_users = "No users found";
}

$conn->close();
?>


<div class="container-fluid">
    <header class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <h1>Dashboard</h1>
        <div>
            <button class="btn btn-primary">Add Post</button>
        </div>
    </header>

    <main class="p-3">
        <h2>Overview</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Posts</h5>
                        <p class="card-text">10</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Comments</h5>
                        <p class="card-text">50</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text"><?php echo $total_users ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h2>Recent Posts</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>How to Learn Bootstrap</td>
                    <td>2024-10-01</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>JavaScript Best Practices</td>
                    <td>2024-09-29</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</div>
</div>
<?php 
$content = ob_get_clean();
include ("layout.php");
?>