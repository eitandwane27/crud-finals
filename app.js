// Intersection Observer for scroll animations with simplified sequential effects
const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const element = entry.target;

                // Special handling for tree branches to create sequential animation
                if (element.classList.contains("tree-branch")) {
                    // Get the delay from data attribute
                    const branchDelay = parseFloat(element.dataset.delay || 0);

                    setTimeout(() => {
                        // First show the branch
                        element.classList.add("show");

                        // Then show sub branches with a small delay
                        const subBranches =
                            element.querySelectorAll(".tree-sub-branch");
                        subBranches.forEach((subBranch, index) => {
                            setTimeout(() => {
                                subBranch.classList.add("show");
                            }, 300 * (index + 1));
                        });
                    }, branchDelay * 1000);
                } else {
                    // Normal animations for non-branch elements
                    element.classList.add("show");

                    // Use delay if specified
                    const delay = element.dataset.delay;
                    if (delay) {
                        element.style.transitionDelay = `${delay}s`;
                    }
                }
            }
        });
    },
    {
        threshold: 0.15,
        rootMargin: "0px 0px -50px 0px", // Trigger a bit earlier
    }
);

// Apply animation to all elements with animate-on-scroll class
const animateElements = document.querySelectorAll(".animate-on-scroll");
animateElements.forEach((el) => observer.observe(el));

// Special sequential animation for tree branches
const treeBranches = document.querySelectorAll(".tree-branch");
treeBranches.forEach((branch) => {
    // Ensure we observe each branch separately
    observer.observe(branch);
});

// Add page load animation
document.addEventListener("DOMContentLoaded", function () {
    // Animate the header
    setTimeout(() => {
        document.querySelector("header").style.transform = "translateY(0)";
        document.querySelector("header").style.opacity = "1";
    }, 200);

    // Add subtle floating animation to floating cards
    initFloatingCards();

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 100,
                    behavior: "smooth",
                });
            }
        });
    });

    // Initialize popup message if present
    const popup = document.getElementById("popup-message");
    if (
        popup &&
        (popup.classList.contains("success") ||
            popup.classList.contains("error"))
    ) {
        popup.classList.add("show");
        setTimeout(() => {
            popup.classList.remove("show");
        }, 4000);
    }

    // Add subtle hover effects to cards
    const cards = document.querySelectorAll(".dashboard-card");
    cards.forEach((card) => {
        card.addEventListener("mouseenter", () => {
            card.style.transform = "translateY(-10px)";
        });

        card.addEventListener("mouseleave", () => {
            card.style.transform = "";
        });
    });

    // Animate chart bars with sequential timing
    const chartBars = document.querySelectorAll(".chart-bar");
    chartBars.forEach((bar, index) => {
        const width = bar.style.width;
        bar.style.width = "0";

        setTimeout(() => {
            bar.style.transition = "width 1s ease-out";
            bar.style.width = width;
        }, 500 + index * 150);
    });
});

// Enhanced floating cards animation with smoother motion
function initFloatingCards() {
    const floatingCards = document.querySelectorAll(".floating-card");

    floatingCards.forEach((card, index) => {
        // First, remove any existing animations or transitions
        if (card.animation) {
            card.animation.cancel();
        }

        // Create more natural motion with subtle rotation and horizontal movement
        const keyframes = [
            {
                transform: "translate(0, 0) rotate(0deg)",
                easing: "cubic-bezier(0.4, 0, 0.2, 1)",
            },
            {
                transform: "translate(4px, -15px) rotate(0.8deg)",
                easing: "cubic-bezier(0.4, 0, 0.2, 1)",
            },
            {
                transform: "translate(-3px, -8px) rotate(-0.4deg)",
                easing: "cubic-bezier(0.4, 0, 0.2, 1)",
            },
            { transform: "translate(0, 0) rotate(0deg)" },
        ];

        // Longer duration for more fluid motion
        const duration = 7000 + index * 800;

        // Each card gets its own timing to avoid synchronization
        const delay = index * 800;

        // Apply the animation with improved cubic-bezier for smoother transitions
        const animation = card.animate(keyframes, {
            duration: duration,
            delay: delay,
            iterations: Infinity,
            easing: "cubic-bezier(0.4, 0, 0.2, 1)",
        });

        // Store animation reference
        card.animation = animation;

        // Add subtle shadow and glow animation separately for better performance
        setInterval(() => {
            card.style.transition =
                "box-shadow 1.8s cubic-bezier(0.4, 0, 0.2, 1)";
            card.style.boxShadow =
                "0 15px 30px rgba(0, 0, 0, 0.15), 0 0 15px rgba(79, 70, 229, 0.2)";

            setTimeout(() => {
                card.style.boxShadow = "0 10px 20px rgba(0, 0, 0, 0.1)";
            }, 1800);
        }, duration);
    });
}
