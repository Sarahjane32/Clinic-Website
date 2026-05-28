<?php

class User {

    private $conn;

    public function __construct($db){

        $this->conn = $db;
    }

    /* =========================
       REGISTER
    ========================= */

    public function register($data){

    $query = "INSERT INTO users
    (
        role_id,
        first_name,
        last_name,
        email,
        contact_number,
        username,
        license_number,
        specialization,
        password,
        profile_picture
    )

    VALUES
    (
        :role_id,
        :first_name,
        :last_name,
        :email,
        :contact_number,
        :username,
        :license_number,
        :specialization,
        :password,
        :profile_picture
    )";

    $stmt = $this->conn->prepare($query);

    return $stmt->execute([

        ':role_id' => $data['role_id'],

        ':first_name' => $data['first_name'],
        ':last_name' => $data['last_name'],

        ':email' => $data['email'],

        ':contact_number' => $data['contact_number'],

        ':username' => $data['username'],

        ':license_number' => $data['license_number'],

        ':specialization' => $data['specialization'],

        ':password' => password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        ),

        ':profile_picture' => $data['profile_picture']
    ]);
}

    /* =========================
       LOGIN
    ========================= */

    public function login($userType, $loginInput){

        if($userType == "admin"){

            $query = "SELECT * FROM users
                      WHERE username = :loginInput";

        }else{

            $query = "SELECT * FROM users
                      WHERE license_number = :loginInput";
        }

        $stmt = $this->conn->prepare($query);

        $stmt->execute([

            ':loginInput' => $loginInput
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>