<?php

require_once "../../config/Database.php";

$db = new Database();
$conn = $db->connect();

$userType = $_POST['userType'];
$email = $_POST['email'];
$username = $_POST['username'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

if($newPassword != $confirmPassword){

    die("Passwords do not match.");
}

if($userType == "admin"){

    $query = "SELECT * FROM users
              WHERE email = :email
              AND username = :username";

}else{

    $query = "SELECT * FROM users
              WHERE email = :email
              AND license_number = :username";
}

$stmt = $conn->prepare($query);

$stmt->execute([

    ':email' => $email,
    ':username' => $username
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user){

    $hashedPassword = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );

    $updateQuery = "UPDATE users
                    SET password = :password
                    WHERE user_id = :user_id";

    $updateStmt = $conn->prepare($updateQuery);

    $updateStmt->execute([

        ':password' => $hashedPassword,
        ':user_id' => $user['user_id']
    ]);

    header("Location: ../login/login.php");

}else{

    echo "User not found.";
}
?>