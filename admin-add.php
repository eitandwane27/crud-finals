<?php 
// Include database connection
include "db-login.php"; 

// Initialize variables
$form_data = []; // To store form input values

// Handle form submission
if (isset($_POST['submit'])) {
    // Store all form data to use if we need to redisplay the form
    $form_data = $_POST;
    
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
    $has_photo = !empty($_FILES['photo']['name']);

    // Check if patient__id already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE patient__id = ?");
    $check_stmt->bind_param("s", $patient__id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Output JavaScript to show the error notification
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('error', 'Patient ID already exists. Please choose a different one.');
            });
        </script>";
    } else if (!$has_photo) {
        // Output JavaScript to show the error notification
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('error', 'Please select a photo for the patient.');
            });
        </script>";
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
            $result1 = $stmt1->execute();

            if ($result1) {
                $last_id = $conn->insert_id;

                $stmt2 = $conn->prepare("INSERT INTO users (id, patient__id, password) VALUES (?, ?, ?)");
                $stmt2->bind_param("iss", $last_id, $patient__id, $hashed_password);
                $result2 = $stmt2->execute();

                if ($result2) {
                    // Clear form data on success
                    $form_data = [];
                    
                    // Output JavaScript to show success notification and redirect
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showNotification('success');
                        });
                    </script>";
                } else {
                    // Get error details for debugging
                    $error = "Error inserting into users: " . $conn->error;
                    
                    // Output JavaScript to show the error notification
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showNotification('error', '" . addslashes($error) . "');
                        });
                    </script>";
                }
            } else {
                // Get error details for debugging
                $error = "Error inserting into user_info: " . $conn->error;
                
                // Output JavaScript to show the error notification
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('error', '" . addslashes($error) . "');
                    });
                </script>";
            }
        } else {
            // Output JavaScript to show the error notification
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('error', 'Failed to upload image.');
                });
            </script>";
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

<!-- Success Notification -->
<div id="notificationSuccess" class="notification-wrapper">
    <div class="notification success">
        <div class="notification-icon">
            <i class="fas fa-check"></i>
        </div>
        <h2>Success!</h2>
        <p>Patient registered successfully!</p>
        <div class="progress-bar">
            <div class="progress-bar-fill"></div>
        </div>
    </div>
</div>

<!-- Error Notification -->
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

