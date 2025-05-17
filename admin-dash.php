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
                        <div class="header-actions">
                            <form method="GET" class="search-box" id="search">
                                <input type="text" name="search" placeholder="Search by full name..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
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
                                            <th>First Name</th>
                                            <th>Last Name</th>
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
                                        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

                                        $sql = "
                                                SELECT 
                                                        user_info.*, 
                                                        users.patient__id, 
                                                        users.password,
                                                        users.patient_name
                                                    FROM user_info 
                                                    INNER JOIN users ON user_info.id = users.id
                                                ";

                                            if (!empty($search) && strlen($search) > 1) {
                                                $safeSearch = $conn->real_escape_string($search);
                                                $sql .= " WHERE user_info.first_name LIKE '$safeSearch%' 
                                                        OR user_info.last_name LIKE '% $safeSearch%'";
                                            }

                                            $result = $conn->query($sql);
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                        <td>
                                            <div class='patient-avatar'>
                                                <img src='uploads/{$row['photo']}' alt='Patient Photo'>
                                            </div>
                                            <small>ID: {$row['patient__id']}</small>
                                        </td>
                                        <td>
                                            <strong>{$row['first_name']}</strong>
                                        </td>
                                        <td>
                                            <strong>{$row['last_name']}</strong>
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
                                                <a href='admin-edit.php?id={$row['id']}' class='btn btn-sm btn-edit' onclick=\"return confirm('Are you sure you want to edit this patient?');\">
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                                <a href='admin-delete.php?id={$row['id']}' class='btn btn-sm btn-delete' onclick=\"return confirm('Are you sure you want to delete this patient?');\">
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
                            
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper" id="dashboard-patients" style="display: none;">
                                        
                        <div class="card-container">
                        <div class="child1 properties">
                            <?php
                                        $doctor_id = 1; 

                                        
                                        $sql = "SELECT fname, lname FROM doctors WHERE id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $doctor_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result && $result->num_rows > 0) {
                                            $doctor = $result->fetch_assoc();
                                            echo htmlspecialchars($doctor['fname']) . " " . htmlspecialchars($doctor['lname']);
                                        } else {
                                            echo "Doctor not found.";
                                        }

                                        $stmt->close();
                                        ?>
                        </div>
                        <div class="child2 properties">
                                        <?php
                                        $doctor_id = 2; 

                                        
                                        $sql = "SELECT fname, lname FROM doctors WHERE id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $doctor_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result && $result->num_rows > 0) {
                                            $doctor = $result->fetch_assoc();
                                            echo htmlspecialchars($doctor['fname']) . " " . htmlspecialchars($doctor['lname']);
                                        } else {
                                            echo "Doctor not found.";
                                        }

                                        $stmt->close();
                                        ?>

                        </div>
                        <div class="child3 properties">
                            <?php
                                        $doctor_id = 3; 

                                        
                                        $sql = "SELECT fname, lname FROM doctors WHERE id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $doctor_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result && $result->num_rows > 0) {
                                            $doctor = $result->fetch_assoc();
                                            echo htmlspecialchars($doctor['fname']) . " " . htmlspecialchars($doctor['lname']);
                                        } else {
                                            echo "Doctor not found.";
                                        }

                                        $stmt->close();
                                        ?>
                        </div>

                        <div class="child4 properties">
                            <?php
                                        $doctor_id = 4; 

                                        
                                        $sql = "SELECT fname, lname FROM doctors WHERE id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("i", $doctor_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result && $result->num_rows > 0) {
                                            $doctor = $result->fetch_assoc();
                                            echo htmlspecialchars($doctor['fname']) . " " . htmlspecialchars($doctor['lname']);
                                        } else {
                                            echo "Doctor not found.";
                                        }

                                        $stmt->close();
                                        ?>
                        </div>
                        
                        </div>
                
                </div>
                
                
                <div class="content-wrapper" id="dashboard-doctors" style="display: none;">
                    <div class="card-container"></div>
                </div>

                <div class="content-wrapper" id="dashboard-team" style="display: none;">
                    <div class="card-container"></div>
                </div>

            </main>
        </div>

    </body>
    </html>
