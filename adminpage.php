<?php
include_once "init.php";

// Admin access check
if (!isset($_SESSION['UserId'])) {
    header('Location: index.php');
    exit();
}

// Check if the database connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all users directly using SQL query
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Initialize an array to store fetched users
$users = [];

// Fetch users as associative array
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - All Users</title>
</head>
<body>
    <div class="admin-container">
        <h1>All Users</h1>
        <div class="users-list">
            <table>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Back Button -->
        <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
