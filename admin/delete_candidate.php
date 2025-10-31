<?php
session_start();
include '../database/db.php';

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$id = intval($_GET['id']);

// Check if candidate exists
$stmt = $conn->prepare("SELECT * FROM candidates WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Candidate not found
    header("Location: index.php?msg=candidate_not_found");
    exit();
}

// Delete candidate
$stmt = $conn->prepare("DELETE FROM candidates WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?msg=deleted_success");
    exit();
} else {
    header("Location: index.php?msg=delete_failed");
    exit();
}
?>
