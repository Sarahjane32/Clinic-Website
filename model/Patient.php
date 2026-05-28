<?php

class Patient {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function registerPatient($data){

        $query = "
        INSERT INTO patients
        (
            full_name,
            gender,
            birthdate,
            contact_number,
            address,
            emergency_contact,
            allergies,
            medical_history
        )
        VALUES
        (
            :full_name,
            :gender,
            :birthdate,
            :contact_number,
            :address,
            :emergency_contact,
            :allergies,
            :medical_history
        )
        ";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([

            ':full_name' => $data['full_name'],
            ':gender' => $data['gender'],
            ':birthdate' => $data['birthdate'],
            ':contact_number' => $data['contact_number'],
            ':address' => $data['address'],
            ':emergency_contact' => $data['emergency_contact'],
            ':allergies' => $data['allergies'],
            ':medical_history' => $data['medical_history']

        ]);
    }
}
?>