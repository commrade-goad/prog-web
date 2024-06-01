<?php
session_start(); // Start the session
session_destroy(); // Destroy all session data
header("Location: index.php"); // Redirect to the login page or any other page after logout
exit();
?>
