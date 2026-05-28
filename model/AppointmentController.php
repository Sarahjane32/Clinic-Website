<?php

require_once "../../config/Database.php";

class AppointmentController {

    private $conn;

    public function __construct(){

        $db = new Database();
        $this->conn = $db->connect();

    }

    /* GET DOCTORS */

    public function getDoctorsBySpecialization($specialization){

        $query = "

        SELECT
            users.user_id,
            users.first_name,
            users.last_name,
            users.specialization,
            doctor_schedule.schedule_day,
            doctor_schedule.schedule_time

        FROM users

        LEFT JOIN doctor_schedule
        ON users.user_id = doctor_schedule.doctor_id

        WHERE users.role_id = 2
        AND users.specialization = :specialization

        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            ':specialization' => $specialization
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /* SAVE APPOINTMENT */

    public function saveAppointment($data){

        $query = "

        INSERT INTO appointments
        (
            patient_id,
            doctor_id,
            appointment_date,
            appointment_time,
            purpose,
            status
        )

        VALUES
        (
            :patient_id,
            :doctor_id,
            :appointment_date,
            :appointment_time,
            :purpose,
            :status
        )

        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([

            ':patient_id' => $data['patient_id'],
            ':doctor_id' => $data['doctor_id'],
            ':appointment_date' => $data['appointment_date'],
            ':appointment_time' => $data['appointment_time'],
            ':purpose' => $data['purpose'],
            ':status' => 'Pending'

        ]);

    }

}

?>