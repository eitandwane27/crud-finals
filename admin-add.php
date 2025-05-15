<?php include "db-login.php"; ?>
<?php
if (isset($_POST['submit'])) {
    // Collect form inputs
    $fullname = $_POST['fullname'];
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
            INSERT INTO user_info (fullname, age, address, contact,_doc, _appointment, _meds, _test, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt1->bind_param("sssssssss", $fullname,$age, $address, $contact, $_doc, $_appointment, $_meds, $_test, $photo);
        
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


<h2>Add New Patient</h2>
<form action="" method="POST" enctype="multipart/form-data">
    Full Name: <input type="text" name="fullname" required><br><br>

    Age: <input type="text" name="age" required><br><br>

    Address: <input type="text" name="address" required><br><br>

    Contact: <input type="text" name="contact" required><br><br>

    Doctor in charge: <input type="text" name="_doc" required><br><br>
    
    Appointment: <input type="text" name="_appointment"><br><br>
    
    Findings: <input type="text" name="_meds"><br><br>
    
    Tests: <input type="text" name="_test"><br><br>
    
    Patient ID (username): <input type="text" name="patient__id" required><br><br>
    
    Patient Name (account name): <input type="text" name="patient_name" required><br><br>
    
    Password: <input type="password" name="password" required><br><br>
    
    Photo: <input type="file" name="photo" accept="image/*" required><br><br>
    <input type="submit" name="submit" value="Add Patient">
</form>