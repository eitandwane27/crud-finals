// Theme Management
class ThemeManager {
    constructor() {
        this.themeToggle = document.getElementById("theme-toggle");
        this.themeIcon = this.themeToggle.querySelector("i");

        // Get stored theme or use light as default
        this.currentTheme = localStorage.getItem("theme") || "light";

        this.init();
    }

    init() {
        // Set initial theme
        document.documentElement.setAttribute("data-theme", this.currentTheme);
        this.updateThemeIcon();

        // Add event listener
        this.themeToggle.addEventListener("click", () => this.toggleTheme());
    }

    toggleTheme() {
        // Toggle theme
        this.currentTheme = this.currentTheme === "dark" ? "light" : "dark";

        // Update HTML attribute
        document.documentElement.setAttribute("data-theme", this.currentTheme);

        // Save preference
        localStorage.setItem("theme", this.currentTheme);

        // Add animation class
        this.themeToggle.classList.add("rotate");
        setTimeout(() => this.themeToggle.classList.remove("rotate"), 500);

        // Update icon
        this.updateThemeIcon();
    }

    updateThemeIcon() {
        // Remove existing classes
        this.themeIcon.className = "";

        // Add new classes
        if (this.currentTheme === "dark") {
            this.themeIcon.className = "fas fa-moon";
            this.themeToggle.style.color = "#f8fafc"; // Light color for dark mode
        } else {
            this.themeIcon.className = "fas fa-sun";
            this.themeToggle.style.color = "#0ea5e9"; // Blue color for light mode
        }
    }
}

// Navigation Management
class NavigationManager {
    constructor() {
        this.navItems = {
            dashboard: document.getElementById("nav-dashboard"),
            doctors: document.getElementById("nav-doctors"),
            team: document.getElementById("nav-team"),
        };

        this.contentSections = {
            dashboard: document.getElementById("dashboard-overview"),
            doctors: document.getElementById("dashboard-doctors"),
            team: document.getElementById("dashboard-team"),
        };

        this.headerTitle = document.getElementById("header-title");
        this.mainHeading = document.getElementById("main-heading");
        this.spanText = document.getElementById("span-text");
        this.searchForm = document.getElementById("search");

        this.init();
    }

    init() {
        // Add click handlers to navigation items
        Object.entries(this.navItems).forEach(([key, item]) => {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                this.navigate(key);
            });
        });

        // Set initial active section
        this.navigate("dashboard");

        // Handle browser back/forward buttons
        window.addEventListener("popstate", () => {
            this.navigate("dashboard");
        });
    }

    navigate(section) {
        // Update navigation active states
        Object.values(this.navItems).forEach((item) =>
            item.classList.remove("active")
        );
        this.navItems[section].classList.add("active");

        // Update content visibility with fade effect
        Object.entries(this.contentSections).forEach(([key, content]) => {
            if (key === section) {
                content.style.display = "block";
                content.classList.add("fade-in");
            } else {
                content.classList.remove("fade-in");
                content.style.display = "none";
            }
        });

        // Handle search form visibility
        if (this.searchForm) {
            const searchParent = this.searchForm.closest(".header-actions");
            if (searchParent) {
                if (section === "dashboard") {
                    searchParent.style.display = "block";
                    searchParent.style.opacity = "1";
                    searchParent.style.visibility = "visible";
                } else {
                    searchParent.style.display = "none";
                    searchParent.style.opacity = "0";
                    searchParent.style.visibility = "hidden";
                }
            }
        }

        // Update header text
        this.updateHeader(section);
    }

    updateHeader(section) {
        const titles = {
            dashboard: { main: "Patient Management", sub: "Patients" },
            doctors: { main: "Doctor Directory", sub: "Doctors" },
            team: { main: "Our Team", sub: "Team" },
        };

        this.mainHeading.textContent = titles[section].main;
        this.spanText.textContent = titles[section].sub;
    }
}

