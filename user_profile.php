<?php
@session_start();
include("database/connect.php");

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    echo "<script>alert('You need to log in first!');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Fetch user information
$name = $_SESSION['name'];

// Prepare SQL to fetch user details
$sql = "SELECT * FROM user WHERE name = '$name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $contact = $row['number'];
    $address = $row['address'];
} else {
    echo "<script>alert('Error fetching profile details.');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($contact); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>

    <a href="edit_profile.php">Edit Profile</a> | <a href="logout.php">Log Out</a>
</body>
</html>
