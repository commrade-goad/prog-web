<?php
session_start(); // Start the session
if (isset($_SESSION["start"]) && $_SESSION["start"] == true) {
    session_destroy(); // Destroy all session data
    header("Location: /login"); // Redirect to the login page or any other page after logout
    exit();
} else {
    header("Location: /login"); // Redirect to the login page or any other page after logout
}
?>
