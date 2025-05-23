<?php
session_start();
$show_success = isset($_SESSION['show_success']) && $_SESSION['show_success'];
$show_error = isset($_SESSION['show_error']) && $_SESSION['show_error'];
unset($_SESSION['show_success'], $_SESSION['show_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Healthcare Management System</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="app.js"></script>
    <link rel="stylesheet" href="styleForLandingPage.css" />
    
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
   
</head>
<body>
    <header>
        <nav class="nav-bar">
            <div class="logo">MediCare</div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Features</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <a href="loginAs.html" target="" class="btn-login">Login</a>
        </nav>
    </header>

    <main>
    
    <!-- chatbot -->
    <div class="chat-container">
            <div class="chat-header">
                <div class="online-indicator">
                    <div class="online-dot"></div>
                </div>
                <h1>Ask MediBot!</h1>
            </div>
            <div class="chat-messages" id="chat-messages"></div>
            <div class="chat-input-container">
                <input
                    type="text"
                    id="user-input"
                    placeholder="Type your message..."
                />
                <button id="send-button">Send</button>
                <script src="script.js"></script>
            </div>
        </div>


        <!-- Home Section -->
        <section id="home" class="section home-section">
            <div class="section-container">
                <div class="hero-content">
                    <h1 class="animate-on-scroll">MEDICARE</h1>
                    <h2 class="animate-on-scroll">Healthcare Management System</h2>
                    <p class="lead-text animate-on-scroll">
                        Comprehensive patient management solution designed for healthcare professionals to streamline workflow and enhance patient care.
                    </p>
                    <div class="feature-badges animate-on-scroll">
                        <span class="feature-badge"><i class="fas fa-user-md"></i> Patient Care</span>
                        <span class="feature-badge"><i class="fas fa-shield-alt"></i>Secure Data Storage
                        </span>
                        <span class="feature-badge"><i class="fas fa-chart-line"></i> Health Analytics</span>
                    </div>
                    <div class="cta-buttons animate-on-scroll">
                       
                        
                    </div>
                </div>
                <div class="hero-image animate-on-scroll">
                    <div class="image-placeholder dashboard-preview">
                        <div class="preview-screen">
                            <div class="preview-header">
                                <div class="preview-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="preview-title">Data Manager</div>
                            </div>
                            <div class="preview-content">
                                <div class="preview-chart">
                                    <div class="chart-line"></div>
                                    <div class="chart-line"></div>
                                    <div class="chart-line"></div>
                                </div>
                                <div class="preview-stats">
                                    <div class="preview-stat">
                                        <div class="stat-circle"></div>
                                        <div class="stat-info"></div>
                                    </div>
                                    <div class="preview-stat">
                                        <div class="stat-circle"></div>
                                        <div class="stat-info"></div>
                                    </div>
                                    <div class="preview-stat">
                                        <div class="stat-circle"></div>
                                        <div class="stat-info"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="floating-elements">
                            <div class="floating-card" id="float-1">
                                <div class="float-icon"><i class="fas fa-user-plus"></i></div>
                                <div class="float-data">
                                    <div class="float-value">Patient</div>
                                    <div class="float-label">Registration</div>
                                </div>
                            </div>
                            <div class="floating-card" id="float-2">
                                <div class="float-icon"><i class="fas fa-clipboard-list"></i></div>
                                <div class="float-data">
                                    <div class="float-value">Medical</div>
                                    <div class="float-label">Records</div>
                                </div>
                            </div>
                            <div class="floating-card" id="float-3">
                                <div class="float-icon"><i class="fas fa-calendar-check"></i></div>
                                <div class="float-data">
                                    <div class="float-value">Appointment</div>
                                    <div class="float-label">Scheduling</div>
                                </div>
                            </div>
                            <div class="floating-card" id="float-4">
                                <div class="float-icon"><i class="fas fa-file-medical"></i></div>
                                <div class="float-data">
                                    <div class="float-value">Health</div>
                                    <div class="float-label">Analytics</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services/Features Section -->
        <section id="services" class="section services-section">
            <div class="section-container">
                <h2 class="section-title animate-on-scroll">Healthcare System Features</h2>
                <p class="section-subtitle animate-on-scroll">Comprehensive tools for efficient patient care and medical practice management</p>

                <div class="dashboard-container animate-on-scroll">
                    <div class="dashboard-main">
                        <div class="dashboard-card primary-card">
                            <div class="card-image-container">
                                <div class="card-image-placeholder">
                                    <i class="fas fa-hospital"></i>
                                </div>
                            </div>
                            <h3>Healthcare Hub</h3>
                            <p>Centralized patient management system for healthcare providers with comprehensive record keeping</p>
                            <div class="stat-container">
                                <div class="stat">
                                    <span class="stat-value">99.9%</span>
                                    <span class="stat-label">Uptime</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-value">0.3s</span>
                                    <span class="stat-label">Response</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-tree">
                        <div class="tree-branch branch-left">
                            <div class="dashboard-card branch-card animate-on-scroll" data-delay="0.2">
                                <div class="card-image-container">
                                    <div class="card-image-placeholder">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                                <h3>Patient Records Management</h3>
                                <p>Easily add, view, update, or delete patient information.</p>
                                <div class="status-badge positive">
                                    <i class="fas fa-check"></i>
                                    <span>Active</span>
                                </div>
                            </div>
                            
                            <div class="tree-sub-branch">
                                <div class="dashboard-card mini-card animate-on-scroll" data-delay="0.3">
                                    <div class="card-image-container small">
                                        <div class="card-image-placeholder">
                                            <i class="fas fa-file-medical"></i>
                                        </div>
                                    </div>
                                    <h3>Medical History</h3>
                                    <p>View complete patient histories with filterable records</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tree-branch branch-right">
                            <div class="dashboard-card branch-card animate-on-scroll" data-delay="0.4">
                                <div class="card-image-container">
                                    <div class="card-image-placeholder">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                </div>
                                <h3>Doctor Profiles Control</h3>
                                <p>Manage doctor data including specialties, schedules, and availability.</p>
                                <div class="status-badge neutral">
                                    <i class="fas fa-check"></i>
                                    <span>Active</span>
                                </div>
                            </div>
                            
                            <div class="tree-sub-branch">
                                <div class="dashboard-card mini-card animate-on-scroll" data-delay="0.5">
                                    <div class="card-image-container small">
                                        <div class="card-image-placeholder">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <h3>Scheduling</h3>
                                    <p>View and manage doctor availability and appointments</p>
                                </div>
                            </div>
                        </div>

                        <div class="tree-branch branch-left tree-branch-three">
                            <div class="dashboard-card branch-card animate-on-scroll" data-delay="0.6">
                                <div class="card-image-container">
                                    <div class="card-image-placeholder">
                                        <i class="fas fa-sync"></i>
                                    </div>
                                </div>
                                <h3>Real-Time Data Updates</h3>
                                <p>Instantly reflect changes made in the system for accurate record-keeping.</p>
                                <div class="status-badge positive">
                                    <i class="fas fa-check"></i>
                                    <span>Active</span>
                                </div>
                            </div>
                            
                            <div class="tree-sub-branch">
                                <div class="dashboard-card mini-card animate-on-scroll" data-delay="0.7">
                                    <div class="card-image-container small">
                                        <div class="card-image-placeholder">
                                            <i class="fas fa-history"></i>
                                        </div>
                                    </div>
                                    <h3>Medical History Logs</h3>
                                    <p>View and maintain detailed records of patient diagnoses and treatments</p>
                                </div>
                            </div>
                        </div>

                        <div class="tree-branch branch-right tree-branch-four">
                            <div class="dashboard-card branch-card animate-on-scroll" data-delay="0.8">
                                <div class="card-image-container">
                                    <div class="card-image-placeholder">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                </div>
                                <h3>User Role Access Control</h3>
                                <p>Secure data with role-based permissions (e.g. Admin, Patient).</p>
                                <div class="status-badge warning">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Protected</span>
                                </div>
                            </div>
                            
                            <div class="tree-sub-branch">
                                <div class="dashboard-card mini-card animate-on-scroll" data-delay="0.9">
                                    <div class="card-image-container small">
                                        <div class="card-image-placeholder">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <h3>Secure Data Storage</h3>
                                    <p>Ensure sensitive information is stored with encryption and best practices</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-metrics animate-on-scroll" data-delay="1.0">
                        <div class="metric-card">
                            <div class="metric-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="metric-content">
                                <h4>Patient Satisfaction</h4>
                                <div class="metric-chart">
                                    <div class="chart-bar" style="width: 95%"></div>
                                </div>
                                <div class="metric-value">
                                    <span class="value">95%</span>
                                    <span class="trend positive"><i class="fas fa-arrow-up"></i> 12%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="metric-card">
                            <div class="metric-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="metric-content">
                                <h4>Avg. Wait Time</h4>
                                <div class="metric-chart">
                                    <div class="chart-bar" style="width: 100%"></div>
                                </div>
                                <div class="metric-value">
                                    <span class="value">Instant</span>
                                    <span class="trend positive"><i class="fas fa-arrow-up"></i> 30%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="metric-card">
                            <div class="metric-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="metric-content">
                                <h4>User Protection</h4>
                                <div class="metric-chart">
                                    <div class="chart-bar" style="width: 100%"></div>
                                </div>
                                <div class="metric-value">
                                    <span class="value">100%</span>
                                    <span class="trend positive"><i class="fas fa-check"></i> Certified</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="section testimonials-section">
            <div class="section-container">
                <h2 class="section-title animate-on-scroll">Healthcare Testimonials</h2>
                <p class="section-subtitle animate-on-scroll">See what healthcare professionals are saying about our system</p>

                <div class="testimonials-flex-container">
                    <!-- Testimonial 1 -->
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-image">
                            <div class="image-placeholder">
                                <img src="uploads/494358060_932894782187820_8463390880289035124_n.png" alt="" class="img-property" />
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <div class="patient-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"Dating adik, ngayon adik na sayo."</p>
                            <div class="patient-info">
                                <h4>Harry Lagmany</h4>
                                <p>Drug Overdose Patient</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-image">
                            <div class="image-placeholder">
                                <img src="uploads/rewr.png" class="img-property" />
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <div class="patient-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="testimonial-text">"Nurse pa lang gumagaling na ako."</p>
                            <div class="patient-info">
                                <h4>Mac Mac</h4>
                                <p>Diabetic sa sweet-words</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-image">
                            <div class="image-placeholder">
                                <img src="uploads/7y56.png" alt="" class="img-property" />
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <div class="patient-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"Sa bawat click, may malasakit"</p>
                            <div class="patient-info">
                                <h4>Jah Mes</h4>
                                <p>Gutom Survivor</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 4 -->
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-image">
                            <div class="image-placeholder">
                                <i class="fas fa-user-circle"></i>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <div class="patient-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"As a hospital administrator, I appreciate the comprehensive security features that ensure HIPAA compliance."</p>
                            <div class="patient-info">
                                <h4>Michael Chen</h4>
                                <p>Hospital Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section contact-section">
            <div class="section-container">
                <h2 class="section-title animate-on-scroll">Contact Us</h2>
                <p class="section-subtitle animate-on-scroll">Need help with implementation or have questions about our healthcare system? Reach out to our team.</p>

                <div class="contact-grid">
                    <div class="contact-form animate-on-scroll">

                        <?php
                                if (isset($_GET['msg'])) {
                                    if ($_GET['msg'] === 'success') {
                                        echo '<p style="color:var(--success); font-weight:bold;">Thank you for submitting! Your message has been sent successfully.</p>';
                                    } else if ($_GET['msg'] === 'error') {
                                        echo '<p style="color:var(--error); font-weight:bold;">Error sending message. Please try again.</p>';
                                    }
                                }
                                ?>

                        <form action="contact_submit.php" method="POST">
                            <div class="form-group">
                                <input type="text" name="c_name" placeholder="Your Name" required />
                            </div>
                            <div class="form-group">
                                <input type="email" name="c_email" placeholder="Your Email" required />
                            </div>
                            <div class="form-group">
                                <textarea name="c_message" placeholder="Your Message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn-primary">Send Message</button>
                        </form>
                    </div>

                    <div class="contact-info animate-on-scroll">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>123 Healthcare Blvd, Medical District, MD 12345</p>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <p>+1 (234) 567-8900</p>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <p>info@medicare-systems.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <div class="logo">MediCare</div>
                <p>Advanced healthcare management made simple.</p>
            </div>

            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Features</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <div class="footer-social">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 MediCare Healthcare Systems. All Rights Reserved.</p>
        </div>
    </footer>

   <!-- Popup Message Container -->
<div id="popup-message" class="popup <?php echo $show_success ? 'success' : ($show_error ? 'error' : ''); ?>">
    <p>
        <?php
        if ($show_success) {
            echo "✅ Thank you for submitting! Your message has been sent.";
        } elseif ($show_error) {
            echo "❌ Error sending message. Please try again.";
        }
        ?>
    </p>
</div>

<style>
    .popup {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #333;
        color: #fff;
        padding: 16px 24px;
        border-radius: 8px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.5s ease-in-out;
        z-index: 9999;
        font-weight: bold;
    }

    .popup.success {
        background-color: #28a745;
    }

    .popup.error {
        background-color: #dc3545;
    }

    .popup.show {
        opacity: 1;
        pointer-events: auto;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const popup = document.getElementById("popup-message");
        if (popup.classList.contains("success") || popup.classList.contains("error")) {
            popup.classList.add("show");
            setTimeout(() => {
                popup.classList.remove("show");
            }, 4000); // hide after 4 seconds
        }
    });
</script>


</body>
</html>




