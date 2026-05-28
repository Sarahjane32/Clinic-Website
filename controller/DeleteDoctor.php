<?php

require_once "../../config/Database.php";

$doctor =
new DoctorController();

$user_id =
$_POST['user_id'];

if($doctor->deleteDoctor($user_id)){

 echo "success";

}else{

 echo "failed";

}
?>