<?php

    session_start();

    require_once "../../model/DashboardController.php";

    if(!isset($_SESSION['user_id'])){

        header("Location:index.php");
        exit();
    }

    $lastname = $_SESSION['lastname'];
    $role = $_SESSION['role'];

    $dashboard =
    new DashboardController();

    $totalPatients =
    $dashboard->totalPatients();

    $todayAppointments =
    $dashboard->todayAppointments();

    $totalDoctors =
    $dashboard->totalDoctors();

    $followUps =
    $dashboard->followUps();

    $recentAppointments =
    $dashboard->recentAppointments();

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Appointments</title>

<link rel="stylesheet" href="../css/admin_appointment.css">
</head>

<body>

<div class="dashboard-container">

    <!--Side Bar-->
    <aside class="sidebar">

        <div>

            <div class="sidebar-top">

                <div class="profile-circle">
                    <img
                    src="<?php echo $_SESSION['profile_picture']; ?>"
                    alt="Profile">
                </div>

                <div class="profile-name">
                    <h2>
                        Ms. <?php echo $lastname; ?>
                    </h2>

                    <p>
                        <?php echo $role; ?>
                    </p>
                </div>

            </div>

            <nav class="sidebar-menu">

                <a href="../admin/admin_dashboard.php"
                    class="menu-item"
                    onclick="closeDropdown()">

                    Dashboard

                </a>

                <!--Patient-->
                <div class="dropdown">

                    <button class="menu-item dropdown-btn"
                        onclick="toggleDropdown()">

                        Patients

                    </button>

                    <div class="dropdown-content"
                        id="patientDropdown">

                        <a href="../admin/admin_registerPatient.php"
                            class="dropdown-item">

                            Register Patient

                        </a>

                        <a href="../admin/admin_patientRecord.php"
                            class="dropdown-item">

                            Search Patient Records

                        </a>

                    </div>

                </div>

                <a href="../admin/admin_appointment.php"
                    class="menu-item active"
                    onclick="closeDropdown()">

                    Appointments

                </a>

                <a href="../admin/admin_doctors.php"
                    class="menu-item"
                    onclick="closeDropdown()">

                    Doctors

                </a>

                <a href="../login/logout.php"
                    class="menu-item logout-btn"
                    onclick="closeDropdown()">

                    Logout

                </a>

            </nav>

        </div>

    </aside>

    <!--Main content---------------------------->
    <main class="main-content">

        <header class="topbar">

            <div class="topbar-left">

                <img src="logo.jpg"
                    class="clinic-logo">

                <div class="clinic-text">

                    <h1>SwiftCare Clinic</h1>
                    <p>Clinic Appointment System</p>

                </div>

            </div>

            <div class="admin-box">
                Admin
            </div>

        </header>

        <!--Form-->
        <section class="appointment-card">

            <div class="section-header">
                Schedule Appointment
            </div>

            <div class="appointment-body">

                <select id="patientName">

                    <option value="">
                        Select Patient
                    </option>

                </select>

                <!--phone number-->
                <div class="phone-wrapper">

                    <input
                        id="phone"
                        type="text"
                        placeholder="Phone Number"
                        maxlength="11"
                    >

                    <small id="phoneError"
                        class="error-text"></small>

                </div>

                <!--Select Section-->
                <select id="sectionSelect">

                    <option value="">
                        Select Section
                    </option>

                    <option value="General Medicine">
                        General Medicine
                    </option>

                    <option value="Pediatrics">
                        Pediatrics
                    </option>

                    <option value="Dermatology">
                        Dermatology
                    </option>

                    <option value="Cardiology">
                        Cardiology
                    </option>

                    <option value="Neurology">
                        Neurology
                    </option>

                    <option value="Diabetology">
                        Diabetology
                    </option>

                </select>

                <input id="date" type="date">

                <!--Doctor cards-->
                <div id="doctorContainer"
                    class="doctor-container"></div>

                <!--Time-->
                <select id="time">
                    <option>Select Time</option>
                </select>

                <input id="purpose"
                    placeholder="Purpose">

                <button class="confirm-btn"
                    onclick="showReceipt()">

                    Confirm Appointment

                </button>

            </div>

        </section>

    </main>

</div>

<!--Receipt-->
<div class="receipt-card" id="receiptCard">

    <div class="receipt-body">

        <button class="close-x"
            onclick="closeReceipt()">
            ✖
        </button>

        <div class="section-header">
            Clinic Appointment
        </div>

        <p>
            <strong>Appointment No:</strong>
            A-1023
        </p>

        <p>
            <strong>Patient:</strong>
            <span id="rName"></span>
        </p>

        <p>
            <strong>Phone:</strong>
            <span id="rPhone"></span>
        </p>

        <p>
            <strong>Doctor:</strong>
            <span id="rDoctor"></span>
        </p>

        <p>
            <strong>Date:</strong>
            <span id="rDate"></span>
        </p>

        <p>
            <strong>Time:</strong>
            <span id="rTime"></span>
        </p>

        <p>
            <strong>Purpose:</strong>
            <span id="rPurpose"></span>
        </p>

        <div class="notice">
            Please arrive 15 minutes before your appointment.
        </div>

        <button class="print-btn"
            onclick="printReceipt()">
            Print Receipt
        </button>

    </div>

