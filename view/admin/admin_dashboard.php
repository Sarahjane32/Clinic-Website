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

    $_SESSION['profile_picture']

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0" />

    <title>Dashboard</title>

    <link rel="stylesheet"
        href="../css/admin_dashboard.css">
</head>

<body>

<div class="dashboard-container">

    <!--Side bar-->
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
                    class="menu-item active"
                    onclick="closeDropdown()">

                    Dashboard

                </a>

                <!--Patient Dropdown-->
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

                <!--Appointment-->
                <a href="../admin/admin_appointment.php"
                    class="menu-item"
                    onclick="closeDropdown()">

                    Appointments

                </a>

                <!--Doctors-->
                <a href="../admin/admin_doctors.php"
                    class="menu-item"
                    onclick="closeDropdown()">

                    Doctors

                </a>

                <!--Log out-->
                <a href="../login/logout.php"
                    class="menu-item logout-btn"
                    onclick="closeDropdown()">

                    Logout

                </a>

            </nav>

        </div>

    </aside>

    <!--Main Content-->
    <main class="main-content">

        <!--Top Bar-->
        <header class="topbar">

            <div class="topbar-left">

                <img src="logo.jpg"
                    alt="Clinic Logo"
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

        <section class="stats-grid">

            <div class="stat-card">

                <h3>Total Patients</h3>
                <p>
                    <?php
                    echo $totalPatients['total'];
                    ?>
                </p>

            </div>

            <div class="stat-card">

                <h3>Today</h3>
                <p>
                    <?php
                    echo $todayAppointments['total'];
                    ?>
                </p>

            </div>

            <div class="stat-card">

                <h3>Doctors</h3>
                <p>
                    <?php
                    echo $totalDoctors['total'];
                    ?>
                </p>

            </div>

            <div class="stat-card">

                <h3>Follow Up</h3>
                <p>
                    <?php
                    echo $followUps['total'];
                    ?>
                </p>

            </div>

        </section>

        <section class="table-section">

            <div class="section-header">
                Recent Appointments
            </div>

            <table class="appointment-table">

                <thead>

                    <tr>

                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($recentAppointments as $appointment): ?>

                    <tr>

                        <td>
                            <?php
                            echo $appointment['patient_name'];
                            ?>
                        </td>

                        <td>

                            Dr.

                            <?php
                            echo $appointment['last_name'];
                            ?>

                        </td>

                        <td>

                            <?php
                            echo $appointment['appointment_date'];
                            ?>

                        </td>

                        <td>

                            <span class="status
                            <?php

                            echo strtolower(
                                $appointment['status']
                            );

                            ?>">

                            <?php
                            echo $appointment['status'];
                            ?>

                            </span>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                    </tbody>

            </table>

        </section>

    </main>

</div>

<script>

const dropdown =
    document.getElementById(
        "patientDropdown"
    );

/*Toggle Dropdown*/
function toggleDropdown(){

    dropdown.classList.toggle("show");

    if(dropdown.classList.contains("show")){

        localStorage.setItem(
            "patientDropdown",
            "open"
        );

    }else{

        localStorage.setItem(
            "patientDropdown",
            "closed"
        );

    }

}

/*Close Dropdown*/
function closeDropdown(){

    localStorage.setItem(
        "patientDropdown",
        "closed"
    );

}

window.onload = function(){

    if(localStorage.getItem(
        "patientDropdown") === "open"){

        dropdown.classList.add("show");

    }

}
</script>
 


</body>
</html>