<?php
// Run once to create a test user
$hashedPassword = password_hash("admin123", PASSWORD_DEFAULT);
echo $hashedPassword;
?>