</div>

<script>

const dropdown =
document.getElementById("patientDropdown");

/*Dropdownn*/
function toggleDropdown(){
    dropdown.classList.toggle("show");
}

/*for close drop*/
function closeDropdown(){
    localStorage.setItem(
        "patientDropdown",
        "closed"
    );
}

window.onload = function(){

    if(localStorage.getItem(
        "patientDropdown"
    ) === "open"){

        dropdown.classList.add("show");
    }
}


const sectionSelect =
document.getElementById("sectionSelect");

const doctorContainer =
document.getElementById("doctorContainer");

const timeSelect =
document.getElementById("time");

const patientSelect =
document.getElementById("patientName");

/* LOAD PATIENTS */

fetch("GetPatients.php")

.then(response => response.json())

.then(patients => {

    patients.forEach(patient => {

        const option =
        document.createElement("option");

        option.value =
        patient.patient_id;

        option.text =
        patient.full_name;

        patientSelect.appendChild(option);

    });

});

let selectedDoctor = "";

/*Phone Validation*/
const phoneInput =
document.getElementById("phone");

const phoneError =
document.getElementById("phoneError");

phoneInput.addEventListener(
    "input",
    function(){

    /*ito yung para di gumana yung letters sa phone*/
    this.value =
    this.value.replace(/[^0-9]/g,'');

    /*naka limit na 11 digits lang*/
    if(this.value.length > 11){

        this.value =
        this.value.slice(0,11);
    }

    /*for error messages*/
    if(this.value.length === 0){

        phoneError.innerText = "";

    }
    else if(this.value.length < 11){

        phoneError.innerText =
        "Phone number must be 11 digits.";

    }
    else{

        phoneError.innerText = "";
    }

});


sectionSelect.addEventListener(
"change",
function(){

    doctorContainer.innerHTML = "";

    timeSelect.innerHTML =
    "<option>Select Time</option>";

    selectedDoctor = "";

    fetch(
        "GetDoctors.php?specialization=" +
        this.value
    )

    .then(response => response.json())

    .then(doctors => {

        doctors.forEach(doc => {

            const card =
            document.createElement("div");

            card.classList.add("doctor-card");

            card.innerHTML = `

                <div class="doctor-top">

                    <div class="doctor-pic"></div>

                    <div class="doctor-name">
                        Dr. ${doc.last_name}
                    </div>

                </div>

                <div class="doctor-sched">
                    ${doc.schedule_day || "No Schedule"} |
                    ${doc.schedule_time || ""}
                </div>

            `;

            card.onclick = function(){

                document
                .querySelectorAll(".doctor-card")
                .forEach(c =>
                    c.classList.remove("active")
                );

                card.classList.add("active");

                selectedDoctor = doc.user_id;

                timeSelect.innerHTML = "";

                let option =
                document.createElement("option");

                option.text =
                doc.schedule_time;

                timeSelect.appendChild(option);

            };

            doctorContainer.appendChild(card);

        });

    });

});

/*Receipt------------------------------------*/
function showReceipt(){

    const patientSelect =
    document.getElementById("patientName");

    const patientName =
    patientSelect.options[
        patientSelect.selectedIndex
    ].text;

    const patientId =
    patientSelect.value;

    const phone =
    document.getElementById("phone").value;

    const appointmentDate =
    document.getElementById("date").value;

    const appointmentTime =
    document.getElementById("time").value;

    const purpose =
    document.getElementById("purpose").value;

    if(phone.length !== 11){

        phoneError.innerText =
        "Phone number must be exactly 11 digits.";

        return;
    }

    if(selectedDoctor === ""){

        alert("Please select a doctor.");
        return;
    }

    const formData = new FormData();

    formData.append(
        "patient_id",
        patientId
    );

    formData.append(
        "doctor_id",
        selectedDoctor
    );

    formData.append(
        "appointment_date",
        appointmentDate
    );

    formData.append(
        "appointment_time",
        appointmentTime
    );

    formData.append(
        "purpose",
        purpose
    );

    fetch("SaveAppointment.php", {

        method:"POST",
        body:formData

    })

    .then(response => response.text())

    .then(data => {

        if(data === "success"){

            document.getElementById("rName")
            .innerText = patientName;

            document.getElementById("rPhone")
            .innerText = phone;

            document.getElementById("rDoctor")
            .innerText =
            document.querySelector(
                ".doctor-card.active .doctor-name"
            ).innerText;

            document.getElementById("rDate")
            .innerText = appointmentDate;

            document.getElementById("rTime")
            .innerText = appointmentTime;

            document.getElementById("rPurpose")
            .innerText = purpose;

            document.getElementById("receiptCard")
            .style.display = "flex";

        }else{

            alert(data);

        }

    });

}

function closeReceipt(){

    document.getElementById("receiptCard")
    .style.display = "none";
}

/*For print*/
function printReceipt(){
    window.print();
}


const name = localStorage.getItem("loggedInUser");
const role = localStorage.getItem("userRole");

/* SIDEBAR NAME */
document.getElementById("doctorName").innerHTML =
    "Ms. " + name;

/* SIDEBAR ROLE */
document.getElementById("doctorRole").innerHTML =
    role;


</script>

</body>
</html>