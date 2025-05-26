<?php
session_start();         // Start the session to access session variables
session_unset();         // Unset all session variables
session_destroy();       // Destroy the session completely
header("Location: /LAB(HAHAHA)/labWeb.php"); // Redirect back to homepage
exit();                  // Stop further script execution
?>
