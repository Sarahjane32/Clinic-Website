<?php

require_once "../../config/Database.php";
require_once "../../model/User.php";

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$role = $_POST['registerType'];

$role_id = ($role == "admin") ? 1 : 2;

$profilePicture = null;

if(isset($_FILES['profile_picture']) &&
$_FILES['profile_picture']['error'] == 0){

 $targetDir = "uploads/";

 if(!is_dir($targetDir)){
  mkdir($targetDir, 0777, true);
 }

 $fileName =
 time() . "_" .
 basename($_FILES['profile_picture']['name']);

 $targetFile =
 $targetDir . $fileName;

 move_uploaded_file(
  $_FILES['profile_picture']['tmp_name'],
  $targetFile
 );

 $profilePicture = $targetFile;
}

$data = [

    'role_id' => $role_id,

    'first_name' => $_POST['firstname'],
    'last_name' => $_POST['lastname'],

    'email' => $_POST['email'],

    'contact_number' => $_POST['contact_number'],

    'username' => $_POST['username'] ?? null,

    'license_number' => $_POST['license_number'] ?? null,

    'specialization' => $_POST['specialization'] ?? null,

    'password' => $_POST['password'],

    'profile_picture' => $profilePicture
];

if($user->register($data)){

    header("Location: ../login/login.php");

}else{

    echo "Registration Failed";
}
?>