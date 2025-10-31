<?php
session_start();
include '../database/db.php';

// Check if user is logged in and not admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Check if user has already voted
$stmt = $conn->prepare("SELECT * FROM votes WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$has_voted = ($result->num_rows > 0);

// If vote submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$has_voted) {
    $candidate_id = intval($_POST['candidate_id']);
    $stmt = $conn->prepare("INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $candidate_id);
    if ($stmt->execute()) {
        $message = "✅ Your vote has been recorded!";
        $has_voted = true;
    } else {
        $message = "❌ Error recording vote.";
    }
}

// Fetch all districts
$districts = $conn->query("SELECT * FROM districts ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cast Your Vote</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; text-align: center; padding: 20px; }
        h2 { color: #333; }
        .candidate-container { display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin-bottom: 20px; }
        .candidate-card { display: flex; align-items: center; background: #fff; border: 1px solid #ccc; padding: 10px 15px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer; transition: 0.2s; }
        .candidate-card:hover { background: #e9f5ff; border-color: #007bff; }
        .candidate-name { margin-left: 8px; font-weight: bold; }
        input[type=submit] { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        input[type=submit]:hover { background: #0056b3; }
        .message { color: green; font-weight: bold; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        select { padding: 8px 12px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
    </style>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! Cast Your Vote</h2>
<p><a href="results.php">View Results</a> | <a href="logout.php">Logout</a></p>

<?php if ($message != ""): ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<?php if ($has_voted): ?>
    <p>✅ You have already voted. Thank you!</p>
<?php else: ?>
    <form method="POST" action="">
        <label>Select District:</label>
        <select id="districtSelect" required>
            <option value="">-- Select District --</option>
            <?php while($district = $districts->fetch_assoc()): ?>
                <option value="<?php echo $district['id']; ?>"><?php echo htmlspecialchars($district['name']); ?></option>
            <?php endwhile; ?>
        </select>

        <label>Select Constituency:</label>
        <select id="constituencySelect" name="constituency_id" required>
            <option value="">-- Select Constituency --</option>
        </select>

        <div id="candidatesContainer"></div>

        <input type="submit" value="Submit Vote">
    </form>
<?php endif; ?>

<script>
const districtSelect = document.getElementById('districtSelect');
const constituencySelect = document.getElementById('constituencySelect');
const candidatesContainer = document.getElementById('candidatesContainer');

// Load constituencies when district changes
districtSelect.addEventListener('change', function() {
    let districtId = this.value;
    constituencySelect.innerHTML = '<option value="">Loading...</option>';
    candidatesContainer.innerHTML = '';

    if(districtId) {
        fetch('get_constituencies.php?district_id=' + districtId)
        .then(res => res.json())
        .then(data => {
            let options = '<option value="">-- Select Constituency --</option>';
            data.forEach(c => options += `<option value="${c.id}">${c.name}</option>`);
            constituencySelect.innerHTML = options;
        })
        .catch(err => {
            constituencySelect.innerHTML = '<option value="">Error loading constituencies</option>';
            console.error(err);
        });
    } else {
        constituencySelect.innerHTML = '<option value="">-- Select Constituency --</option>';
    }
});

// Load candidates when constituency changes
constituencySelect.addEventListener('change', function() {
    let constituencyId = this.value;
    candidatesContainer.innerHTML = '';

    if(constituencyId) {
        fetch('get_candidates.php?constituency_id=' + constituencyId)
        .then(res => res.json())
        .then(data => {
            if(data.length > 0) {
                let html = '<div class="candidate-container">';
                data.forEach(c => {
                    html += `<label class="candidate-card">
                                <input type="radio" name="candidate_id" value="${c.id}" required>
                                <span class="candidate-name">${c.name}</span>
                             </label>`;
                });
                html += '</div>';
                candidatesContainer.innerHTML = html;
            } else {
                candidatesContainer.innerHTML = '<p>No candidates in this constituency.</p>';
            }
        })
        .catch(err => {
            candidatesContainer.innerHTML = '<p>Error loading candidates.</p>';
            console.error(err);
        });
    }
});
</script>

</body>
</html>
