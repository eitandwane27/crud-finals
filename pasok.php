<?php
 include 'db-login.php';
session_start();
if (!isset($_SESSION['patient_name'])) {
    header("Location: loginInterface.php");
    exit();
}
//test#########################################################################################

$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT fullname, age ,address, contact, _doc, _appointment, _meds,_test,photo FROM user_info WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$userInfo = $result->fetch_assoc();

//test##########################################################################################

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="dashboard.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="profile-info">
                    <div class="avatar">
                        <img src="uploads/<?= htmlspecialchars($userInfo['photo']); ?>" alt="User Avatar">
                    </div>
                    <h3><?= $_SESSION['patient_name'] ?></h3>
                    <p>Patient ID: #<?= $_SESSION['patient__id'] ?></p>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="active" id="nav-overview">
                        <a href="#">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Overview</span>
                        </a>
                    </li>
                    <li id="nav-appointments">
                        <a href="#">
                            <i class="fas fa-user-md"></i>
                            <span>Assigned Doctors</span>
                        </a>
                    </li>
                    <li id="nav-medications">
                        <a href="#">
                            <i class="fas fa-pills"></i>
                            <span>Medications</span>
                        </a>
                    </li>
                    <li id="nav-healthRecords">
                        <a href="#">
                            <i class="fas fa-file-medical"></i>
                            <span>Health Records</span>
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
        
        <!-- Main Content -->
        <main class="main-content">
            <header class="main-header">
                <h1>Patient Dashboard</h1>
                <div class="header-actions">
                    
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </header>
            
            <div class="welcome-banner">
                <div class="welcome-content">
                    <h2>Welcome back, <?= $_SESSION['patient_name'] ?>!</h2>
                    <p>Here's what's happening with your health today.</p>
                    <a href="landingPage2.html" class="continue-btn">Continue to Portal</a>
                </div>
                <div class="welcome-image">
                    <img src="https://cdn-icons-png.flaticon.com/512/3004/3004036.png" alt="Healthcare">
                </div>
            </div>
            
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Upcoming Appointments</h3>
                       

                        <p><?= htmlspecialchars($userInfo['_appointment']) ?></p>
                        

                        
                        
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-light-blue">
                        <i class="fas fa-prescription-bottle-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Recent Findings</h3>
                        <p><?= htmlspecialchars($userInfo['_meds']) ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-dark-blue">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Recent Tests</h3>
                        <p><?= htmlspecialchars($userInfo['_test']) ?></p>
                    </div>
                </div>
            </div>
            
            <div id="dashboard-overview">
            <div class="content-grid">
                <div class="appointments-card">
                    <div class="card-header">
                        <h3>Assigned Doctors</h3>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="appointment-list">
                        <div class="appointment-item">
                            <div class="appointment-details">
                                <h4><?= htmlspecialchars($userInfo['_doc']) ?></h4>
                                <p>Cardiology Consultation</p>
                                <span class="appointment-date"><i class="far fa-calendar"></i> May 15, 2023 - 10:00 AM</span>
                            </div>
                            <div class="appointment-status completed">
                                Completed
                            </div>
                        </div>
                        <div class="appointment-item">
                            <div class="appointment-details">
                                <h4><?= htmlspecialchars($userInfo['_doc']) ?></h4>
                                <p>Annual Checkup</p>
                                <span class="appointment-date"><i class="far fa-calendar"></i> June 2, 2023 - 2:30 PM</span>
                            </div>
                            <div class="appointment-status upcoming">
                                Upcoming
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="medications-card">
                    <div class="card-header">
                        <h3>Current Medications</h3>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="medication-list">
                        <div class="medication-item">
                            <div class="medication-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <div class="medication-details">
                                <h4>Lisinopril</h4>
                                <p>10mg, Once daily</p>
                                <span class="medication-prescriber">Prescribed by Dr. Johnson</span>
                            </div>
                        </div>
                        <div class="medication-item">
                            <div class="medication-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <div class="medication-details">
                                <h4>Atorvastatin</h4>
                                <p>20mg, At bedtime</p>
                                <span class="medication-prescriber">Prescribed by Dr. Chen</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                <!-- display none means that it will not be visible -->
            <div id="dashboard-appointments" class="section" style="display: none;"> 
            <div class="content-grid">
    <div class="profile-card">
      <h3>Assigned Doctors</h3>
      <p>Name: John Doe</p>
      <p>Email: john@example.com</p>
    </div>
  </div>
</div>
<div id="dashboard-medications" class="section" style="display: none;">
<div class="content-grid">
    <div class="profile-card">
      <h3>Medications</h3>
      <p></p>
      <p></p>
    </div>
  </div>
</div>
<div id="dashboard-healthrecords" class="section" style="display: none;"> 
            <div class="content-grid">
    <div class="profile-card">
      <h3>Health Records</h3>
      <p></p>
      <p></p>
    </div>
  </div>
</div>


            
        </main>
    </div>
</body>
</html>
