<?php
session_start();
include 'db-login.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $admin_password = $_POST['admin_password'];
    $stmt = $conn->prepare("SELECT * FROM admin_login WHERE admin_id=?");
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($admin_password, $user['admin_password'])) {
            $_SESSION['admin_id'] = $admin_id;
            
            
            header("Location: admin-dash.php");
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="styleForLoginAdmin.css">
</head>
<body>
    <div class="main-container">
        <div class="form-container">
            <form method="POST">
                <h2 id='login'>Login</h2>
                <div class="input-group">
                    <label for="admin_id">Admin ID</label>
                    <input class='tb' type="text" name="admin_id" required>
                </div>
                <div class="input-group">
                    <label for="admin_password">Password</label>
                    <input class='tb' type="password" name="admin_password" required>
                </div>
                <input id='button' type="submit" value="Login">
                <p class="error-message"><?= $error ?></p>
            </form>
        </div>
    </div>
</body>
</html>
