document.addEventListener("DOMContentLoaded", function () {
    const navDashboard = document.getElementById("nav-dashboard");
    const navDoctors = document.getElementById("nav-doctors");
    const navPatients = document.getElementById("nav-patients");
    const navTeam = document.getElementById("nav-team");

    const patientSection = document.getElementById("dashboard-overview");
    const doctorSection = document.getElementById("dashboard-doctors");
    const searchSection = document.getElementById("search");
    const recentSection = document.getElementById("dashboard-patients");
    const teamSection = document.getElementById("dashboard-team");

    const headerTitle = document.getElementById("main-heading");
    const spanText = document.getElementById("span-text");


    navDashboard.addEventListener("click", () => {
        patientSection.style.display = "block";
        doctorSection.style.display = "none";
        headerTitle.textContent = "Patient Management";
        spanText.textContent = "Patients";
        searchSection.style.display = "block";
        recentSection.style.display = "none";
        teamSection.style.display = "none";
    });

    navDoctors.addEventListener("click", () => {
        patientSection.style.display = "none";
        doctorSection.style.display = "block";
        headerTitle.textContent = "Doctor Management";
        spanText.textContent = "Doctors";
        searchSection.style.display = "none";
        recentSection.style.display = "none";
        teamSection.style.display = "none";
    });

    navPatients.addEventListener("click", () => {
        patientSection.style.display = "none";
        doctorSection.style.display = "none";
        headerTitle.textContent = "Patient Management";
        spanText.textContent = "Patients";
        recentSection.style.display = "block";
        searchSection.style.display = "none";
        teamSection.style.display = "none";
    });

    navTeam.addEventListener("click", () => {
        patientSection.style.display = "none";
        doctorSection.style.display = "none";
        headerTitle.textContent = "Our Team";
        spanText.textContent = "";
        recentSection.style.display = "none";
        searchSection.style.display = "none";
        teamSection.style.display = "block";
    });

});
