<?php
include 'db.php';
$constituency_id = intval($_GET['constituency_id']);

$result = ['constituency'=>'','candidates'=>[]];

// Fetch constituency name
$constRes = $conn->query("SELECT name FROM constituencies WHERE id=$constituency_id");
if($constRes->num_rows>0){
    $constRow = $constRes->fetch_assoc();
    $result['constituency'] = $constRow['name'];
}

// Fetch candidates and votes
$candRes = $conn->query("
    SELECT c.name, p.name AS party, COUNT(v.id) AS votes
    FROM candidates c
    LEFT JOIN parties p ON c.party_id = p.id
    LEFT JOIN votes v ON c.id = v.candidate_id
    WHERE c.constituency_id = $constituency_id
    GROUP BY c.id
");

while($row = $candRes->fetch_assoc()){
    $result['candidates'][] = $row;
}

header('Content-Type: application/json');
echo json_encode($result);
