<?php

require_once "../../config/Database.php";

$db = new Database();
$conn = $db->connect();

$query = "SELECT * FROM patients";

$stmt = $conn->prepare($query);
$stmt->execute();

$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dom = new DOMDocument("1.0", "UTF-8");

$root = $dom->createElement("patients");

foreach($patients as $patient){

    $patientNode = $dom->createElement("patient");

    $patientNode->appendChild(
        $dom->createElement("id", $patient['patient_id'])
    );

    $patientNode->appendChild(
        $dom->createElement("name", $patient['full_name'])
    );

    $patientNode->appendChild(
        $dom->createElement("gender", $patient['gender'])
    );

    $root->appendChild($patientNode);
}

$dom->appendChild($root);

header("Content-Type: text/xml");

echo $dom->saveXML();

?>