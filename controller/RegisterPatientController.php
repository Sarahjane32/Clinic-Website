<?php

require_once "../../config/Database.php";
require_once "../../model/Patient.php";

$db = new Database();
$conn = $db->connect();

$patient = new Patient($conn);

$data = [

    'full_name' => $_POST['name'],
    'gender' => $_POST['gender'],
    'birthdate' => $_POST['birthdate'],
    'contact_number' => $_POST['phone'],
    'address' => $_POST['address'],
    'emergency_contact' => $_POST['emergency'],
    'allergies' => $_POST['allergies'],
    'medical_history' => $_POST['history']

];

if($patient->registerPatient($data)){

    header("Location: ../admin/admin_registerPatient.php?success=1");

}else{

    echo "Failed to register patient.";

}

?>