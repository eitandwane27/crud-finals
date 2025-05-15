<?php include "db-login.php"; ?>
    <a href="admin-add.php">Add New ID</a>
    <table border="1" cellpadding="10">
    <tr>
    <th>Photo</th>
    <th>Full Name</th>
    <th>Age</th>
    <th>Address</th>
    <th>Contact</th>
    <th>Doctor in charge</th>
    <th>Appointments</th>
    <th>Findings</th>
    <th>Tests</th>
    <th>Patient ID</th>
    <th>Account name</th>
    <th>Password</th>
    <th>Actions</th>
    </tr>
<?php

$sql = "
    SELECT 
        user_info.*, 
        users.patient__id, 
        users.password,
        users.patient_name 
    FROM user_info 
    INNER JOIN users ON user_info.id = users.id
";



$result = $conn->query($sql);


while ($row = $result->fetch_assoc()) {
echo "<tr>
    <td><img src='uploads/{$row['photo']}' width='80'></td>
    <td>{$row['fullname']}</td>
    <td>{$row['age']}</td>
    <td>{$row['address']}</td>
    <td>{$row['contact']}</td>
    <td>{$row['_doc']}</td>
    <td>{$row['_appointment']}</td>
    <td>{$row['_meds']}</td>
    <td>{$row['_test']}</td>
    <td>{$row['patient__id']}</td>
    <td>{$row['patient_name']}</td>
    <td>{$row['password']}</td>
    <td>
        <a href='admin-edit.php?id={$row['id']}'>Edit</a> |
        <a href='admin-delete.php?id={$row['id']}'>Delete</a>
    </td>
    </tr>";
}
?>
</table>    