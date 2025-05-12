<?php

session_start();
if (!isset($_SESSION['patient_name'])) {
header("Location: loginInterface.php");
exit();
}
?>
<h2>Welcome, <?= $_SESSION['patient_name'] ?>!</h2>
<p><a href="landingPage2.html">Continue</a></p>