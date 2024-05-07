<?php
// Include necessary files
include_once "init.php";
include_once 'connection.php';
include_once 'user.php'; // Assuming your User class is defined in User.php

// Define database connection parameters
$host = 'localhost'; // Assuming localhost is your host
$dbname = 'expenseman';
$username = 'root'; // Assuming 'root' is your database username
$password = ''; // Assuming no password is set

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Instantiate User class with the PDO object
    $user = new User($pdo);

    // Fetch all users with associative arrays
    $users = $user->userData(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Handle database connection error
    echo "Database connection failed: " . $e->getMessage();
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users</title>
    <!-- Include any CSS stylesheets or scripts you need -->
</head>
<body>
    <h1>Admin - Users</h1>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Registration Date</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo htmlspecialchars($user['UserId']); ?></td>
                <td><?php echo htmlspecialchars($user['Email']); ?></td>
                <td><?php echo htmlspecialchars($user['Full_Name']); ?></td>
                <td><?php echo htmlspecialchars($user['Username']); ?></td>
                <td><?php echo htmlspecialchars($user['RegDate']); ?></td>
            </tr>
        <?php } ?>
    </table>
    <!-- You can include additional HTML for styling or functionality -->
</body>
</html>
