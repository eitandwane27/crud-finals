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
    $_doc = htmlspecialchars($_POST['_doc']);
    $_appointment = htmlspecialchars($_POST['_appointment']);
    $_meds = htmlspecialchars($_POST['_meds']);
    $_test = htmlspecialchars($_POST['_test']);
    $patient__id = htmlspecialchars($_POST['patient__id']);
    $patient_name = htmlspecialchars($_POST['patient_name']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $photo = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $upload_path = "uploads/" . basename($photo);

    if (move_uploaded_file($tmp_name, $upload_path)) {
        // Step 1: Insert into user_info
        $stmt1 = $conn->prepare("
            INSERT INTO user_info (first_name, last_name, age, address, contact, _doc, _appointment, _meds, _test, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt1->bind_param("ssssssssss", $first_name, $last_name, $age, $address, $contact, $_doc, $_appointment, $_meds, $_test, $photo);
        
        if ($stmt1->execute()) {
            $last_id = $conn->insert_id;

            // Step 2: Insert into users table
            $stmt2 = $conn->prepare("
                INSERT INTO users (id, patient__id, patient_name, password)
                VALUES (?, ?, ?, ?)
            ");
            $stmt2->bind_param("isss", $last_id, $patient__id, $patient_name, $hashed_password);

            if ($stmt2->execute()) {
                $success_message = "Patient registered successfully! Redirecting...";
                // Add JavaScript for smooth redirect
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Patient Registration</title>
    <!-- Modern Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styleForAdmin-add.css">
</head>
<body>
    <div class="form-container">
        <?php if ($success_message): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="glass-form">
            <h1 class="form-title">New Patient Registration</h1>
            
            <!-- Personal Information Section -->
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">
                        <i class="fas fa-user"></i> First Name
                    </label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>

                <div class="form-group">
                    <label for="last_name">
                        <i class="fas fa-user"></i> Last Name
                    </label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="age">
                        <i class="fas fa-birthday-cake"></i> Age
                    </label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="address">
                        <i class="fas fa-map-marker-alt"></i> Address
                    </label>
                    <input type="text" id="address" name="address" required>
                </div>
            </div>

            <!-- Medical Information Section -->
            <div class="form-row">
                <div class="form-group">
                    <label for="_doc">
                        <i class="fas fa-user-md"></i> Assigned Doctor
                    </label>
                    <select id="_doc" name="_doc" required>
                        <option value="" disabled selected>Select doctor</option>
                        <option value="Dr. Marvin Acuin">Dr. Marvin Acuin</option>
                        <option value="Dr. Eitan Maceda">Dr. Eitan Maceda</option>
                        <option value="Dr. David Heard">Dr. David Heard</option>
                        <option value="Dr. John Rey">Dr. John Rey</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="patient_name">
                        <i class="fas fa-hospital-user"></i> Patient Name (Account)
                    </label>
                    <input type="text" id="patient_name" name="patient_name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="_appointment">
                        <i class="fas fa-calendar-check"></i> Appointment Number
                    </label>
                    <input type="number" id="_appointment" name="_appointment" required>
                </div>
                <div class="form-group">
                    <label for="patient__id">
                        <i class="fas fa-id-card"></i> Patient ID
                    </label>
                    <input type="text" id="patient__id" name="patient__id" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="contact">
                        <i class="fas fa-phone"></i> Contact Number
                    </label>
                    <input type="text" id="contact" name="contact" required>
                </div>
            </div>

            <!-- Medical Details Section -->
            <div class="form-group">
                <label for="_meds">
                    <i class="fas fa-notes-medical"></i> Medical Findings
                </label>
                <textarea id="_meds" name="_meds" rows="3" placeholder="Enter detailed medical findings..."></textarea>
            </div>

            <div class="form-group">
                <label for="_test">
                    <i class="fas fa-vial"></i> Required Tests
                </label>
                <textarea id="_test" name="_test" rows="3" placeholder="List required medical tests..."></textarea>
            </div>

            <!-- File Upload Section -->
            <div class="form-group">
                <label for="photo">
                    <i class="fas fa-camera"></i> Patient Photo
                </label>
                <div class="file-upload">
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                    <div class="file-custom">
                        Click or drag to upload photo
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="submit" class="submit-btn">
                <i class="fas fa-user-plus"></i>
                Register Patient
            </button>
        </form>
    </div>

    <!-- Add custom JavaScript for enhanced UX -->
    <script>
        // Update file input label with selected filename
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Click or drag to upload photo';
            document.querySelector('.file-custom').textContent = fileName;
        });

        // Add loading state to submit button
        document.querySelector('form').addEventListener('submit', function() {
            const button = document.querySelector('.submit-btn');
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            button.style.opacity = '0.7';
        });
    </script>
</body>
</html>