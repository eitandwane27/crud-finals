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

    // If no record found, redirect with error
    if (!$row) {
        echo "<script>alert('Patient not found'); window.location.href='admin-dash.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No patient ID provided'); window.location.href='admin-dash.php';</script>";
    exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<div id="notificationSuccess" class="notification-wrapper">
    <div class="notification success">
        <div class="notification-icon">
            <i class="fas fa-check"></i>
        </div>
        <h2>Success!</h2>
        <p>Patient information updated successfully.</p>
        <div class="progress-bar">
            <div class="progress-bar-fill"></div>
        </div>
    </div>
</div>

<div id="notificationError" class="notification-wrapper">
    <div class="notification error">
        <div class="notification-icon">
            <i class="fas fa-times"></i>
        </div>
        <h2>Error!</h2>
        <p id="errorMessage">Something went wrong. Please try again.</p>
        <div class="progress-bar">
            <div class="progress-bar-fill"></div>
        </div>
    </div>
</div>

<div class="edit-form-container">
    <h2>Edit Patient Information</h2>

    <form method="POST" enctype="multipart/form-data">
        <!-- Add hidden input for ID -->
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        
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
                <option value="Dr. Eralfred Reyes" <?= $row['_doc'] == 'Dr. Eralfred Reyes' ? 'selected' : '' ?>>Dr. Eralfred Reyes</option>
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

        <!-- Vital Signs -->
        <div class="form-group">
            <label for="systolic">Systolic Blood Pressure</label>
            <input type="text" id="systolic" name="systolic" value="<?= htmlspecialchars($row['systolic']) ?>" />
        </div>

        <div class="form-group">
            <label for="diastolic">Diastolic Blood Pressure</label>
            <input type="text" id="diastolic" name="diastolic" value="<?= htmlspecialchars($row['diastolic']) ?>" />
        </div>

        <div class="form-group">
            <label for="bpm">Heart Rate (BPM)</label>
            <input type="text" id="bpm" name="bpm" value="<?= htmlspecialchars($row['bpm']) ?>" />
        </div>

        <div class="form-group">
            <label for="cholesterol">Cholesterol</label>
            <input type="text" id="cholesterol" name="cholesterol" value="<?= htmlspecialchars($row['cholesterol']) ?>" />
        </div>

        <div class="form-group">
            <label for="glucose">Glucose</label>
            <input type="text" id="glucose" name="glucose" value="<?= htmlspecialchars($row['glucose']) ?>" />
        </div>

        <div class="form-group">
            <label for="last_date">Date of Last Update</label>
            <input type="date" id="last_date" name="last_date" value="<?= htmlspecialchars($row['last_date']) ?>" />
        </div>

        <!-- Medicine Dropdowns -->
        <div class="form-group">
            <label for="med1">Medicine 1</label>
            <select id="med1" name="med1">
                <option value="">None</option>
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
                <option value="">None</option>
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
                <option value="">None</option>
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
                <option value="">None</option>
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
            <label class="file-input-label z" for="photo">Choose Photo</label>
            <input type="file" id="photo" name="photo" />
            <div class="image-preview">
                <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" alt="Patient photo" />
            </div>
        </div>

        <button type="submit" name="update" class="submit-btn">Update Patient</button>
    </form>
                
</div>

<script>
// Form field focus effects
document.querySelectorAll('input, select').forEach(item => {
    item.addEventListener('focus', function() {
        this.closest('.form-group').classList.add('focused');
    });
    item.addEventListener('blur', function() {
        if(!this.value) {
            this.closest('.form-group').classList.remove('focused');
        }
    });
});

// Add image preview functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImg = document.querySelector('.image-preview img');
            previewImg.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Show notification function
function showNotification(type, message = '') {
    const notification = document.getElementById(type === 'success' ? 'notificationSuccess' : 'notificationError');
    
    if (type === 'error' && message) {
        document.getElementById('errorMessage').textContent = message;
    }
    
    notification.classList.add('show');
    
    // Redirect after success notification
    if (type === 'success') {
        setTimeout(() => {
            window.location.href = 'admin-dash.php';
        }, 2000);
    } else {
        // Hide error notification after some time
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }
}
</script>

</body>
</html>

<?php
if (isset($_POST['update'])) {
    // Make sure we have the ID from the form
    $id = $_POST['id'];
    
    // Capture all form values
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

    // Get current photo and handle new upload if provided
    $stmtPhoto = $conn->prepare("SELECT photo FROM user_info WHERE id = ?");
    $stmtPhoto->bind_param("i", $id);
    $stmtPhoto->execute();
    $resultPhoto = $stmtPhoto->get_result();
    $currentPhotoRow = $resultPhoto->fetch_assoc();
    $photo = $currentPhotoRow['photo']; // Default to current photo

    if (!empty($_FILES['photo']['name'])) {
        $new_photo_name = basename($_FILES['photo']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $new_photo_name;
        
        // Move the file and update photo name if successful
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo = $new_photo_name;
        }
    }

    // Check for duplicate patient__id excluding the current user
    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE patient__id = ? AND id != ?");
    $stmtCheck->bind_param("si", $patient__id, $id);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        // Output JavaScript to show the error notification
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('error', 'Patient ID already exists. Please choose a different one.');
            });
        </script>";
    } else {
        // Update user_info table
        $stmt1 = $conn->prepare("
            UPDATE user_info SET
            first_name=?, last_name=?, age=?, address=?, contact=?, _sex=?, _doc=?, 
            _appointment=?, _meds=?, _test=?, photo=?, systolic=?, diastolic=?, bpm=?, 
            cholesterol=?, glucose=?, last_date=?, med1=?, med2=?, med_sched1=?, med_sched2=?
            WHERE id=?
        ");
        $stmt1->bind_param("sssssssssssssssssssssi",
            $first_name, $last_name, $age, $address, $contact,
            $_sex, $_doc, $_appointment, $_meds, $_test,
            $photo, $systolic, $diastolic, $bpm, $cholesterol, $glucose, $last_date,
            $med1, $med2, $med_sched1, $med_sched2,
            $id
        );
        $result1 = $stmt1->execute();

        // Update users table (patient__id and potentially password)
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("UPDATE users SET patient__id=?, password=? WHERE id=?");
            $stmt2->bind_param("ssi", $patient__id, $hashedPassword, $id);
        } else {
            $stmt2 = $conn->prepare("UPDATE users SET patient__id=? WHERE id=?");
            $stmt2->bind_param("si", $patient__id, $id);
        }
        $result2 = $stmt2->execute();

        // Check if both updates were successful
        if ($result1 && $result2) {
            // Output JavaScript to show success notification and redirect
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('success');
                });
            </script>";
        } else {
            // Get error details for debugging
            $error = "";
            if (!$result1) $error .= "Error updating patient info: " . $stmt1->error;
            if (!$result2) $error .= " Error updating account: " . $stmt2->error;
            
            // Output JavaScript to show the error notification
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('error', '" . addslashes($error) . "');
                });
            </script>";
        }
        
    }
    
}
?>
