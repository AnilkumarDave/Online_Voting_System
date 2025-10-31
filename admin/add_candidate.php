<?php
session_start();
include '../database/db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch all constituencies for dropdown
$constituencies = $conn->query("SELECT * FROM constituencies ORDER BY name ASC");

// Fetch all parties for dropdown
$parties = $conn->query("SELECT * FROM parties ORDER BY name ASC");

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $constituency_id = intval($_POST['constituency_id']);
    $party_id = intval($_POST['party_id']);

    if ($name !== "" && $constituency_id > 0 && $party_id > 0) {
        $stmt = $conn->prepare("INSERT INTO candidates (NAME, constituency_id, party_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $name, $constituency_id, $party_id);

        if ($stmt->execute()) {
            $success = "✅ Candidate added successfully!";
        } else {
            $error = "❌ Error adding candidate: " . $stmt->error;
        }
    } else {
        $error = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Candidate</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        h2 { color: #333; text-align: center; }
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
    <h2>Add Candidate</h2>
    <p><a href="index.php">⬅️ Back to Dashboard</a></p>

    <?php if($error != ""): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if($success != ""): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Candidate Name:</label>
        <input type="text" name="name" required>

        <label>Select Constituency:</label>
        <select name="constituency_id" required>
            <option value="">-- Select Constituency --</option>
            <?php while($row = $constituencies->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>

        <label>Select Party:</label>
        <select name="party_id" required>
            <option value="">-- Select Party --</option>
            <?php while($p = $parties->fetch_assoc()): ?>
                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Add Candidate">
    </form>
</body>
</html>