// Search Functionality
class SearchManager {
    constructor() {
        this.searchForm = document.getElementById("search");
        this.navigationManager = null;
        this.init();
    }

    init() {
        // Store reference to NavigationManager instance
        document.addEventListener("DOMContentLoaded", () => {
            this.navigationManager = window.navigationManager;
        });

        // Handle form submission
        this.searchForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const searchTerm = new FormData(this.searchForm)
                .get("search")
                .trim();

            // If search is empty or just whitespace, clear URL and show all patients
            if (!searchTerm) {
                // Remove search parameter from URL without reloading
                const url = new URL(window.location.href);
                url.searchParams.delete("search");
                window.history.pushState({}, "", url);

                // Clear the search input
                this.searchForm.querySelector('input[name="search"]').value =
                    "";

                // Force reload without search parameter
                window.location.href = url.toString();
                return;
            }

            // Proceed with search if there's a valid term
            window.location.href = `${
                this.searchForm.action
            }?search=${encodeURIComponent(searchTerm)}`;
        });

        // Handle page load/refresh
        window.addEventListener("load", () => {
            // Show dashboard overview on page load
            const dashboardOverview =
                document.getElementById("dashboard-overview");
            if (dashboardOverview) {
                dashboardOverview.style.display = "block";
                dashboardOverview.classList.add("fade-in");
            }

            // Ensure navigation is properly set
            const navDashboard = document.getElementById("nav-dashboard");
            if (navDashboard) {
                navDashboard.classList.add("active");
            }

            // Clear search input if no search parameter in URL
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has("search")) {
                this.searchForm.querySelector('input[name="search"]').value =
                    "";
            }
        });
    }
}

// Image Zoom Functionality
class ImageZoomManager {
    constructor() {
        this.modal = document.getElementById("imageZoomModal");
        this.modalImg = document.getElementById("zoomedImage");
        this.closeBtn = document.getElementById("closeZoomModal");
        this.init();
    }

    init() {
        // Add click event to all avatars
        document.body.addEventListener("click", (e) => {
            const img = e.target.closest(".patient-avatar img");
            if (img) {
                console.log("Image clicked:", img.src); // Debug log
                this.openModal(img);
            }
        });

        if (this.closeBtn) {
            this.closeBtn.addEventListener("click", () => {
                console.log("Close button clicked"); // Debug log
                this.closeModal();
            });
        }

        if (this.modal) {
            this.modal.addEventListener("click", (e) => {
                if (e.target === this.modal) {
                    console.log("Modal background clicked"); // Debug log
                    this.closeModal();
                }
            });
        }

        document.addEventListener("keydown", (e) => {
            if (
                e.key === "Escape" &&
                this.modal &&
                this.modal.classList.contains("active")
            ) {
                console.log("Escape key pressed"); // Debug log
                this.closeModal();
            }
        });
    }

    openModal(img) {
        if (this.modal && this.modalImg) {
            this.modalImg.src = img.src;
            this.modal.classList.add("active");
            document.body.style.overflow = "hidden";
            console.log("Modal opened with image:", img.src); // Debug log
        } else {
            console.error("Modal or modal image element not found");
        }
    }

    closeModal() {
        if (this.modal) {
            this.modal.classList.remove("active");
            document.body.style.overflow = "";
            console.log("Modal closed"); // Debug log
        }
    }
}

// Initialize all managers when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    // Initialize managers
    window.themeManager = new ThemeManager();
    window.navigationManager = new NavigationManager();
    window.searchManager = new SearchManager();
    window.imageZoomManager = new ImageZoomManager();

    console.log("All managers initialized"); // Debug log
});

// Add some CSS animations
const style = document.createElement("style");
style.textContent = `
    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .rotate {
        animation: rotate 0.5s ease-in-out;
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);

const navTeam = document.getElementById("nav-team");
const sound = new Audio("music/kikek.wav");

navTeam.addEventListener("click", () => {
    sound.currentTime = 0;
    sound.volume = 1;
    sound.play();
});
