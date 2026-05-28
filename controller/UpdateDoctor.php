<?php

require_once "../../model/DoctorController.php";

$doctor =
new DoctorController();

$data = [

 'user_id' =>
 $_POST['user_id'],

 'specialization' =>
 $_POST['specialization'],

 'license_number' =>
 $_POST['license_number'],

 'contact_number' =>
 $_POST['contact_number']

];

if($doctor->updateDoctor($data)){

 echo "success";

}else{

 echo "failed";

}
?>