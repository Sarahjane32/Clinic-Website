<?php

session_start();

require_once "../config/Database.php";
require_once "../model/User.php";

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$userType = $_POST['userType'];
$loginInput = $_POST['loginInput'];
$password = $_POST['password'];

$userData = $user->login($userType, $loginInput);

if($userData){

    if(password_verify($password, $userData['password'])){

        $_SESSION['user_id'] = $userData['user_id'];

        $_SESSION['lastname'] =
            $userData['last_name'];

        $_SESSION['role'] =
            ($userData['role_id'] == 1)
            ? "Admin"
            : "Doctor";

        $_SESSION['profile_picture'] = $userData['profile_picture'];

        if($userData['role_id'] == 1){

            header("Location: ../admin/admin_dashboard.php");
            exit();

        }else{

            header("Location: ../doctor/doctor_dashboard.php");
            exit();
        }

    }else{

        echo "Incorrect Password";
    }

}else{

    echo "User Not Found";
}
?>