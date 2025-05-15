<?php
include "db-login.php";
$id = $_GET['id'];

// Step 1: Get the photo name from user_info table
$photo = $conn->query("SELECT photo FROM user_info WHERE id=$id")->fetch_assoc()['photo'];

// Step 2: Delete the photo file from the uploads folder
if ($photo) {
    unlink("uploads/" . $photo);
}

// Step 3: Delete the records from both tables (user_info and users)
$conn->query("DELETE FROM user_info WHERE id=$id");
$conn->query("DELETE FROM users WHERE id=$id");

// Step 4: Redirect to index.php
header("Location: admin-dash.php");
exit();
?>