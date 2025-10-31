<?php
session_start();
include '../database/db.php';

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$id = intval($_GET['id']);
$error = "";
$success = "";

// Fetch existing candidate
$stmt = $conn->prepare("SELECT * FROM candidates WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$candidate = $result->fetch_assoc();

if (!$candidate) {
    die("Candidate not found");
}

// Fetch constituencies for dropdown
$constituencies = $conn->query("SELECT * FROM constituencies ORDER BY name ASC");

// Fetch parties for dropdown
$parties = $conn->query("SELECT * FROM parties ORDER BY name ASC");

// Update candidate
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $constituency_id = intval($_POST['constituency_id']);
    $party_id = intval($_POST['party_id']);

    if ($name !== "" && $constituency_id > 0 && $party_id > 0) {
        $stmt = $conn->prepare("UPDATE candidates SET NAME=?, constituency_id=?, party_id=? WHERE id=?");
        $stmt->bind_param("siii", $name, $constituency_id, $party_id, $id);
        if ($stmt->execute()) {
            $success = "✅ Candidate updated successfully!";
            // Refresh candidate info
            $stmt2 = $conn->prepare("SELECT * FROM candidates WHERE id=?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $candidate = $stmt2->get_result()->fetch_assoc();
        } else {
            $error = "❌ Error updating candidate: " . $stmt->error;
        }
    } else {
        $error = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Candidate</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        h2 { text-align: center; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        label { font-weight: bold; display: block; margin-top: 10px; }
        input[type="text"], select { width: 100%; padding: 8px; margin: 6px 0 12px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; width: 100%; }
        input[type="submit"]:hover { background: #0056b3; }
        p { text-align: center; }
        .success { color: green; }
        .error { color: red; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <h2>Edit Candidate</h2>
    <p><a href="index.php">← Back to Dashboard</a></p>

    <?php if($error != ""): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if($success != ""): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Candidate Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($candidate['name']); ?>" required>

        <label>Select Constituency:</label>
        <select name="constituency_id" required>
            <option value="">-- Select Constituency --</option>
            <?php while ($row = $constituencies->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $candidate['constituency_id']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Select Party:</label>
        <select name="party_id" required>
            <option value="">-- Select Party --</option>
            <?php while ($p = $parties->fetch_assoc()): ?>
                <option value="<?php echo $p['id']; ?>" <?php if ($p['id'] == $candidate['party_id']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($p['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Update Candidate">
    </form>
</body>
</html>
