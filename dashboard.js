// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", function () {
    // nav
    const navOverview = document.getElementById("nav-overview");
    const navAppointments = document.getElementById("nav-appointments");
    const navMedications = document.getElementById("nav-medications");
    const navHealthRecords = document.getElementById("nav-healthRecords");

    // sections
    const sectionOverview = document.getElementById("dashboard-overview");
    const sectionAppointments = document.getElementById(
        "dashboard-appointments"
    );
    const sectionMedications = document.getElementById("dashboard-medications");
    const sectionHealthRecords = document.getElementById(
        "dashboard-healthrecords"
    );

    //When you click a button (nav item), the right content (section) appears, and the active button stays highlighted.

    // overview clicked
    navOverview.addEventListener("click", function () {
        sectionOverview.style.display = "block";
        sectionAppointments.style.display = "none";
        sectionMedications.style.display = "none";
        sectionHealthRecords.style.display = "none";

        // Active class toggle
    });

    // if appointments have been clicked this will happen
    navAppointments.addEventListener("click", function () {
        sectionOverview.style.display = "none";
        sectionAppointments.style.display = "block";
        sectionMedications.style.display = "none";
        sectionHealthRecords.style.display = "none";

        // Active class toggle
    });

    navMedications.addEventListener("click", function () {
        sectionOverview.style.display = "none";
        sectionAppointments.style.display = "none";
        sectionMedications.style.display = "block";
        sectionHealthRecords.style.display = "none";
    });

    navHealthRecords.addEventListener("click", function () {
        sectionOverview.style.display = "none";
        sectionAppointments.style.display = "none";
        sectionMedications.style.display = "none";
        sectionHealthRecords.style.display = "block";
    });
});
