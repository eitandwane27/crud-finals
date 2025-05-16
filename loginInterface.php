<?php
session_start();
include 'db-login.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient__id = $_POST['patient__id'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE patient__id=?");
    $stmt->bind_param("s", $patient__id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['patient__id'] = $patient__id;
            $_SESSION['patient_name'] = $user['patient_name'];
            $_SESSION['id'] = $user['id'];
            header("Location: pasok.php");
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User  not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <link rel="stylesheet" href="styleForLogin.css">
</head>
<body>

    <img src="pics/cfaaa2b2-6d00-4776-8998-9a0f254d532b-removebg-preview.png" alt="">
    <div class="main-container">
        <div class="form-container">
            <form method="POST">
                <h2 id='login'>Login</h2>
                <div class="input-group">
                    <label for="patient__id">Patient ID</label>
                    <input class='tb' type="text" name="patient__id" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input class='tb' type="password" name="password" required>
                </div>
                <input id='button' type="submit" value="Login">
                <p class="error-message"><?= $error ?></p>
            </form>
        </div>
        
    </div>
</body>
</html>
