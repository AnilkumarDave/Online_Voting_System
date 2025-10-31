<?php
header('Content-Type: application/json');
include '../database/db.php';

$constituency_id = isset($_GET['constituency_id']) ? intval($_GET['constituency_id']) : 0;
$candidates = [];

if($constituency_id > 0){
    $stmt = $conn->prepare("SELECT id, name FROM candidates WHERE constituency_id=?");
    $stmt->bind_param("i", $constituency_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()){
        $candidates[] = $row;
    }
}

echo json_encode($candidates);
