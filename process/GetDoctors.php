<?php

require_once "../../model/AppointmentController.php";

if(isset($_GET['specialization'])){

    $specialization = $_GET['specialization'];

    $appointment = new AppointmentController();

    $doctors = $appointment->getDoctorsBySpecialization($specialization);

    echo json_encode($doctors);

}

?>