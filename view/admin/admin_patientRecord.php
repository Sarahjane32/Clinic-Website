<?php

require_once "../../config/Database.php";

$db = new Database();
$conn = $db->connect();

$search = $_GET['search'] ?? '';

$patient = null;
$appointments = [];

if($search != ''){

 $query = "

 SELECT *
 FROM patients
 WHERE full_name LIKE :search

 ";

 $stmt = $conn->prepare($query);

 $stmt->execute([
  ':search' => "%$search%"
 ]);

 $patient =
 $stmt->fetch(PDO::FETCH_ASSOC);

 if($patient){

  $query2 = "

  SELECT

  appointments.appointment_date,
  appointments.status,
  appointments.purpose,

  users.last_name

  FROM appointments

  INNER JOIN users
  ON appointments.doctor_id =
  users.user_id

  WHERE appointments.patient_id =
  :patient_id

  ORDER BY appointments.appointment_date DESC

  ";

  $stmt2 =
  $conn->prepare($query2);

  $stmt2->execute([
   ':patient_id' =>
   $patient['patient_id']
  ]);

  $appointments =
  $stmt2->fetchAll(PDO::FETCH_ASSOC);
 }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records</title>

    <link rel="stylesheet" href="../css/admin_patientRecord.css">
</head>
<body>

<div class="record-box">

    <a href="../admin/admin_dashboard.php" class="back-btn"> ← Back to Dashboard </a>

    <h1>Patient Record</h1>

    <form method="GET" class="search-bar">

        <input
        type="text"
        name="search"
        placeholder="Search Patient"
        required
        >

        <button type="submit">
        Search
        </button>

    </form>

    <div class="patient-info">

        <?php if($patient): ?>

        <div class="patient-info">

            <p>
            <strong>Patient ID:</strong>
            <?php echo $patient['patient_id']; ?>
            </p>

            <p>
            <strong>Name:</strong>
            <?php echo $patient['full_name']; ?>
            </p>

            <p>
            <strong>Contact:</strong>
            <?php echo $patient['contact_number']; ?>
            </p>

            <p>
            <strong>Address:</strong>
            <?php echo $patient['address']; ?>
            </p>

        </div>

        <?php endif; ?>

    </div>

    <h2>Appointment History</h2>

    <table>

        <thead>

            <tr>
                <th>Date</th>
                <th>Doctor</th>
                <th>Diagnosis</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

            <?php foreach($appointments as $appointment): ?>

            <tr>

            <td>
            <?php echo $appointment['appointment_date']; ?>
            </td>

            <td>
            Dr.
            <?php echo $appointment['last_name']; ?>
            </td>

            <td>
            <?php echo $appointment['purpose']; ?>
            </td>

            <td>
            <?php echo $appointment['status']; ?>
            </td>

            </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>
</html>