<?php 
include "db-login.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Hospital Management</title>
    <script defer src="adminDash.js"></script>
    <link rel="stylesheet" href="styleForAdminDash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="admin-profile">
                    <img src="uploads/1747220773_Screenshot 2024-08-20 175100.png" alt="Admin Avatar">
                    <h3>Admin Panel</h3>
                    <p>Hospital Management</p>
                </div>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active" id="nav-dashboard">
                        <a href="#">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li id="nav-patients">
                        <a href="#">
                            <i class="fas fa-hospital-user"></i>
                            <span>Recent Patients</span>
                        </a>
                    </li>

                    <li id="nav-doctors">
                        <a href="#">
                            <i class="fas fa-user-md"></i>
                            <span>Doctors</span>
                        </a>
                    </li>

                    <li id="nav-team">
                        <a href="#">
                            <i class="fas fa-people-group"></i>
                            <span>Our Team</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="landingPage2.html" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Shared Header -->
            <header class="main-header">
                <div class="header-title" id="header-title">
                    <h1 id="main-heading">Patient Management</h1>
                    <div class="breadcrumb">
                        <a href="#">Dashboard</a> / <span id="span-text">Patients</span>
                    </div>
                </div>
                <div class="header-actions">
                    <div class="search-box" id="search">
                        <input type="text" placeholder="Search...">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </header>

            <!-- Patient Content -->
            <div class="content-wrapper" id="dashboard-overview">
                <div class="card patients-card">
                    <div class="card-header">
                        <h3>Patient Records</h3>
                        <div class="card-actions">
                            <a href="admin-add.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Patient
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="patients-table">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Full Name</th>
                                        <th>Age</th>
                                        <th>Contact</th>
                                        <th>Doctor</th>
                                        <th>Appointments</th>
                                        <th>Findings</th>
                                        <th>Tests</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                            <td>
                                                <div class='patient-avatar'>
                                                    <img src='uploads/{$row['photo']}' alt='Patient Photo'>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{$row['fullname']}</strong>
                                                <small>ID: {$row['patient__id']}</small>
                                            </td>
                                            <td>{$row['age']}</td>
                                            <td>{$row['contact']}</td>
                                            <td>{$row['_doc']}</td>
                                            <td>{$row['_appointment']}</td> 
                                            <td>{$row['_meds']}</td>
                                            <td>{$row['_test']}</td>
                                            <td><span class='status-badge active'>Active</span></td>
                                            <td>
                                                <div class='action-buttons'>
                                                    <a href='admin-edit.php?id={$row['id']}' class='btn btn-sm btn-edit'>
                                                        <i class='fas fa-edit'></i>
                                                    </a>
                                                    <a href='admin-delete.php?id={$row['id']}' class='btn btn-sm btn-delete'>
                                                        <i class='fas fa-trash'></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-footer">
                            <div class="table-info">
                                Showing <?= $result->num_rows ?> patient records
                            </div>
                            <div class="pagination">
                                <button class="btn btn-pagination disabled"><i class="fas fa-chevron-left"></i></button>
                                <button class="btn btn-pagination active">1</button>
                                <button class="btn btn-pagination"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-wrapper" id="dashboard-patients" style="display: none;">
                <div class="card patients-card">
                    <p>Testing 2</p>
                </div>
            </div>
            
            
            <div class="content-wrapper" id="dashboard-doctors" style="display: none;">
                <div class="card patients-card">
                    <p>Testing 3</p>
                </div>
            </div>

            <div class="content-wrapper" id="dashboard-team" style="display: none;">
                <div class="card patients-card">
                    <p>Testing 4</p>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
