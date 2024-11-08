<?php
@session_start();
include("database/connect.php");

if (isset($_POST['sign_up'])) {
    // Collecting user input
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    $contact = $_POST['userContact'];
    $address = $_POST['userAddress'];

    // Prepare the SQL query
    $sql = "INSERT INTO user (name, email, password, number, address) VALUES ('$name', '$email', '$password', '$contact', '$address')";

    // Attempt to execute the query
    if ($conn->query($sql) === TRUE) {
        // Registration successful
        echo "<script>alert('Registration successful!');</script>";
        echo "<script>window.location.href = 'index.php';</script>"; // Redirect to index.php
    } else {
        // Show error message
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

if (isset($_POST['sign_in'])) {
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];

    // Prepare SQL query
    $sql = "SELECT id, name, password FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        
        // Verify the password
        if ($storedPassword === $password) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['userid'] = $row['id']; // Set the userid in session
            echo "<script>alert('Login successful!');</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
            echo "<script>window.location.href = 'index.php';</script>"; // Redirect to index.php
        }
    } else {
        echo "<script>alert('Invalid email or password.');</script>";
        echo "<script>window.location.href = 'index.php';</script>"; // Redirect to index.php
    }
}
?>
