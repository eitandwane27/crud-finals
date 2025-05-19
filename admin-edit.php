<?php
include "db-login.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("
        SELECT ui.*, u.patient__id
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Patient Information</title>
    <link rel="stylesheet" href="styleForAdmin-edit.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body>
<?php if (isset($_POST['update'])): ?>
    <div class="success-message">Patient updated successfully!</div>
    <script>
        setTimeout(() => window.location.href = 'admin-dash.php', 2000);
    </script>
<?php endif; ?>

<div class="edit-form-container">
    <h2>Edit Patient Information</h2>

    <form method="POST" enctype="multipart/form-data">
        <!-- Personal Information -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>" required />
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>" required />
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($row['age']) ?>" required />
        </div>

        <div class="form-group full-width">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($row['address']) ?>" required />
        </div>

        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($row['contact']) ?>" required />
        </div>

        <div class="form-group">
            <label>Sex</label>
            <div class="radio-group">
                <label><input type="radio" name="_sex" value="M" <?= ($row['_sex'] === 'M') ? 'checked' : '' ?> /> Male</label>
                <label><input type="radio" name="_sex" value="F" <?= ($row['_sex'] === 'F') ? 'checked' : '' ?> /> Female</label>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="form-group">
            <label for="_doc">Doctor in charge</label>
            <select id="_doc" name="_doc" required>
                <option value="Dr. Marvin Acuin" <?= $row['_doc'] == 'Dr. Marvin Acuin' ? 'selected' : '' ?>>Dr. Marvin Acuin</option>
                <option value="Dr. Eitan Maceda" <?= $row['_doc'] == 'Dr. Eitan Maceda' ? 'selected' : '' ?>>Dr. Eitan Maceda</option>
                <option value="Dr. David Heard" <?= $row['_doc'] == 'Dr. David Heard' ? 'selected' : '' ?>>Dr. David Heard</option>
                <option value="Dr. John Marcellana" <?= $row['_doc'] == 'Dr. John Marcellana' ? 'selected' : '' ?>>Dr. John Marcellana</option>
                <option value="Dr. Eralfred Reyes" <?= $row['_doc'] == 'Dr. Dr. Eralfred Reyes' ? 'selected' : '' ?>>Dr. Dr. Eralfred Reyes</option>
            </select>
        </div>

        <div class="form-group">
            <label for="_appointment">Appointment</label>
            <input type="text" id="_appointment" name="_appointment" value="<?= htmlspecialchars($row['_appointment']) ?>" />
        </div>

        <div class="form-group full-width">
            <label for="_meds">Findings</label>
            <input type="text" id="_meds" name="_meds" value="<?= htmlspecialchars($row['_meds']) ?>" />
        </div>

        <div class="form-group">
            <label for="_test">Tests</label>
            <input type="text" id="_test" name="_test" value="<?= htmlspecialchars($row['_test']) ?>" />
        </div>

        <!-- New Vital Signs -->
        <div class="form-group">
            <label for="systolic">Systolic Blood Pressure</label>
            <input type="text" id="systolic" name="systolic" value="<?= htmlspecialchars($row['systolic'] ?? '') ?>" />
        </div>

        <div class="form-group">
            <label for="diastolic">Diastolic Blood Pressure</label>
            <input type="text" id="diastolic" name="diastolic" value="<?= htmlspecialchars($row['diastolic'] ?? '') ?>" />
        </div>

        <div class="form-group">
            <label for="bpm">Heart Rate (BPM)</label>
            <input type="text" id="bpm" name="bpm" value="<?= htmlspecialchars($row['bpm'] ?? '') ?>" />
        </div>

        <div class="form-group">
            <label for="cholesterol">Cholesterol</label>
            <input type="text" id="cholesterol" name="cholesterol" value="<?= htmlspecialchars($row['cholesterol'] ?? '') ?>" />
        </div>

        <div class="form-group">
            <label for="glucose">Glucose</label>
            <input type="text" id="glucose" name="glucose" value="<?= htmlspecialchars($row['glucose'] ?? '') ?>" />
        </div>

        <div class="form-group">
            <label for="last_date">Date of Last Update</label>
            <input type="date" id="last_date" name="last_date" value="<?= htmlspecialchars($row['last_date'] ?? '') ?>" />
        </div>

        <!-- New Medicine Dropdowns -->
        <div class="form-group">
            <label for="med1">Medicine 1</label>
            <select id="med1" name="med1">
                <?php
                $meds = ["Bioflu 10mg", "Bioflu 20mg", "Paracetamol 500mg", "Paracetamol 650mg",
                         "Amoxicillin 250mg", "Amoxicillin 500mg", "Ibuprofen 200mg", "Ibuprofen 400mg",
                         "Cetirizine 5mg", "Cetirizine 10mg", "Loperamide 2mg", "Loperamide 4mg",
                         "Mefenamic Acid 250mg", "Mefenamic Acid 500mg", "Antacid 100mg", "Antacid 200mg",
                         "Omeprazole 20mg", "Omeprazole 40mg", "Salbutamol 2mg", "Salbutamol 4mg"];
                foreach ($meds as $med) {
                    $selected = ($row['med1'] ?? '') === $med ? 'selected' : '';
                    echo "<option value=\"$med\" $selected>$med</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="med2">Medicine 2</label>
            <select id="med2" name="med2">
                <?php
                foreach ($meds as $med) {
                    $selected = ($row['med2'] ?? '') === $med ? 'selected' : '';
                    echo "<option value=\"$med\" $selected>$med</option>";
                }
                ?>
            </select>
        </div>

        <!-- Medicine Schedules -->
        <div class="form-group">
            <label for="med_sched1">Medicine 1 Schedule</label>
            <select id="med_sched1" name="med_sched1">
                <?php
                $times = [];
                for ($h = 0; $h < 24; $h++) {
                    foreach ([0, 30] as $m) {
                        $time = sprintf("%02d:%02d %s", ($h % 12) ?: 12, $m, $h < 12 ? "AM" : "PM");
                        $times[] = $time;
                    }
                }
                foreach ($times as $time) {
                    $selected = ($row['med_sched1'] ?? '') === $time ? 'selected' : '';
                    echo "<option value=\"$time\" $selected>$time</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="med_sched2">Medicine 2 Schedule</label>
            <select id="med_sched2" name="med_sched2">
                <?php
                foreach ($times as $time) {
                    $selected = ($row['med_sched2'] ?? '') === $time ? 'selected' : '';
                    echo "<option value=\"$time\" $selected>$time</option>";
                }
                ?>
            </select>
        </div>

        <!-- Account Information -->
        <div class="form-group">
            <label for="patient__id">Patient ID</label>
            <input type="text" id="patient__id" name="patient__id" value="<?= htmlspecialchars($row['patient__id']) ?>" required />
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current" />
        </div>

        <!-- Photo Upload -->
        <div class="form-group full-width">
            <label class="file-input-label" for="photo">Choose Photo</label>
            <input type="file" id="photo" name="photo" />
            <div class="image-preview">
                <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" alt="Patient photo" />
            </div>
        </div>

        <button type="submit" name="update" class="submit-btn">Update Patient</button>
    </form>
</div>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    // Capture all values
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $_sex = $_POST['_sex'];
    $_doc = $_POST['_doc'];
    $_appointment = $_POST['_appointment'];
    $_meds = $_POST['_meds'];
    $_test = $_POST['_test'];
    $patient__id = $_POST['patient__id'];
    $password = $_POST['password'];

    $systolic = $_POST['systolic'];
    $diastolic = $_POST['diastolic'];
    $bpm = $_POST['bpm'];
    $cholesterol = $_POST['cholesterol'];
    $glucose = $_POST['glucose'];
    $last_date = $_POST['last_date'];

    $med1 = $_POST['med1'];
    $med2 = $_POST['med2'];
    $med_sched1 = $_POST['med_sched1'];
    $med_sched2 = $_POST['med_sched2'];

    $photo = $row['photo'];
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . basename($photo));
    }

    // Check for duplicate patient__id except for current user
    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE patient__id = ? AND id != ?");
    $stmtCheck->bind_param("si", $patient__id, $id);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        echo "<script>alert('Patient ID already exists. Please choose a different one.');</script>";
    } else {
        // Update user_info
        $stmt1 = $conn->prepare("
            UPDATE user_info SET
            first_name=?, last_name=?, age=?, address=?, contact=?, _sex=?, _doc=?, _appointment=?, _meds=?, _test=?,
            photo=?, systolic=?, diastolic=?, bpm=?, cholesterol=?, glucose=?, last_date=?, 
            med1=?, med2=?, med_sched1=?, med_sched2=?
            WHERE id=?
        ");
        $stmt1->bind_param("sssssssssssssssssssssi",
            $first_name, $last_name, $age, $address, $contact,
            $_sex, $_doc, $_appointment, $_meds, $_test,
            $photo, $systolic, $diastolic, $bpm, $cholesterol, $glucose, $last_date,
            $med1, $med2, $med_sched1, $med_sched2,
            $id
        );
        $stmt1->execute();

        // Update users (patient__id and password)
        if (empty($password)) {
            $stmt2 = $conn->prepare("UPDATE users SET patient__id=? WHERE id=?");
            $stmt2->bind_param("si", $patient__id, $id);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("UPDATE users SET patient__id=?, password=? WHERE id=?");
            $stmt2->bind_param("ssi", $patient__id, $hashedPassword, $id);
        }
        $stmt2->execute();

        echo "<script>alert('Patient updated successfully!'); window.location.href='admin-dash.php';</script>";
        exit;
    }
}
?>
