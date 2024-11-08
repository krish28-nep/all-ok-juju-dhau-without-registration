<?php
include("header.php");
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="profile-container">
        <h1 class="profile-heading">User Profile</h1>
        <div class="profile-details">
            <p class="profile-item"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p class="profile-item"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p class="profile-item"><strong>Contact Number:</strong> <?php echo htmlspecialchars($contact); ?></p>
            <p class="profile-item"><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        </div>
        <div class="profile-actions">
            <a href="edit_profile.php" class="button-link">Edit Profile</a>
            <span> | </span>
            <a href="logout.php" class="button-link">Log Out</a>
            <br><br> <!-- Add some space or style as needed -->
            <!-- Link to the Delete Account page -->
            <a href="delete_account.php" class="button-link delete-link">Delete Account</a>
        </div>
    </div>
</body>
</html>
<?php include("footer.php"); ?>

