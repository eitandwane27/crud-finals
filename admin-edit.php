<?php
include "db-login.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("
        SELECT ui.*, u.patient__id, u.patient_name
        FROM user_info ui
        JOIN users u ON ui.id = u.id
        WHERE ui.id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Information</title>
    <link rel="stylesheet" href="styleForAdmin-edit.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php if (isset($_POST['update'])): ?>
        <div class="success-message">Patient updated successfully!</div>
        <script>
            setTimeout(function() {
                window.location.href = 'admin-dash.php';
            }, 2000);
        </script>
    <?php endif; ?>

    <div class="edit-form-container">
        <h2>Edit Patient Information</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <!-- Personal Information -->
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" value="<?= htmlspecialchars($row['age']) ?>" required>
            </div>

            <div class="form-group full-width">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($row['address']) ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($row['contact']) ?>" required>
            </div>

            <!-- Medical Information -->
            <div class="form-group">
                <label for="_doc">Doctor in charge</label>
                <select id="_doc" name="_doc" required>
                    <option value="Dr. Marvin Acuin" <?= $row['_doc'] == 'Dr. Marvin Acuin' ? 'selected' : '' ?>>Dr. Marvin Acuin</option>
                    <option value="Dr. Eitan Maceda" <?= $row['_doc'] == 'Dr. Eitan Maceda' ? 'selected' : '' ?>>Dr. Eitan Maceda</option>
                    <option value="Dr. David Heard" <?= $row['_doc'] == 'Dr. David Heard' ? 'selected' : '' ?>>Dr. David Heard</option>
                    <option value="Dr. John Rey" <?= $row['_doc'] == 'Dr. John Rey' ? 'selected' : '' ?>>Dr. John Rey</option>
                </select>
            </div>

            <div class="form-group">
                <label for="_appointment">Appointment</label>
                <input type="text" id="_appointment" name="_appointment" value="<?= htmlspecialchars($row['_appointment']) ?>">
            </div>

            <div class="form-group full-width">
                <label for="_meds">Findings</label>
                <input type="text" id="_meds" name="_meds" value="<?= htmlspecialchars($row['_meds']) ?>">
            </div>

            <div class="form-group ">
                <label for="_test">Tests</label>
                <input type="text" id="_test" name="_test" value="<?= htmlspecialchars($row['_test']) ?>">
            </div>

            <!-- Account Information -->
            <div class="form-group">
                <label for="patient__id">Patient ID</label>
                <input type="text" id="patient__id" name="patient__id" value="<?= htmlspecialchars($row['patient__id']) ?>" required>
            </div>

            <div class="form-group">
                <label for="patient_name">Account Name</label>
                <input type="text" id="patient_name" name="patient_name" value="<?= htmlspecialchars($row['patient_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current">
            </div>

            <!-- Photo Upload -->
            <div class="form-group full-width">
                <label class="file-input-label" for="photo">
                    Choose Photo
                </label>
                <input type="file" id="photo" name="photo">
                <div class="image-preview">
                    <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" alt="Patient photo">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="update" class="submit-btn">Update Patient</button>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $_doc = $_POST['_doc'];
    $_appointment = $_POST['_appointment'];
    $_meds = $_POST['_meds'];
    $_test = $_POST['_test'];
    $patient__id = $_POST['patient__id'];
    $patient_name = $_POST['patient_name'];
    $password = $_POST['password'];

    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $tmp_name = $_FILES['photo']['tmp_name'];
        $upload_path = "uploads/" . basename($photo);
        move_uploaded_file($tmp_name, $upload_path);
    } else {
        $photo = $row['photo']; 
    }

    $stmt1 = $conn->prepare("
        UPDATE user_info
        SET first_name = ?, last_name = ?, age = ?, address = ?, contact = ?, _doc = ?, _appointment = ?, _meds = ?, _test = ?, photo = ?
        WHERE id = ?
    ");
    $stmt1->bind_param("ssssssssssi", $first_name, $last_name, $age, $address, $contact, $_doc, $_appointment, $_meds, $_test, $photo, $id);
    $stmt1->execute();

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt2 = $conn->prepare("
            UPDATE users
            SET patient__id = ?, patient_name = ?, password = ?
            WHERE id = ?
        ");
        $stmt2->bind_param("sssi", $patient__id, $patient_name, $hashed_password, $id);
    } else {
        $stmt2 = $conn->prepare("
            UPDATE users
            SET patient__id = ?, patient_name = ?
            WHERE id = ?
        ");
        $stmt2->bind_param("ssi", $patient__id, $patient_name, $id);
    }
    $stmt2->execute();
}
?>