<?php 
// Include database connection
include "db-login.php"; 

// Initialize variables for success/error messages
$success_message = '';
$error_message = '';

// Handle form submission
if (isset($_POST['submit'])) {
    // Collect form inputs with proper sanitization
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
    $address = htmlspecialchars($_POST['address']);
    $contact = htmlspecialchars($_POST['contact']);
    $_sex = isset($_POST['_sex']) ? htmlspecialchars($_POST['_sex']) : '';
    $_doc = htmlspecialchars($_POST['_doc']);
    $_appointment = htmlspecialchars($_POST['_appointment']);
    $_meds = htmlspecialchars($_POST['_meds']);
    $_test = htmlspecialchars($_POST['_test']);
    $systolic = htmlspecialchars($_POST['systolic']);
    $diastolic = htmlspecialchars($_POST['diastolic']);
    $bpm = htmlspecialchars($_POST['bpm']);
    $cholesterol = htmlspecialchars($_POST['cholesterol']);
    $glucose = htmlspecialchars($_POST['glucose']);
    $last_date = htmlspecialchars($_POST['last_date']);
    $patient__id = htmlspecialchars($_POST['patient__id']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $med1 = htmlspecialchars($_POST['med1']);
    $med2 = htmlspecialchars($_POST['med2']);
    $med_sched1 = htmlspecialchars($_POST['med_sched1']);
    $med_sched2 = htmlspecialchars($_POST['med_sched2']);

    // Handle file upload
    $photo = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $upload_path = "uploads/" . basename($photo);

    // Check if patient__id already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE patient__id = ?");
    $check_stmt->bind_param("s", $patient__id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
         $error_message = " Patient ID already exists. Please choose a different one.";
    } else {
        // Proceed only if image upload is successful
        if (move_uploaded_file($tmp_name, $upload_path)) {
            // Insert into user_info table
            $stmt1 = $conn->prepare("
                INSERT INTO user_info (
                    first_name, last_name, age, address, contact, _sex, _doc, _appointment,
                    _meds, _test, systolic, diastolic, bpm, cholesterol, glucose, last_date, photo,
                    med1, med2, med_sched1, med_sched2
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt1->bind_param(
                "sssssssssssssssssssss",
                $first_name, $last_name, $age, $address, $contact, $_sex, $_doc, $_appointment,
                $_meds, $_test, $systolic, $diastolic, $bpm, $cholesterol, $glucose, $last_date, $photo,
                $med1, $med2, $med_sched1, $med_sched2
            );

            if ($stmt1->execute()) {
                $last_id = $conn->insert_id;

                $stmt2 = $conn->prepare("INSERT INTO users (id, patient__id, password) VALUES (?, ?, ?)");
                $stmt2->bind_param("iss", $last_id, $patient__id, $hashed_password);

                if ($stmt2->execute()) {
                    $success_message = " Patient registered successfully! Redirecting...";
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'admin-dash.php';
                        }, 2000);
                    </script>";
                } else {
                    $error_message = "Error inserting into users: " . $conn->error;
                }
            } else {
                $error_message = "Error inserting into user_info: " . $conn->error;
            }
        } else {
            $error_message = "Failed to upload image.";
        }
    }

    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modern Patient Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="styleForAdmin-add.css" />
</head>
<body>
<div class="form-container">
    <?php if (!empty($success_message)): ?>
    <div class="notification success"><i class="fas fa-check-circle"></i> <?= $success_message ?></div>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <div class="notification error"><i class="fas fa-exclamation-circle"></i> <?= $error_message ?></div>
<?php endif; ?>


    <form action="" method="POST" enctype="multipart/form-data" class="glass-form">
        <h1 class="form-title">New Patient Registration</h1>

        <div class="form-row">
            <div class="form-group"><label for="first_name"><i class="fas fa-user"></i> First Name</label><input type="text" id="first_name" name="first_name" required /></div>
            <div class="form-group"><label for="last_name"><i class="fas fa-user"></i> Last Name</label><input type="text" id="last_name" name="last_name" required /></div>
        </div>

        <div class="form-row">
            <div class="form-group"><label for="age"><i class="fas fa-birthday-cake"></i> Age</label><input type="number" id="age" name="age" required /></div>
            <div class="form-group"><label for="address"><i class="fas fa-map-marker-alt"></i> Address</label><input type="text" id="address" name="address" required /></div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label><i class="fas fa-venus-mars"></i> Sex</label>
                <div class="radio-group">
                    <label><input type="radio" name="_sex" value="M" required /> Male</label>
                    <label><input type="radio" name="_sex" value="F" required /> Female</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="_doc"><i class="fas fa-user-md"></i> Assigned Doctor</label>
                <select id="_doc" name="_doc" required>
                    <option value="" disabled selected>Select doctor</option>
                    <option value="Dr. Marvin Acuin">Dr. Marvin Acuin</option>
                    <option value="Dr. Eitan Maceda">Dr. Eitan Maceda</option>
                    <option value="Dr. David Heard">Dr. David Heard</option>
                    <option value="Dr. John Marcellana">Dr. John Marcellana</option>
                    <option value="Dr. Earlfred Reyes">Dr. Earlfred Reyes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="_appointment"><i class="fas fa-calendar-check"></i> Appointment Number</label>
                <input type="number" id="_appointment" name="_appointment" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="systolic"><i class="fas fa-heartbeat"></i> Systolic</label>
                <input type="number" id="systolic" name="systolic" required />
            </div>
            <div class="form-group">
                <label for="diastolic"><i class="fas fa-heartbeat"></i> Diastolic</label>
                <input type="number" id="diastolic" name="diastolic" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group"><label for="bpm"><i class="fas fa-heart"></i> Heart Rate (BPM)</label><input type="number" id="bpm" name="bpm" required /></div>
        </div>

        <div class="form-row">
            <div class="form-group"><label for="cholesterol"><i class="fas fa-vial"></i> Cholesterol</label><input type="number" id="cholesterol" name="cholesterol" required /></div>
            <div class="form-group"><label for="glucose"><i class="fas fa-syringe"></i> Glucose</label><input type="number" id="glucose" name="glucose" required /></div>
        </div>

        <div class="form-row">
            <div class="form-group"><label for="last_date"><i class="fas fa-calendar-day"></i> Last Checkup Date</label><input type="date" id="last_date" name="last_date" required /></div>
        </div>

        <div class="form-row">
            <div class="form-group"><label for="patient__id"><i class="fas fa-id-card"></i> Patient ID</label><input type="text" id="patient__id" name="patient__id" required /></div>
            <div class="form-group"><label for="password"><i class="fas fa-lock"></i> Password</label><input type="password" id="password" name="password" required /></div>
        </div>

        <div class="form-row">
            <div class="form-group"><label for="contact"><i class="fas fa-phone"></i> Contact Number</label><input type="text" id="contact" name="contact" required /></div>
        </div>

        <div class="form-group"><label for="_meds"><i class="fas fa-notes-medical"></i> Medical Findings</label><textarea id="_meds" name="_meds" rows="3"></textarea></div>
        <div class="form-group"><label for="_test"><i class="fas fa-vial"></i> Required Tests</label><textarea id="_test" name="_test" rows="3"></textarea></div>

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

        <div class="form-group">
            <label for="photo"><i class="fas fa-image"></i> Upload Photo</label>
            <input type="file" id="photo" name="photo" accept="image/*" required />
        </div>

        <button type="submit" name="submit" class="submit-btn">Register Patient</button>
    </form>
</div>
<script>
    setTimeout(() => {
        const notif = document.querySelector('.notification');
        if (notif) {
            notif.classList.add('hide');
            setTimeout(() => notif.remove(), 500); // remove after fade
        }
    }, 1000); // show for 1s
</script>



</body>
</html>
