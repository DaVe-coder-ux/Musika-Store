<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('User not found!'); window.history.back();</script>";
    } else {
        $user = $result->fetch_assoc();

        if (password_verify($password_input, $user['password'])) {
            $_SESSION['username'] = $username;
            unset($_SESSION['registered']); // To distinguish from registration
            header("Location: /LAB(HAHAHA)/labWeb.php");
            exit();
        } else {
            echo "<script>alert('Wrong password!'); window.history.back();</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
