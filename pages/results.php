<?php
session_start();
include 'db.php';

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// ============================
// Overall votes per candidate and party
// ============================
$overallVotes = [];
$partyVotes = [];

// Get all candidates and their votes
$candRes = $conn->query("
    SELECT c.id AS cid, c.name AS candidate_name, p.name AS party_name, COUNT(v.id) AS votes
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    LEFT JOIN parties p ON c.party_id = p.id
    GROUP BY c.id
");

while($row = $candRes->fetch_assoc()){
    $overallVotes[$row['candidate_name']] = $row['votes'];
    $partyVotes[$row['party_name']] = ($partyVotes[$row['party_name']] ?? 0) + $row['votes'];
}

// ============================
// Overall leading party
// ============================
$overallLeadingParty = '';
$maxPartyVotes = 0;
foreach($partyVotes as $party => $votes){
    if($votes > $maxPartyVotes){
        $maxPartyVotes = $votes;
        $overallLeadingParty = $party;
    }
}

// ============================
// Fetch districts and constituencies
// ============================
$districts = $conn->query("SELECT * FROM districts ORDER BY name ASC");

$districtResults = [];
while($district = $districts->fetch_assoc()){
    $district_id = $district['id'];
    $district_name = $district['name'];

    $constRes = $conn->query("SELECT * FROM constituencies WHERE district_id = $district_id ORDER BY name ASC");
    while($const = $constRes->fetch_assoc()){
        $const_id = $const['id'];
        $const_name = $const['name'];

        $candRes = $conn->query("
            SELECT c.name AS candidate_name, p.name AS party_name, COUNT(v.id) AS votes
            FROM candidates c
            LEFT JOIN votes v ON c.id = v.candidate_id
            LEFT JOIN parties p ON c.party_id = p.id
            WHERE c.constituency_id = $const_id
            GROUP BY c.id
        ");

        $districtResults[$district_name][$const_name] = [];
        while($cand = $candRes->fetch_assoc()){
            $districtResults[$district_name][$const_name][] = $cand;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Election Results</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f8f9fa; }
        h2, h3, h4 { margin: 10px 0; }
        table { margin: 10px auto; border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #007bff; color: white; }
        td.leader { background: #d4edda; font-weight: bold; color: #155724; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .chart-container { width: 80%; margin: 20px auto; }
        hr { margin: 30px 0; }
        select { padding: 6px; margin: 10px 0; }
    </style>
</head>
<body>
<h2>Election Results</h2>
<p><a href="vote.php">⬅️ Back to Voting</a> | <a href="logout.php">Logout</a></p>

<!-- Overall Leading Party -->
<h3>🏆 Overall Leading Party: <?php echo htmlspecialchars($overallLeadingParty); ?> (<?php echo $maxPartyVotes; ?> votes)</h3>

<!-- Party-wise Votes -->
<h3>📊 Party-wise Votes</h3>
<table>
    <tr><th>Party</th><th>Votes</th></tr>
    <?php foreach($partyVotes as $party => $votes): ?>
        <tr <?php echo ($party == $overallLeadingParty) ? 'class="leader"' : ''; ?>>
            <td><?php echo htmlspecialchars($party); ?></td>
            <td><?php echo $votes; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<hr>

<!-- Filter by District -->
<h3>📍 Filter by District & Constituency</h3>
<form method="GET" action="">
    <label>District:</label>
    <select name="district" onchange="this.form.submit()">
        <option value="">Select District</option>
        <?php foreach($districtResults as $district => $consts): ?>
            <option value="<?php echo htmlspecialchars($district); ?>" <?php if(isset($_GET['district']) && $_GET['district'] == $district) echo 'selected'; ?>>
                <?php echo htmlspecialchars($district); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if(isset($_GET['district']) && $_GET['district'] != ''): ?>
        <label>Constituency:</label>
        <select name="constituency" onchange="this.form.submit()">
            <option value="">Select Constituency</option>
            <?php foreach($districtResults[$_GET['district']] as $constName => $cands): ?>
                <option value="<?php echo htmlspecialchars($constName); ?>" <?php if(isset($_GET['constituency']) && $_GET['constituency'] == $constName) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($constName); ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
</form>

<!-- Show Results -->
<?php if(isset($_GET['district']) && $_GET['district'] != ''): ?>
    <?php $district = $_GET['district']; ?>
    <h3>District: <?php echo htmlspecialchars($district); ?></h3>

    <?php if(isset($_GET['constituency']) && $_GET['constituency'] != ''): ?>
        <?php $constName = $_GET['constituency']; ?>
        <h4>Constituency: <?php echo htmlspecialchars($constName); ?></h4>
        <?php $candidates = $districtResults[$district][$constName]; ?>

        <?php if(count($candidates) > 0): ?>
            <table>
                <tr><th>Candidate</th><th>Party</th><th>Votes</th><th>Percentage</th></tr>
                <?php 
                    $totalVotes = array_sum(array_column($candidates, 'votes'));
                    $maxVotes = max(array_column($candidates, 'votes'));
                    foreach($candidates as $cand): 
                ?>
                    <tr class="<?php echo ($cand['votes'] == $maxVotes) ? 'leader' : ''; ?>">
                        <td><?php echo htmlspecialchars($cand['candidate_name']); ?></td>
                        <td><?php echo htmlspecialchars($cand['party_name']); ?></td>
                        <td><?php echo $cand['votes']; ?></td>
                        <td><?php echo $totalVotes > 0 ? round(($cand['votes']/$totalVotes)*100,2).'%' : '0%'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No candidates in this constituency.</p>
        <?php endif; ?>
    <?php else: ?>
        <!-- Show all constituencies in district -->
        <?php foreach($districtResults[$district] as $constName => $candidates): ?>
            <h4>Constituency: <?php echo htmlspecialchars($constName); ?></h4>
            <?php if(count($candidates) > 0): ?>
                <table>
                    <tr><th>Candidate</th><th>Party</th><th>Votes</th><th>Percentage</th></tr>
                    <?php 
                        $totalVotes = array_sum(array_column($candidates, 'votes'));
                        $maxVotes = max(array_column($candidates, 'votes'));
                        foreach($candidates as $cand): 
                    ?>
                        <tr class="<?php echo ($cand['votes'] == $maxVotes) ? 'leader' : ''; ?>">
                            <td><?php echo htmlspecialchars($cand['candidate_name']); ?></td>
                            <td><?php echo htmlspecialchars($cand['party_name']); ?></td>
                            <td><?php echo $cand['votes']; ?></td>
                            <td><?php echo $totalVotes > 0 ? round(($cand['votes']/$totalVotes)*100,2).'%' : '0%'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No candidates in this constituency.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
