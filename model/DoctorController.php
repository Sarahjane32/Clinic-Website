<?php

require_once "../../config/Database.php";

class DoctorController {

    private $conn;

    public function __construct(){

        $db = new Database();

        $this->conn =
            $db->connect();
    }

    public function getDoctors(){

        $query = "

            SELECT

            users.user_id,
            users.last_name,
            users.specialization,
            users.license_number,
            users.contact_number,

            doctor_schedule.schedule_day,
            doctor_schedule.schedule_time

            FROM users

            INNER JOIN doctor_schedule
            ON users.user_id =
            doctor_schedule.doctor_id

            WHERE users.role_id = 2

            ORDER BY doctor_schedule.schedule_day

        ";

        $stmt =
            $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDoctor($data){

        $query = "

        UPDATE users

        SET

        specialization = :specialization,
        license_number = :license_number,
        contact_number = :contact_number

        WHERE user_id = :user_id

        ";

        $stmt =
        $this->conn->prepare($query);

        return $stmt->execute([

        ':specialization' =>
        $data['specialization'],

        ':license_number' =>
        $data['license_number'],

        ':contact_number' =>
        $data['contact_number'],

        ':user_id' =>
        $data['user_id']

        ]);

    }

    public function deleteDoctor($user_id){

        $query = "
        DELETE FROM users
        WHERE user_id = :user_id
        ";

        $stmt =
        $this->conn->prepare($query);

        return $stmt->execute([
        ':user_id' => $user_id
        ]);

    }
}
?>