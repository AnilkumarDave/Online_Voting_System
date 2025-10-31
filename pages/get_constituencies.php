<?php
header('Content-Type: application/json');
include '../database/db.php';

$district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;
$constituencies = [];

if($district_id > 0){
    $stmt = $conn->prepare("SELECT id, name FROM constituencies WHERE district_id=? ORDER BY name ASC");
    $stmt->bind_param("i", $district_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()){
        $constituencies[] = $row;
    }
}

echo json_encode($constituencies);
