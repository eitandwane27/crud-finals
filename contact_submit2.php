<?php
include 'db-login.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['c_name']);
    $email = $conn->real_escape_string($_POST['c_email']);
    $message = $conn->real_escape_string($_POST['c_message']);

    $sql = "INSERT INTO contact_us (c_name, c_email, c_message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['show_success'] = true;
    } else {
        $_SESSION['show_error'] = true;
    }
    $conn->close();
    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}