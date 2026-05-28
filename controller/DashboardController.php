<?php

require_once "../../config/Database.php";

class DashboardController{

    private $conn;

    public function __construct(){

        $db = new Database();

        $this->conn =
            $db->connect();
    }

    /* TOTAL PATIENTS */
    public function totalPatients(){

        $query =
        "SELECT COUNT(*) as total
        FROM patients";

        $stmt =
        $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* TODAY APPOINTMENTS */
    public function todayAppointments(){

        $query = "

        SELECT COUNT(*) as total

        FROM appointments

        WHERE appointment_date =
        CURDATE()

        ";

        $stmt =
        $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* TOTAL DOCTORS */
    public function totalDoctors(){

        $query = "

        SELECT COUNT(*) as total

        FROM users

        WHERE role_id = 2

        ";

        $stmt =
        $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* FOLLOW UPS */
    public function followUps(){

        $query = "

        SELECT COUNT(*) as total

        FROM appointments

        WHERE purpose = 'Follow Up'

        ";

        $stmt =
        $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* RECENT APPOINTMENTS */
    public function recentAppointments(){

        $query = "

        SELECT
            patients.full_name AS patient_name,
            users.last_name,
            appointments.appointment_date,
            appointments.status

        FROM appointments

        INNER JOIN users
        ON appointments.doctor_id = users.user_id

        INNER JOIN patients
        ON appointments.patient_id = patients.patient_id

        ORDER BY appointments.created_at DESC

        LIMIT 5

        ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}
?>