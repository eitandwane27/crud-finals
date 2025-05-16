<?php include "db-login.php"; ?>
<?php
if (isset($_POST['submit'])) {
    // Collect form inputs
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
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $photo = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $upload_path = "uploads/" . basename($photo);

    if (move_uploaded_file($tmp_name, $upload_path)) {
        // Step 1: Insert into user_info
        $stmt1 = $conn->prepare("
            INSERT INTO user_info (first_name,last_name, age, address, contact,_doc, _appointment, _meds, _test, photo)
            VALUES (?, ? , ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt1->bind_param("ssssssssss", $first_name,$last_name ,$age, $address, $contact, $_doc, $_appointment, $_meds, $_test, $photo);
        
        if ($stmt1->execute()) {
            $last_id = $conn->insert_id; // Get the auto-incremented ID from user_info

            // Step 2: Insert into users table with same ID
            $stmt2 = $conn->prepare("
                INSERT INTO users (id, patient__id, patient_name, password)
                VALUES (?, ?, ?, ?)
            ");
            $stmt2->bind_param("isss", $last_id, $patient__id, $patient_name, $hashed_password);

            if ($stmt2->execute()) {
                echo "<h3>Patient added successfully!</h3>";
                echo "<a href='add.php'>Add Another</a> | <a href='admin-dash.php'>Go to Home Page</a>";
                exit();
            } else {
                echo "Error inserting into users: " . $conn->error;
            }
        } else {
            echo "Error inserting into user_info: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styleForAdmin-add.css">
</head>
<body>
    <div class="form-container">
        
        <form action="" method="POST" enctype="multipart/form-data" class="glass-form">
        <p class="form-title">New Patient Registration</p>
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                
            </div>


            <div class="form-row">

            <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" required>
                </div>
            <div class="form-group">

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
       </div>            
            </div>
            
            <div class="form-row">
            <div class="form-group">
                <label for="_doc">Doctor</label>
                <select id="_doc" name="_doc" required>
                    <option value="" disabled selected>Select doctor</option>
                    <option value="Dr. Marvin Acuin">Dr. Marvin Acuin</option>
                    <option value="Dr. Eitan Maceda">Dr. Eitan Maceda</option>
                    <option value="Dr. David Heard">Dr. David Heard</option>
                    <option value="Dr. John Rey">Dr. John Rey</option>
                </select>
            </div>
            <div class="form-group">
                    <label for="patient_name">Patient Name (Account Name)</label>
                    <input type="text" id="patient_name" name="patient_name">
                </div>

            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="_appointment">Appointment</label>
                    <input type="number" id="_appointment" name="_appointment">
                </div>
                <div class="form-group">
                    <label for="patient__id">Patient ID (Username)</label>
                    <input type="text" id="patient__id" name="patient__id" required>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>    
            <div class="form-group">
                <label for="password">Contact</label>
                <input type="text" id="contact" name="contact" required>
            </div>
            
            </div>
            

            <div class="form-group">
                <label for="_meds">Medical Findings</label>
                <textarea id="_meds" name="_meds" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label for="_test">Required Tests</label>
                <textarea id="_test" name="_test" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label for="photo">Upload Photo</label>
                <div class="file-upload">
                    <input type="file" id="photo" name="photo" accept="image/uploads" required>
                    <span class="file-custom fas fa-upload"></span>
                </div>
            </div>

            <button type="submit" name="submit" class="submit-btn">
               <p class="wala">Register</p>
            </button>
        </form>
    </div>
</body>
</html>