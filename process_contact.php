<?php
session_start();
include("database/connect.php"); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Insert the data into the database
    $query = "INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<h2>Thank you for reaching out, $name!</h2>";
        echo "<p>We have received your message and will get back to you soon.</p>";
    } else {
        echo "<h2>Sorry, there was an error while submitting your message. Please try again later.</h2>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
