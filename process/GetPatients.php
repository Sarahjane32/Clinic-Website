<?php

require_once "../../config/Database.php";

$db = new Database();
$conn = $db->connect();

$query = "

SELECT
    patient_id,
    full_name

FROM patients

ORDER BY full_name ASC

";

$stmt = $conn->prepare($query);

$stmt->execute();

$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($patients);

?>