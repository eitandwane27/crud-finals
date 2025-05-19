<?php
include 'db-login.php';
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: loginInterface.php");
    exit();
}

// Fetch user data securely
$id = $_SESSION['id'];

$stmt = $conn->prepare("
    SELECT 
        ui.first_name, 
        ui.last_name, 
        ui.age, 
        ui.address, 
        ui.contact, 
        ui._doc, 
        ui._appointment, 
        ui._meds, 
        ui._test, 
        ui.photo,
        ui.systolic,
        ui.diastolic,
        ui.bpm,
        ui.cholesterol,
        ui.glucose,
        ui.last_date,
        ui.med1,
        ui.med2,
        ui.med_sched1,
        ui.med_sched2,
        d.spec1,
        d.lname
            
    FROM user_info ui
    LEFT JOIN doctors d ON CONCAT('Dr. ', d.fname, ' ', d.lname) = ui._doc
    WHERE ui.id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$userInfo = $result->fetch_assoc();

// Escape and format data
$userPhoto = !empty($userInfo['photo']) ? htmlspecialchars($userInfo['photo']) : 'default-avatar.png';
$fullName = htmlspecialchars($userInfo['first_name']); // using first_name now
$patientId = htmlspecialchars($_SESSION['patient__id']);

$appointmentInfo = !empty($userInfo['_appointment']) ? htmlspecialchars($userInfo['_appointment']) : 'No upcoming appointments';
$medicationInfo = !empty($userInfo['_meds']) ? htmlspecialchars($userInfo['_meds']) : 'No current medications';
$testInfo = !empty($userInfo['_test']) ? htmlspecialchars($userInfo['_test']) : 'No recent tests';
$doctorInfo = !empty($userInfo['_doc']) ? htmlspecialchars($userInfo['_doc']) : 'No assigned doctor';
$spec = !empty($userInfo['spec1']) ? htmlspecialchars($userInfo['spec1']) : 'No specialty info available';
$systolic = !empty($userInfo['systolic']) ? htmlspecialchars($userInfo['systolic']) : 'No systolic info available';
$diastolic = !empty($userInfo['diastolic']) ? htmlspecialchars($userInfo['diastolic']) : 'No diastolic info available';
$bpm = !empty($userInfo['bpm']) ? htmlspecialchars($userInfo['bpm']) : 'No bpm info available';
$cholesterol = !empty($userInfo['cholesterol']) ? htmlspecialchars($userInfo['cholesterol']) : 'No cholesterol info available';
$glucose = !empty($userInfo['glucose']) ? htmlspecialchars($userInfo['glucose']) : 'No glucose info available';
$last_date = !empty($userInfo['last_date']) ? htmlspecialchars($userInfo['last_date']) : 'No last_date info available';
$med1 = !empty($userInfo['med1']) ? htmlspecialchars($userInfo['med1']) : 'No medecine info available';
$med2 = !empty($userInfo['med2']) ? htmlspecialchars($userInfo['med2']) : 'No medecine info available';
$med_sched1 = !empty($userInfo['med_sched1']) ? htmlspecialchars($userInfo['med_sched1']) : 'No time info available';
$med_sched2 = !empty($userInfo['med_sched2']) ? htmlspecialchars($userInfo['med_sched2']) : 'No time info available';
$contact = !empty($userInfo['contact']) ? htmlspecialchars($userInfo['contact']) : 'No contact info available';
$lname = !empty($userInfo['lname']) ? htmlspecialchars($userInfo['lname']) : 'No last name available';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard | Healthcare Platform</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="dashboard.js"></script>
    <!-- Add favicon -->
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/2966/2966327.png">
    <!-- Add theme color for mobile browsers -->
    <meta name="theme-color" content="#4361ee">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="profile-info">
                    <div class="avatar">
                        <img src="uploads/<?= $userPhoto ?>" alt="<?= $fullName ?>'s Avatar" loading="lazy">
                    </div>
                    <h3><?= $fullName ?></h3>
                    <p>Patient ID: #<?= $patientId ?></p>
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
                <a href="index.php" class="logout-btn">
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
                   

                </div>
            </header>
            
            <div class="welcome-banner">
                <div class="welcome-content">
                    <h2>Welcome back, <?= $fullName ?>!</h2>
                    <p>Here's an overview of your health information and upcoming appointments.</p>
                   
                </div>
                <div class="welcome-image">
                    <img src="https://cdn-icons-png.flaticon.com/512/3004/3004036.png" alt="Healthcare Illustration">
                </div>
            </div>
            
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Upcoming Appointments</h3>
                        <p><?= $appointmentInfo ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-light-blue">
                        <i class="fas fa-prescription-bottle-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Recent Findings</h3>
                        <p><?= $medicationInfo ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-dark-blue">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Recent Tests</h3>
                        <p><?= $testInfo ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Sections -->
            <section id="dashboard-overview">
                <div class="content-grid">
                    <div class="appointments-card">
                        <div class="card-header">
                            <h3>Assigned Doctors</h3>
                            
                        </div>
                        <div class="appointment-list">
                            <div class="appointment-item">
                                <div class="appointment-details">
                                    <h4><?= $doctorInfo ?></h4>
                                    <p><?=$spec?> Consultation</p>
                                    <span class="appointment-date"><i class="far fa-calendar"></i> May 15, 2023 - 10:00 AM</span>
                                </div>
                                <div class="appointment-status completed">
                                    Completed
                                </div>
                            </div>
                            <div class="appointment-item">
                                <div class="appointment-details">
                                    <h4><?= $doctorInfo ?></h4>
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
                           
                        </div>
                        <div class="medication-list">
                            <div class="medication-item">
                                <div class="medication-icon">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div class="medication-details">
                                    <h4><?= $med1 ?></h4>
                                    <p><?= $med_sched1 ?></p>
                                    <span class="medication-prescriber">Prescribed by <?= $doctorInfo ?></span>
                                </div>
                            </div>
                            <div class="medication-item">
                                <div class="medication-icon">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div class="medication-details">
                                    <h4><?= $med2 ?></h4>
                                    <p><?= $med_sched2 ?></p>
                                    <span class="medication-prescriber">Prescribed by <?= $doctorInfo ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Assigned Doctors Section -->
            <section id="dashboard-appointments" class="section" style="display: none;">
                <div class="content-grid">
                    <div class="profile-card">
                        <h3>Your Medical Team</h3>
                        <div class="doctor-list">
                            <div class="doctor-item">
                                <div class="doctor-avatar">
                                    <img src="uploads/4567.png" alt="Doctor Avatar">
                                </div>
                                <div class="doctor-info">
                                    <h4><?=$doctorInfo?></h4>
                                    <p>Cardiologist</p>
                                    <p>Contact #: <?=$contact?></p>
                                    <p>Email: <?= $lname ?>@medcenter.com</p>
                                    
                                </div>
                            </div>
                            <div class="doctor-item">
                                <div class="doctor-avatar">
                                    <img src="https://randomuser.me/api/portraits/women/64.jpg" alt="Doctor Avatar">
                                </div>
                                <div class="doctor-info">
                                    <h4>RN Sarah Chen</h4>
                                    <p>Nurse</p>
                                    <p>Experience: 8 years</p>
                                    <p>Contact: dr.chen@medcenter.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-card">
                        <h3>Upcoming Consultations</h3>
                        <div class="consultation-list">
                            <div class="consultation-item">
                                <div class="consultation-date">
                                    <span class="day">15</span>
                                    <span class="month">May</span>
                                </div>
                                <div class="consultation-details">
                                    <h4>Cardiology Follow-up</h4>
                                    <p><i class="far fa-clock"></i> 10:00 AM - 10:45 AM</p>
                                    <p><i class="far fa-user"></i> Dr. Michael Johnson</p>
                                </div>
                                <div class="consultation-actions">
                                    <!-- <button class="reschedule-btn">Reschedule</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Medications Section -->
            <section id="dashboard-medications" class="section" style="display: none;">
                <div class="content-grid">
                    <div class="profile-card">
                        <h3>Current Prescriptions</h3>
                        <div class="prescription-list">
                            <div class="prescription-item">
                                <div class="prescription-icon">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div class="prescription-details">
                                    <h4><?=$med1?> <span class="dosage">10mg</span></h4>
                                    <p class="prescription-instructions">Take once daily with food</p>
                                    <div class="prescription-meta">
                                        <span><i class="far fa-calendar"></i> Refill: Every end of the month</span>
                                        <span><i class="far fa-user"></i> <?=$doctorInfo?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="prescription-item">
                                <div class="prescription-icon">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div class="prescription-details">
                                    <h4><?=$med2?><span class="dosage">20mg</span></h4>
                                    <p class="prescription-instructions">Take once daily at bedtime</p>
                                    <div class="prescription-meta">
                                        <span><i class="far fa-calendar"></i> Refill: Every end of the month</span>
                                        <span><i class="far fa-user"></i> <?=$doctorInfo?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="profile-card">
                        <h3>Medication Schedule</h3>
                        <div class="schedule-calendar">
                            <div class="schedule-day">
                                <div class="day-header">Today</div>
                                <div class="day-pills">
                                    <div class="pill-time">
                                        <span class="time"><?=$med_sched1?></span>
                                        <span class="pill-name"><?=$med1?></span>
                                        <span class="pill-status completed">Taken</span>
                                    </div>
                                    <div class="pill-time">
                                        <span class="time"><?=$med_sched2?></span>
                                        <span class="pill-name"><?=$med2?></span>
                                        <span class="pill-status">Upcoming</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Health Records Section -->
            <section id="dashboard-healthrecords" class="section" style="display: none;">
                <div class="content-grid">
                    <div class="profile-card">
                        <h3>Medical History</h3>
                        <div class="medical-history">
                            <div class="history-item">
                                <div class="history-date">Mar 2023</div>
                                <div class="history-content">
                                    <h4>Annual Physical Examination</h4>
                                    <p>General health assessment with blood work and vitals</p>
                                    <div class="history-meta">
                                        <span><i class="fas fa-user-md"></i> Dr. Chen</span>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="history-item">
                                <div class="history-date">Jan 2023</div>
                                <div class="history-content">
                                    <h4>Cardiology Consultation</h4>
                                    <p>Follow-up on hypertension management and heart health</p>
                                    <div class="history-meta">
                                        <span><i class="fas fa-user-md"></i> Dr. Johnson</span>
                                     
                                    </div>
                                </div>
                            </div>
                            
                            <div class="history-item">
                                <div class="history-date">Oct 2022</div>
                                <div class="history-content">
                                    <h4>Blood Test</h4>
                                    <p>Complete blood count and lipid profile</p>
                                    <div class="history-meta">
                                        <span><i class="fas fa-flask"></i> MedLab</span>
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="profile-card">
                        <h3>Health Metrics</h3>
                        <div class="metrics-container">
                            <?php
                                
                                $systolic = (int)$systolic;
                                $diastolic = (int)$diastolic;

                                if ($systolic > 120 || $diastolic > 80) {
                                    $bp_status = 'Abnormal';
                                    $bp_class = 'not-normal';
                                } else {
                                    $bp_status = 'Normal';
                                    $bp_class = 'normal';
                                }
                                ?>

                                <div class="metric-item">
                                    <div class="metric-label">Blood Pressure</div>
                                    <div class="metric-value"><?= $systolic ?>/<?= $diastolic ?> <span class="metric-unit">mmHg</span></div>
                                    <div class="metric-status <?= $bp_class ?>"><?= $bp_status ?></div>
                                    <div class="metric-date">Last recorded: <?= htmlspecialchars($last_date) ?></div>
                                </div>
                            
                            <div class="metric-item">
                                <div class="metric-label">Heart Rate</div>
                                <div class="metric-value"><?= $bpm ?> <span class="metric-unit">bpm</span></div>
                                
                                <?php
                                    $bpm_status = ($bpm > 120) ? 'Abnormal' : 'Normal';
                                    $bpm_class = ($bpm > 120) ? 'not-normal' : 'normal';
                                ?>
                                
                                <div class="metric-status  <?= $bpm_class ?>"><?= $bpm_status ?></div>
                                <div class="metric-date">Last recorded: <?= $last_date ?></div>
                            </div>
                            
                            <div class="metric-item">
                                <div class="metric-label">Cholesterol (LDL)</div>
                                <div class="metric-value"><?=$cholesterol?> <span class="metric-unit">mg/dL</span></div>

                                <?php if ($cholesterol > 200): ?>
                                    <div class="metric-status not-normal">Abnormal</div>
                                <?php else: ?>
                                    <div class="metric-status normal">Normal</div>
                                <?php endif; ?>

                                <div class="metric-date">Last recorded: <?=$last_date?></div>
                            </div>
                            
                            <div class="metric-item">
                                <div class="metric-label">Blood Glucose</div>
                                <div class="metric-value"><?=$glucose?> <span class="metric-unit">mg/dL</span></div>

                                <?php if ($glucose < 70 || $glucose > 100): ?>
                                    <div class="metric-status not-normal">Abnormal</div>
                                <?php else: ?>
                                    <div class="metric-status normal">Normal</div>
                                <?php endif; ?>

                                <div class="metric-date">Last recorded: <?=$last_date?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
