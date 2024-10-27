<?php
@session_start();
include("database/connect.php");

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    echo "<script>alert('You need to log in first!');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}

// Fetch current user data
$name = $_SESSION['name'];
$sql = "SELECT * FROM user WHERE name = '$name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $contact = $row['number'];
    $address = $row['address'];
} else {
    echo "<script>alert('Error fetching profile details.');</script>";
    echo "<script>window.location.href = 'user_profile.php';</script>";
    exit();
}

// Update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newEmail = $_POST['email'];
    $newContact = $_POST['contact'];
    $newAddress = $_POST['address'];

    $sql = "UPDATE user SET email='$newEmail', number='$newContact', address='$newAddress' WHERE name='$name'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Profile updated successfully!');</script>";
        echo "<script>window.location.href = 'user_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

        <label>Contact Number:</label>
        <input type="text" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
    <a href="user_profile.php">Back to Profile</a>
</body>
</html>
