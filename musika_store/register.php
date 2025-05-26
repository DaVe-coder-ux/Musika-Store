<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $fname = $_POST['name'];
    $lname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    // Updated Regex patterns
    $email_pattern = '/^[^\s@]+@(gmail|edu)\.com$/'; // no spaces allowed in email
    $password_pattern = '/^(?=\S{6,})(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).*$/'; // at least 6 chars, no spaces, with 1 uppercase, 1 number, 1 special char

    $errors = [];

    if (!preg_match($email_pattern, $email)) {
        $errors[] = "Email must end with @gmail.com or @edu.com and must not contain spaces";
    }

    if (!preg_match($password_pattern, $password_input)) {
        $errors[] = "Password must be at least 6 characters, contain at least one uppercase letter, one number, one special character, and no spaces";
    }

    // Check if user already exists by email or username
    $check_sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $email, $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $errors[] = "You have already signed in. Please login instead.";
    }
    $check_stmt->close();

    if (!empty($errors)) {
        echo "<script>";
        foreach ($errors as $error) {
            echo "alert('$error');";
        }
        echo "window.history.back();</script>";
        exit;
    }

    // Continue if no errors
    $password = password_hash($password_input, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, first_name, last_name, birthdate, username, password)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $email, $fname, $lname, $birthdate, $username, $password);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['registered'] = true; // for hello message
        header("Location: /LAB(HAHAHA)/labWeb.php");
        exit();
    } else {
        echo "<script>alert('Registration failed: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
