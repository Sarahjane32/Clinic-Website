<?php

session_start();

require_once "../../model/DoctorController.php";

if(!isset($_SESSION['user_id'])){
 header("Location: ../login/login.php");
 exit();
}

$lastname = $_SESSION['lastname'];
$role = $_SESSION['role'];

$doctorController =
new DoctorController();

$doctors =
$doctorController->getDoctors();

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0"/>

    <title>Doctors</title>

    <link rel="stylesheet"
        href="../css/admin_doctors.css">

</head>

<body>

<div class="dashboard-container">

    <!--Sidebar-->
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

                <!-- Dashboard -->
                <a href="../admin/admin_dashboard.php"
                    class="menu-item">

                    Dashboard

                </a>

                <!-- Patients Dropdown -->
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

                <!-- Appointments -->
                <a href="../admin/admin_appointment.php"
                    class="menu-item">

                    Appointments

                </a>

                <!-- Doctors -->
                <a href="../admin/admin_doctors.php"
                    class="menu-item active">

                    Doctors

                </a>

                <!-- Logout -->
                <a href="../login/logout.php"
                    class="menu-item logout-btn">

                    Logout

                </a>

            </nav>

        </div>

    </aside>

    <!--Main Content-->
    <main class="main-content">

        <!--Topbar-->
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

        <!--Doctor Table-->
        <section class="table-section">

            <div class="section-header">

                Doctors List

            </div>

            <table class="doctor-table">

                <thead>

                    <tr>

                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>License Number</th>
                        <th>Schedule Day</th>
                        <th>Schedule Time</th>
                        <th>Contact Number</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($doctors as $doctor): ?>

                    <tr data-id="<?php echo $doctor['user_id']; ?>">

                    <td>
                    Dr. <?php echo $doctor['last_name']; ?>
                    </td>

                    <td>
                    <input
                    type="text"
                    value="<?php echo $doctor['specialization']; ?>"
                    disabled
                    >
                    </td>

                    <td>
                    <input
                    type="text"
                    value="<?php echo $doctor['license_number']; ?>"
                    disabled
                    >
                    </td>

                    <td>
                    <?php echo $doctor['schedule_day']; ?>
                    </td>

                    <td>
                    <?php echo $doctor['schedule_time']; ?>
                    </td>

                    <td>
                    <input
                    type="text"
                    value="<?php echo $doctor['contact_number']; ?>"
                    disabled
                    >
                    </td>

                    <td>

                    <div class="action-box">

                    <button
                    class="edit-btn"
                    onclick="editDoctor(this)"
                    >
                    Edit
                    </button>

                    <button
                    class="delete-btn"
                    onclick="deleteDoctor(this)"
                    >
                    Delete
                    </button>

                    </div>

                    </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </section>

    </main>

</div>


<script>

/* =========================
EDIT
========================= */

function editDoctor(button){

 const row =
 button.closest("tr");

 const inputs =
 row.querySelectorAll("input");

 const userId =
 row.dataset.id;

 /* SAVE MODE */

 if(button.innerText === "Save"){

  const formData =
  new FormData();

  formData.append(
   "user_id",
   userId
  );

  formData.append(
   "specialization",
   inputs[0].value
  );

  formData.append(
   "license_number",
   inputs[1].value
  );

  formData.append(
   "contact_number",
   inputs[2].value
  );

  fetch("UpdateDoctor.php",{

   method:"POST",
   body:formData

  })

  .then(response => response.text())

  .then(data => {

   if(data === "success"){

    inputs.forEach(input => {

     input.disabled = true;

    });

    button.innerText = "Edit";

    alert(
     "Doctor updated successfully."
    );

   }else{

    alert(
     "Failed to update doctor."
    );

   }

  });

  return;

 }

 /* ENABLE INPUTS */

 inputs.forEach(input => {

  input.disabled = false;

 });

 button.innerText = "Save";

}

/* =========================
DELETE
========================= */

function deleteDoctor(button){

 const row =
 button.closest("tr");

 const userId =
 row.dataset.id;

 const confirmDelete =
 confirm(
 "Are you sure you want to delete this doctor?"
 );

 if(confirmDelete){

  const formData =
  new FormData();

  formData.append(
   "user_id",
   userId
  );

  fetch("DeleteDoctor.php",{

   method:"POST",
   body:formData

  })

  .then(response => response.text())

  .then(data => {

   if(data === "success"){

    row.remove();

    alert(
     "Doctor deleted successfully."
    );

   }else{

    alert(
     "Failed to delete doctor."
    );

   }

  });

 }

}

</script>

</body>
</html>