<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data" class="glass-form">
        <h1 class="form-title">New Patient Registration</h1>

        <div class="form-row">
            <div class="form-group">
                <label for="first_name"><i class="fas fa-user"></i> First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?= isset($form_data['first_name']) ? htmlspecialchars($form_data['first_name']) : '' ?>" required />
            </div>
            <div class="form-group">
                <label for="last_name"><i class="fas fa-user"></i> Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?= isset($form_data['last_name']) ? htmlspecialchars($form_data['last_name']) : '' ?>" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="age"><i class="fas fa-birthday-cake"></i> Age</label>
                <input type="number" id="age" name="age" value="<?= isset($form_data['age']) ? htmlspecialchars($form_data['age']) : '' ?>" required />
            </div>
            <div class="form-group">
                <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                <input type="text" id="address" name="address" value="<?= isset($form_data['address']) ? htmlspecialchars($form_data['address']) : '' ?>" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label><i class="fas fa-venus-mars"></i> Sex</label>
                <div class="radio-group">
                    <label><input type="radio" name="_sex" value="M" <?= (isset($form_data['_sex']) && $form_data['_sex'] === 'M') ? 'checked' : '' ?> required /> Male</label>
                    <label><input type="radio" name="_sex" value="F" <?= (isset($form_data['_sex']) && $form_data['_sex'] === 'F') ? 'checked' : '' ?> required /> Female</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="_doc"><i class="fas fa-user-md"></i> Assigned Doctor</label>
                <select id="_doc" name="_doc" required>
                    <option value="" disabled <?= !isset($form_data['_doc']) ? 'selected' : '' ?>>Select doctor</option>
                    <option value="Dr. Marvin Acuin" <?= (isset($form_data['_doc']) && $form_data['_doc'] === 'Dr. Marvin Acuin') ? 'selected' : '' ?>>Dr. Marvin Acuin</option>
                    <option value="Dr. Eitan Maceda" <?= (isset($form_data['_doc']) && $form_data['_doc'] === 'Dr. Eitan Maceda') ? 'selected' : '' ?>>Dr. Eitan Maceda</option>
                    <option value="Dr. David Heard" <?= (isset($form_data['_doc']) && $form_data['_doc'] === 'Dr. David Heard') ? 'selected' : '' ?>>Dr. David Heard</option>
                    <option value="Dr. John Marcellana" <?= (isset($form_data['_doc']) && $form_data['_doc'] === 'Dr. John Marcellana') ? 'selected' : '' ?>>Dr. John Marcellana</option>
                    <option value="Dr. Earlfred Reyes" <?= (isset($form_data['_doc']) && $form_data['_doc'] === 'Dr. Earlfred Reyes') ? 'selected' : '' ?>>Dr. Earlfred Reyes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="_appointment"><i class="fas fa-calendar-check"></i> Appointment Number</label>
                <input type="number" id="_appointment" name="_appointment" value="<?= isset($form_data['_appointment']) ? htmlspecialchars($form_data['_appointment']) : '' ?>" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="systolic"><i class="fas fa-heartbeat"></i> Systolic</label>
                <input type="number" id="systolic" name="systolic" value="<?= isset($form_data['systolic']) ? htmlspecialchars($form_data['systolic']) : '' ?>" required />
            </div>
            <div class="form-group">
                <label for="diastolic"><i class="fas fa-heartbeat"></i> Diastolic</label>
                <input type="number" id="diastolic" name="diastolic" value="<?= isset($form_data['diastolic']) ? htmlspecialchars($form_data['diastolic']) : '' ?>" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="bpm"><i class="fas fa-heart"></i> Heart Rate (BPM)</label>
                <input type="number" id="bpm" name="bpm" value="<?= isset($form_data['bpm']) ? htmlspecialchars($form_data['bpm']) : '' ?>" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="cholesterol"><i class="fas fa-vial"></i> Cholesterol</label>
                <input type="number" id="cholesterol" name="cholesterol" value="<?= isset($form_data['cholesterol']) ? htmlspecialchars($form_data['cholesterol']) : '' ?>" required />
            </div>
            <div class="form-group">
                <label for="glucose"><i class="fas fa-syringe"></i> Glucose</label>
                <input type="number" id="glucose" name="glucose" value="<?= isset($form_data['glucose']) ? htmlspecialchars($form_data['glucose']) : '' ?>" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="last_date"><i class="fas fa-calendar-day"></i> Last Checkup Date</label>
                <input type="date" id="last_date" name="last_date" value="<?= isset($form_data['last_date']) ? htmlspecialchars($form_data['last_date']) : '' ?>" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="patient__id"><i class="fas fa-id-card"></i> Patient ID</label>
                <input type="text" id="patient__id" name="patient__id" value="<?= isset($form_data['patient__id']) ? htmlspecialchars($form_data['patient__id']) : '' ?>" required />
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="contact"><i class="fas fa-phone"></i> Contact Number</label>
                <input type="text" id="contact" name="contact" value="<?= isset($form_data['contact']) ? htmlspecialchars($form_data['contact']) : '' ?>" required />
            </div>
        </div>

        <div class="form-group">
            <label for="_meds"><i class="fas fa-notes-medical"></i> Medical Findings</label>
            <textarea id="_meds" name="_meds" rows="3"><?= isset($form_data['_meds']) ? htmlspecialchars($form_data['_meds']) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="_test"><i class="fas fa-vial"></i> Required Tests</label>
            <textarea id="_test" name="_test" rows="3"><?= isset($form_data['_test']) ? htmlspecialchars($form_data['_test']) : '' ?></textarea>
        </div>

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
                    $selected = (isset($form_data['med1']) && $form_data['med1'] === $med) ? 'selected' : '';
                    echo "<option value=\"$med\" $selected>$med</option>";
                }
                ?>
            </select>
        </div>

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
                    $selected = (isset($form_data['med_sched1']) && $form_data['med_sched1'] === $time) ? 'selected' : '';
                    echo "<option value=\"$time\" $selected>$time</option>";
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
                    $selected = (isset($form_data['med2']) && $form_data['med2'] === $med) ? 'selected' : '';
                    echo "<option value=\"$med\" $selected>$med</option>";
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
                    $selected = (isset($form_data['med_sched2']) && $form_data['med_sched2'] === $time) ? 'selected' : '';
                    echo "<option value=\"$time\" $selected>$time</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="photo" class="file-input-label"><i class="fas fa-image"></i> Upload Photo</label>
            <input type="file" id="photo" name="photo" accept="image/*" required />
            <div class="image-preview">
                <img src="pics/profile-placeholder.jpg" alt="" />
            </div>
        </div>

        <button type="submit" name="submit" class="submit-btn">Register Patient</button>
    </form>
</div>

<script>
// Form field focus effects
document.querySelectorAll('input, select, textarea').forEach(item => {
    item.addEventListener('focus', function() {
        this.closest('.form-group').classList.add('focused');
    });
    item.addEventListener('blur', function() {
        if(!this.value) {
            this.closest('.form-group').classList.remove('focused');
        }
    });
    
    // Set focused class on inputs with values (for when the form redisplays after an error)
    if(item.value) {
        item.closest('.form-group').classList.add('focused');
    }
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
