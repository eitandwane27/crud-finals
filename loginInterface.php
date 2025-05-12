<?php
session_start();
include 'db-login.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$patient__id = $_POST['patient__id'];
$password = $_POST['password'];
$patient_name = $_POST['patient_name'];
$stmt = $conn->prepare("SELECT * FROM users WHERE patient__id=?");
$stmt->bind_param("s", $patient__id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
$_SESSION['patient__id'] = $patient__id;
$_SESSION['patient_name'] = $user['patient_name'];
header("Location: pasok.php");
} else {
$error = "Invalid password.";
}
} else {
$error = "User not found.";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="logstyle.css">
</head>

<body>


<form method="POST">
<h2 id = 'login' style ="text-align: center;">Login</h2>
<h1>Patiend ID</h1>
 <input class = 'tb'type="text" name="patient__id" required><br><br>
<h1>Password</h1>
 <input class = 'tb' type="password" name="password" required><br><br> 

<input id = 'button' type="submit" value="Login">
</form>

<p style="color:red; text-align:center"><?= $error ?></p>
</body>
</html>