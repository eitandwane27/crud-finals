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

<h2>Edit Patient Info</h2>
<form method="POST" enctype="multipart/form-data">
    First Name: <input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>" required><br><br>

    Last Name: <input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>" required><br><br>

    Age: <input type="number_format" name="age" value="<?= htmlspecialchars($row['age']) ?>" required><br><br>
    
    Address: <input type="text" name="address" value="<?= htmlspecialchars($row['address']) ?>" required><br><br>
    
    Contact: <input type="text" name="contact" value="<?= htmlspecialchars($row['contact']) ?>" required><br><br>

    <label for="_doc">Doctor in charge:</label>
    
    <select name="_doc" required>
    <option value="Dr. Marvin Acuin">Dr. Marvin Acuin</option>
    <option value="Dr. Eitan Maceda">Dr. Eitan Maceda</option>
    <option value="Dr. David Heard">Dr. David Heard</option>
    <option value="Dr. John Rey">Dr. John Rey</option>
    </select>
    
    <br><br>
    
    Appointment: <input type="text" name="_appointment" value="<?= htmlspecialchars($row['_appointment']) ?>"><br><br>
    
    Findings: <input type="text" name="_meds" value="<?= htmlspecialchars($row['_meds']) ?>"><br><br>
    
    Tests: <input type="text" name="_test" value="<?= htmlspecialchars($row['_test']) ?>"><br><br>
    
    Patient ID (username): <input type="text" name="patient__id" value="<?= htmlspecialchars($row['patient__id']) ?>" required><br><br>
    
    
    Patient Name (account name): <input type="text" name="patient_name" value="<?= htmlspecialchars($row['patient_name']) ?>" required><br><br>
    
    
    New Password (leave blank to keep current): <input type="password" name="password"><br><br>
    
    Photo: <input type="file" name="photo"><br><br>
    <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" width="100"><br><br>
    <input type="submit" name="update" value="Update Patient">
</form>

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
        SET first_name = ?,last_name = ? ,age = ?, address = ?, contact = ?,_doc = ?, _appointment = ?, _meds = ?, _test = ?, photo = ?
        WHERE id = ?
    ");
    $stmt1->bind_param("ssssssssssi", $first_name, $last_name ,$age , $address, $contact,$_doc, $_appointment, $_meds, $_test, $photo, $id);
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

    echo "<script>alert('Patient updated successfully!'); window.location.href='admin-dash.php';</script>";
}
?>