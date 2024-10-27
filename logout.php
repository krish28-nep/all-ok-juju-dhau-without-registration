<?php
@session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session
echo "<script>alert('You have been logged out successfully.');</script>";
echo "<script>window.location.href = 'index.php';</script>"; // Redirect to login page
?>
