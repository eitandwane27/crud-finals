// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", function () {
    // Get nav items
    const navOverview = document.getElementById("nav-overview");
    const navAppointments = document.getElementById("nav-appointments");
    const navMedications = document.getElementById("nav-medications");

    // Get sections
    const sectionOverview = document.getElementById("dashboard-overview");
    const sectionAppointments = document.getElementById(
        "dashboard-appointments"
    );
    const sectionMedications = document.getElementById("dashboard-medications");

    //When you click a button (nav item), the right content (section) appears, and the active button stays highlighted.

    // overview clicked
    navOverview.addEventListener("click", function () {
        sectionOverview.style.display = "block";
        sectionAppointments.style.display = "none";

        // Active class toggle
        navOverview.classList.add("active");
        navAppointments.classList.remove("active");
    });

    // if appointments have been clicked this will happen
    navAppointments.addEventListener("click", function () {
        sectionOverview.style.display = "none";
        sectionAppointments.style.display = "block";
        sectionMedications.style.display = "none";

        // Active class toggle
        navAppointments.classList.add("active");
        navOverview.classList.remove("active"); //the remove is optional if may display none sa inline HTML
        navMedications.classList.remove("active");
    });

    navMedications.addEventListener("click", function () {
        sectionOverview.style.display = "none";
        sectionAppointments.style.display = "none";
        sectionMedications.style.display = "block";

        navMedications.classList.add("active");
    });
});
