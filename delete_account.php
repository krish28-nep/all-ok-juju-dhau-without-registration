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

// If the user confirms the deletion
if (isset($_POST['confirm_delete'])) {
    // Prepare SQL to delete user
    $sql = "DELETE FROM user WHERE name = '$name'";

    if ($conn->query($sql) === TRUE) {
        // Successfully deleted, so end the session
        session_unset();
        session_destroy();
        echo "<script>alert('Your account has been deleted successfully.');</script>";
        echo "<script>window.location.href = 'index.php';</script>"; // Redirect to home or login page
        exit();
    } else {
        echo "<script>alert('Error deleting account: " . $conn->error . "');</script>";
        echo "<script>window.location.href = 'user_profile.php';</script>"; // Redirect to profile page if error
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
</head>
<body>
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>

    <form method="POST" action="">
        <button type="submit" name="confirm_delete">Yes, Delete My Account</button>
        <a href="user_profile.php">Cancel</a>
    </form>
</body>
</html>
