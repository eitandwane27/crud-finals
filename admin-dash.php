<?php 
    include "db-login.php";
    session_start();
    ?>
<?php

$sql = "SELECT id, fname, lname, spec1,spec2,spec3,spec4, contact FROM doctors";
$result = $conn->query($sql);


$doctors = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = [
            'id' => $row['id'],
            'first_name' => $row['fname'],
            'last_name' => $row['lname'],
            'spec1' => $row['spec1'],
            'spec2' => $row['spec2'],
            'spec3' => $row['spec3'],
            'spec4' => $row['spec4'],
            'contact' => $row['contact']
        ];
    }
}
?>

    <!DOCTYPE html>
    <html lang="en" data-theme="light">
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





        <!-- Add Zoom Modal -->
        <div class="zoom-modal" id="imageZoomModal">
            <button class="close-btn" id="closeZoomModal">
                <i class="fas fa-times"></i>
            </button>
            <img src="" alt="Zoomed Image" id="zoomedImage">
        </div>
        
        <button class="theme-toggle" id="theme-toggle" aria-label="Toggle theme">
            <i class="fas fa-moon"></i>
        </button>
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
                    <a href="index.php" class="logout-btn">
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
                    <div class="header-actions" id="header-search">
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="search-box" id="search">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Search by full name..." 
                                value="<?= isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '' ?>"
                                autocomplete="off"
                            >
                            <button type="submit" aria-label="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
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
                                            <th>Sex</th>
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
                                        // Base SQL query - always show all patients by default
                                        $sql = "
                                            SELECT 
                                                user_info.*, 
                                                users.patient__id, 
                                                users.password
                                                
                                            FROM user_info 
                                            INNER JOIN users ON user_info.id = users.id
                                        ";

                                        // Only filter if there's a non-empty search term
                                        if (isset($_GET['search']) && trim($_GET['search']) !== '') {
                                            $search = trim($_GET['search']);
                                            $safeSearch = $conn->real_escape_string($search);
                                            $sql .= " WHERE user_info.first_name LIKE '$safeSearch%' 
                                                    OR user_info.last_name LIKE '$safeSearch%'
                                                    OR CONCAT(user_info.first_name, ' ', user_info.last_name) LIKE '%$safeSearch%'";
                                        }

                                        // Add ORDER BY clause
                                        $sql .= " ORDER BY user_info.first_name ASC, user_info.last_name ASC";

                                        $result = $conn->query($sql);
                                        
                                        if ($result && $result->num_rows > 0) {
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
                                                    <td>{$row['_sex']}</td>
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
                                        } else {
                                            echo "<tr><td colspan='11' style='text-align: center;'>No patients found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-footer">
                                <div class="table-info">
                                    Showing <?= $result->num_rows ?? 0 ?> patient records
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                 
                
                
                
                <div class="content-wrapper" id="dashboard-doctors" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h1 id="doctors-heading">Our Medical Team</h1>
                                <div class="breadcrumb">
                                    <a href="#">Dashboard</a> / <span>Doctors</span>
                                </div>
                            </div>
                            <div class="card-actions">
                               
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="patients-table">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Doctor Name</th>
                                            <th>Specialty</th>
                                            <th>Contact</th>
                                            <th>Schedule</th>
                                            <th>Patients</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Doctor 1 -->
                                        <tr>
                                            <td>
                                                <div class="patient-avatar">
                                                    <img src="uploads/4567.png" alt="Dr. Marvin Acuin">
                                                </div>
                                                <small>ID: DOC001</small>
                                            </td>
                                            <td>
                                                
                                                <strong>Dr. <?php echo  $doctors[0]['first_name']; ?>   <?php echo $doctors[0]['last_name']; ?> </strong>
                                            </td>
                                            <td>
                                                <div class="specialties-list">
                                                    <span class="specialty-tag"><?php echo  $doctors[0]['spec1']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[0]['spec2']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[0]['spec3']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[0]['spec4']; ?></span>
                                                    
                                                </div>
                                            </td>
                                            <td>0<?php echo  $doctors[0]['contact']; ?></td>
                                            <td>Mon-Fri, 9AM-5PM</td>
                                            <td>42 Active</td>
                                            <td><span class="status-badge" onclick="toggleStatus(this)">On Duty</span></td>

                                           
                                        </tr>

                                        <!-- Doctor 2 -->
                                        <tr>
                                            <td>
                                                <div class="patient-avatar">
                                                    <img src="uploads/5345.png" alt="Dr. Eitan Maceda">
                                                </div>
                                                <small>ID: DOC002</small>
                                            </td>
                                            <td>
                                                <strong>Dr.  <?php echo  $doctors[2]['first_name']; ?>   <?php echo $doctors[2]['last_name']; ?></strong>
                                            </td>
                                            <td>
                                                <div class="specialties-list">
                                                    <span class="specialty-tag"><?php echo  $doctors[2]['spec1']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[2]['spec2']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[2]['spec3']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[2]['spec4']; ?></span>
                                                   
                                                </div>
                                            </td>
                                            <td>0<?php echo  $doctors[2]['contact']; ?></td>
                                            <td>Mon-Thu, 10AM-6PM</td>
                                            <td>38 Active</td>
                                            <td><span class="status-badge active" onclick="toggleStatus(this)">On Duty</span></td>
                                            
                                        </tr>

                                        <!-- Doctor 3 -->
                                        <tr>
                                            <td>
                                                <div class="patient-avatar">
                                                    <img src="uploads/453345.png" alt="Dr. David Heard">
                                                </div>
                                                <small>ID: DOC003</small>
                                            </td>
                                            <td>
                                                <strong>Dr. <?php echo  $doctors[1]['first_name']; ?>   <?php echo $doctors[1]['last_name']; ?></strong>
                                            </td>
                                            <td>
                                                <div class="specialties-list">
                                                    <span class="specialty-tag"><?php echo  $doctors[1]['spec1']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[1]['spec2']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[1]['spec3']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[1]['spec4']; ?></span>
                                                </div>
                                            </td>
                                            <td>0<?php echo  $doctors[1]['contact']; ?></td>
                                            <td>Tue-Sat, 8AM-4PM</td>
                                            <td>45 Active</td>
                                            <td><span class="status-badge active" onclick="toggleStatus(this)">On Duty</span></td>
                                           
                                        </tr>

                                        <!-- Doctor 4 -->
                                        <tr>
                                            <td>
                                                <div class="patient-avatar">
                                                    <img src="https://placehold.co/400x400/ffffff/1e40af" alt="Dr. John Rey">
                                                </div>
                                                <small>ID: DOC004</small>
                                            </td>
                                            <td>
                                                <strong>Dr. <?php echo  $doctors[3]['first_name']; ?>   <?php echo $doctors[3]['last_name']; ?></strong>
                                            </td>
                                            <td>
                                                <div class="specialties-list">
                                                    <span class="specialty-tag"><?php echo  $doctors[3]['spec1']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[3]['spec1']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[3]['spec1']; ?></span>
                                                    <span class="specialty-tag"><?php echo  $doctors[3]['spec1']; ?></span>
                                                </div>
                                            </td>
                                            <td>0<?php echo  $doctors[3]['contact']; ?></td>
                                            <td>Mon-Fri, 9AM-5PM</td>
                                            <td>50 Active</td>
                                            <td><span class="status-badge active" onclick="toggleStatus(this)">On Duty</span></td>
                                           
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="patient-avatar">
                                                    <img src="uploads/43.png" alt="Dr. John Rey">
                                                </div>
                                                <small>ID: DOC004</small>
                                            </td>
                                            <td>
                                                <strong>Dr. <?php echo  $doctors[4]['first_name']; ?>   <?php echo $doctors[4]['last_name']; ?></strong>
                                            </td>
                                            <td>
                                                <div class="specialties-list">
                                                    <span class="specialty-tag">Virologist</span>
                                                    <span class="specialty-tag">Oncologists</span>
                                                    <span class="specialty-tag">Colorectal Surgeon</span>
                                                    <span class="specialty-tag">Psychiatrist</span>
                                                </div>
                                            </td>
                                            <td>0<?php echo  $doctors[4]['contact']; ?></td>
                                            <td>Mon-Fri, 9AM-5PM</td>
                                            <td>50 Active</td>
                                            <td><span class="status-badge off active" onclick="toggleStatus(this)">Off Duty</span></td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-footer">
                                <div class="table-info">
                                     Showing <?= count($doctors) ?> doctor records
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper" id="dashboard-team" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h1 id="team-heading">Our Team</h1>
                                <div class="breadcrumb">
                                    <a href="#">Dashboard</a> / <span>Team</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Featured Team Member -->
                            <div class="featured-member">
                                <div class="featured-member-card">
                                    <div class="member-image">
                                        <img src="uploads/494818551_1220394019597470_1151985093978820945_n.jpg" alt="Featured Team Member">
                                        <div class="member-overlay">
                                            <span class="role-tag">Team Lead</span>
                                        </div>
                                    </div>
                                    <div class="member-info">
                                        <h2>Dr. Sarah Mitchell</h2>
                                        <p class="role">Chief Medical Officer</p>
                                        <div class="member-stats">
                                            <div class="stat">
                                                <span class="stat-value">15+</span>
                                                <span class="stat-label">Years Experience</span>
                                            </div>
                                            <div class="stat">
                                                <span class="stat-value">250+</span>
                                                <span class="stat-label">Surgeries</span>
                                            </div>
                                            <div class="stat">
                                                <span class="stat-value">98%</span>
                                                <span class="stat-label">Success Rate</span>
                                            </div>
                                        </div>
                                        <div class="member-contact">
                                            <button class="contact-btn">
                                                <i class="fas fa-envelope"></i>
                                                Contact
                                            </button>
                                            <div class="social-links">
                                                <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                                <a href="#" class="social-link"><i class="fas fa-globe"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Team Members Grid -->
                            <div class="team-grid">
                                <!-- Team Member 1 -->
                                <div class="team-member-card">
                                    <div class="member-image">
                                        <img src="https://placehold.co/400x400/ffffff/1e40af" alt="Team Member 1">
                                        <div class="member-overlay">
                                            <span class="role-tag">Specialist</span>
                                        </div>
                                    </div>
                                    <div class="member-info">
                                        <h3>David M. Heard</h3>
                                        <p class="role">Back-end Developer</p>
                                        <div class="member-stats-mini">
                                            <span>2nd Year</span>
                                            <span>•</span>
                                            <span>BSIT</span>
                                        </div>
                                        <div class="member-contact">
                                            <button class="contact-btn-mini">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <div class="social-links">
                                                <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Team Member 2 -->
                                <div class="team-member-card">
                                    <div class="member-image">
                                        <img src="https://placehold.co/400x400/ffffff/1e40af" alt="Team Member 2">
                                        <div class="member-overlay">
                                            <span class="role-tag">Expert</span>
                                        </div>
                                    </div>
                                    <div class="member-info">
                                        <h3>Eitan Dwane B. Maceda</h3>
                                        <p class="role">Front-end Developer</p>
                                        <div class="member-stats-mini">
                                            <span>2nd Year</span>
                                            <span>•</span>
                                            <span>BSIT</span>
                                        </div>
                                        <div class="member-contact">
                                            <button class="contact-btn-mini">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <div class="social-links">
                                                <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Team Member 3 -->
                                <div class="team-member-card">
                                    <div class="member-image">
                                        <img src="https://placehold.co/400x400/ffffff/1e40af" alt="Team Member 3">
                                        <div class="member-overlay">
                                            <span class="role-tag">Senior</span>
                                        </div>
                                    </div>
                                    <div class="member-info">
                                        <h3>Marvin T. Acuin</h3>
                                        <p class="role">UI / UX Designer</p>
                                        <div class="member-stats-mini">
                                            <span>2nd Year</span>
                                            <span>•</span>
                                            <span>BSIT</span>
                                        </div>
                                        <div class="member-contact">
                                            <button class="contact-btn-mini">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <div class="social-links">
                                                <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>

    </body>
    </html>
