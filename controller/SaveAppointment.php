<?php

require_once "../../config/Database.php";
require_once "../../model/AppointmentController.php";

$db = new Database();
$conn = $db->connect();

$appointment = new AppointmentController();


$data = [

    'patient_id' => $_POST['patient_id'],
    'doctor_id' => $_POST['doctor_id'],
    'appointment_date' => $_POST['appointment_date'],
    'appointment_time' => $_POST['appointment_time'],
    'purpose' => $_POST['purpose']

];

if($appointment->saveAppointment($data)){

    echo "success";

}else{

    echo "failed";

}

?>