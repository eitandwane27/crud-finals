// Modern Dashboard Functionality with Enhanced Animations
document.addEventListener("DOMContentLoaded", function () {
    // Navigation elements with destructuring
    const [navOverview, navAppointments, navMedications, navHealthRecords] = [
        "nav-overview",
        "nav-appointments",
        "nav-medications",
        "nav-healthRecords",
    ].map((id) => document.getElementById(id));

    // Content sections with destructuring
    const [
        sectionOverview,
        sectionAppointments,
        sectionMedications,
        sectionHealthRecords,
    ] = [
        "dashboard-overview",
        "dashboard-appointments",
        "dashboard-medications",
        "dashboard-healthrecords",
    ].map((id) => document.getElementById(id));

    // Store all nav items and sections
    const navItems = [
        navOverview,
        navAppointments,
        navMedications,
        navHealthRecords,
    ];
    const sections = [
        sectionOverview,
        sectionAppointments,
        sectionMedications,
        sectionHealthRecords,
    ];

    // Modern animation configuration with spring physics
    const ANIMATION_CONFIG = {
        duration: 400,
        easing: "cubic-bezier(0.34, 1.56, 0.64, 1)", // Spring-like easing
        delay: 50,
    };

    // Apply initial animations to stat cards with staggered delay
    const statCards = document.querySelectorAll(".stat-card");
    statCards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";

        setTimeout(() => {
            card.style.transition = `all ${ANIMATION_CONFIG.duration}ms ${ANIMATION_CONFIG.easing}`;
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, 100 + index * 100);
    });

    // Enhanced active state management with animations
    function updateActiveStates(activeNav) {
        navItems.forEach((item) => {
            if (!item) return;

            if (item === activeNav) {
                item.classList.add("active");
                item.querySelector("a").style.transform = "translateX(8px)";
            } else {
                item.classList.remove("active");
                item.querySelector("a").style.transform = "translateX(0)";
            }
            item.querySelector(
                "a"
            ).style.transition = `all ${ANIMATION_CONFIG.duration}ms ${ANIMATION_CONFIG.easing}`;
        });
    }

    // Enhanced section display with modern transitions
    function showSection(activeSection) {
        sections.forEach((section) => {
            if (!section) return;

            if (section === activeSection) {
                section.style.display = "block";
                section.classList.add("active");

                // Animate child elements with staggered delay
                const childElements = section.querySelectorAll(
                    ".stat-card, .appointment-item, .medication-item, .profile-card"
                );
                childElements.forEach((element, index) => {
                    element.style.opacity = "0";
                    element.style.transform = "translateY(20px)";

                    setTimeout(() => {
                        element.style.transition = `all ${ANIMATION_CONFIG.duration}ms ${ANIMATION_CONFIG.easing}`;
                        element.style.opacity = "1";
                        element.style.transform = "translateY(0)";
                    }, 100 + index * 100);
                });
            } else {
                section.classList.remove("active");

                setTimeout(() => {
                    if (!section.classList.contains("active")) {
                        section.style.display = "none";
                    }
                }, ANIMATION_CONFIG.duration);
            }
        });
    }

    // Modern event listeners with enhanced feedback
    navItems.forEach((navItem, index) => {
        if (!navItem) return;

        navItem.addEventListener("click", (e) => {
            e.preventDefault();
            updateActiveStates(navItem);
            showSection(sections[index]);

            // Add ripple effect
            const navLink = navItem.querySelector("a");
            const ripple = document.createElement("div");
            ripple.classList.add("nav-ripple");

            const rect = navLink.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;

            navLink.appendChild(ripple);
            setTimeout(() => ripple.remove(), 1000);
        });

        // Add hover animations
        const navLink = navItem.querySelector("a");
        navLink.addEventListener("mouseenter", () => {
            const icon = navLink.querySelector("i");
            if (icon) {
                icon.style.transform = "scale(1.2) translateX(3px)";
                icon.style.transition =
                    "transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)";
            }
        });

        navLink.addEventListener("mouseleave", () => {
            const icon = navLink.querySelector("i");
            if (icon) {
                icon.style.transform = "scale(1) translateX(0)";
            }
        });
    });

    // Initialize dashboard
    updateActiveStates(navOverview);
    showSection(sectionOverview);

    // Enhanced card interactions with advanced effects
    const cards = document.querySelectorAll(
        ".stat-card, .appointment-item, .medication-item"
    );

    cards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-8px) scale(1.02)";
            this.style.boxShadow = "0 15px 30px rgba(67, 97, 238, 0.1)";

            // Animate icon if present
            const icon = this.querySelector(".stat-icon, .medication-icon");
            if (icon) {
                icon.style.transform = "scale(1.1) rotate(5deg)";
                icon.style.transition =
                    "transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)";
            }
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0) scale(1)";
            this.style.boxShadow = "";

            // Reset icon animation
            const icon = this.querySelector(".stat-icon, .medication-icon");
            if (icon) {
                icon.style.transform = "scale(1) rotate(0deg)";
            }
        });
    });

    // Animate welcome banner
    const welcomeBanner = document.querySelector(".welcome-banner");
    if (welcomeBanner) {
        welcomeBanner.style.opacity = "0";
        welcomeBanner.style.transform = "translateY(20px)";

        setTimeout(() => {
            welcomeBanner.style.transition = `all 0.6s ${ANIMATION_CONFIG.easing}`;
            welcomeBanner.style.opacity = "1";
            welcomeBanner.style.transform = "translateY(0)";
        }, 300);

        const welcomeImage = welcomeBanner.querySelector(".welcome-image img");
        if (welcomeImage) {
            welcomeImage.addEventListener("mouseenter", () => {
                welcomeImage.style.transform =
                    "translateY(-10px) scale(1.1) rotate(3deg)";
            });

            welcomeImage.addEventListener("mouseleave", () => {
                welcomeImage.style.transform =
                    "translateY(0) scale(1) rotate(0deg)";
            });
        }
    }

    // Modern search functionality with smooth animations
    const searchBox = document.querySelector(".search-box input");
    if (searchBox) {
        searchBox.addEventListener(
            "input",
            debounce(function (e) {
                const searchTerm = e.target.value.toLowerCase();
                const searchableElements = document.querySelectorAll(
                    ".appointment-item, .medication-item"
                );

                searchableElements.forEach((element, index) => {
                    const text = element.textContent.toLowerCase();
                    const match = text.includes(searchTerm);

                    // Apply staggered animations
                    setTimeout(() => {
                        if (match) {
                            element.style.display = "flex";
                            element.style.opacity = "0";
                            element.style.transform = "translateY(20px)";

                            setTimeout(() => {
                                element.style.transition = `all 0.4s ${ANIMATION_CONFIG.easing}`;
                                element.style.opacity = "1";
                                element.style.transform = "translateY(0)";
                            }, 50);
                        } else {
                            element.style.transition = `all 0.3s ease`;
                            element.style.opacity = "0";
                            element.style.transform =
                                "translateY(10px) scale(0.95)";

                            setTimeout(() => {
                                element.style.display = "none";
                            }, 300);
                        }
                    }, index * 30);
                });
            }, 250)
        );
    }

    // Add parallax effect to the welcome banner
    if (welcomeBanner) {
        document.addEventListener("mousemove", (e) => {
            const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
            const moveY = (e.clientY - window.innerHeight / 2) * 0.01;

            welcomeBanner.style.transform = `translate(${moveX}px, ${moveY}px)`;

            const welcomeImage =
                welcomeBanner.querySelector(".welcome-image img");
            if (welcomeImage) {
                welcomeImage.style.transform = `translate(${moveX * -2}px, ${
                    moveY * -2
                }px)`;
            }
        });
    }

    // Utility function for debouncing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Add smooth page load transition
    document.body.style.opacity = "0";
    setTimeout(() => {
        document.body.style.transition = `opacity 0.8s ease`;
        document.body.style.opacity = "1";
    }, 100);

    // Add notifications system
    const notificationBell = document.querySelector(".notification");
    if (notificationBell) {
        notificationBell.addEventListener("click", () => {
            // Create a notification toast
            const toast = document.createElement("div");
            toast.className = "notification-toast";
            toast.innerHTML = `
                <div class="toast-header">
                    <i class="fas fa-bell"></i>
                    <span>New Notification</span>
                    <button>&times;</button>
                </div>
                <div class="toast-body">
                    <p>You have a new appointment tomorrow at 10:00 AM.</p>
                </div>
            `;

            // Add styles through JS to keep it encapsulated
            toast.style.position = "fixed";
            toast.style.top = "20px";
            toast.style.right = "20px";
            toast.style.background = "white";
            toast.style.padding = "15px";
            toast.style.borderRadius = "10px";
            toast.style.boxShadow = "0 5px 15px rgba(0, 0, 0, 0.1)";
            toast.style.zIndex = "1000";
            toast.style.minWidth = "300px";
            toast.style.transform = "translateX(400px)";
            toast.style.opacity = "0";
            toast.style.transition =
                "all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)";

            // Style toast header
            const toastHeader = toast.querySelector(".toast-header");
            toastHeader.style.display = "flex";
            toastHeader.style.justifyContent = "space-between";
            toastHeader.style.alignItems = "center";
            toastHeader.style.marginBottom = "10px";
            toastHeader.style.paddingBottom = "10px";
            toastHeader.style.borderBottom = "1px solid #f1f5f9";

            // Style close button
            const closeButton = toast.querySelector("button");
            closeButton.style.background = "none";
            closeButton.style.border = "none";
            closeButton.style.fontSize = "18px";
            closeButton.style.cursor = "pointer";
            closeButton.style.color = "#64748b";

            // Add the toast to the document
            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.transform = "translateX(0)";
                toast.style.opacity = "1";
            }, 100);

            // Close on button click
            closeButton.addEventListener("click", () => {
                toast.style.transform = "translateX(400px)";
                toast.style.opacity = "0";
                setTimeout(() => {
                    toast.remove();
                }, 500);
            });

            // Auto-close after 5 seconds
            setTimeout(() => {
                toast.style.transform = "translateX(400px)";
                toast.style.opacity = "0";
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 5000);
        });
    }
});
