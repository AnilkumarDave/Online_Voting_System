<?php
session_start();
include '../database/db.php';

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// ==============================
// Fetch all candidates with constituency, district, and party info
// ==============================
$candidatesQuery = "
    SELECT c.id, c.name AS candidate_name, p.name AS party_name, co.name AS constituency_name, d.name AS district_name
    FROM candidates c
    LEFT JOIN parties p ON c.party_id = p.id
    LEFT JOIN constituencies co ON c.constituency_id = co.id
    LEFT JOIN districts d ON co.district_id = d.id
";
$candidatesResult = $conn->query($candidatesQuery);

// Prepare overall votes & party votes
$overallVotes = [];
$partyVotes = [];
$districtResults = [];

while ($row = $candidatesResult->fetch_assoc()) {
    $cid = $row['id'];
    $cname = $row['candidate_name'];
    $party = $row['party_name'];
    $constituency = $row['constituency_name'];
    $district = $row['district_name'];

    // Candidate votes
    $voteRes = $conn->query("SELECT COUNT(*) AS votes FROM votes WHERE candidate_id=$cid");
    $votes = $voteRes->fetch_assoc()['votes'];

    $overallVotes[$cname] = $votes;
    $partyVotes[$party] = ($partyVotes[$party] ?? 0) + $votes;

    // District -> Constituency -> Candidates
    if (!isset($districtResults[$district])) $districtResults[$district] = [];
    if (!isset($districtResults[$district][$constituency])) $districtResults[$district][$constituency] = [];
    $districtResults[$district][$constituency][] = [
        'candidate_name' => $cname,
        'party_name' => $party,
        'votes' => $votes
    ];
}

// Overall leading party
$overallWinnerParty = '';
if (!empty($partyVotes)) {
    $overallWinnerParty = array_keys($partyVotes, max($partyVotes))[0];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Online Voting</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px; }
        h2, h3 { text-align: center; }
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #007bff; color: white; }
        td.leader { background: #d4edda; font-weight: bold; color: #155724; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .tabs { text-align: center; margin-bottom: 20px; }
        .tabs button { padding: 10px 20px; margin: 0 5px; cursor: pointer; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .chart-container { width: 80%; margin: 30px auto; }
        select { padding: 5px 10px; margin: 5px; }
    </style>
    <script>
        function showTab(tabId) {
            var tabs = document.getElementsByClassName('tab-content');
            for (var i=0; i<tabs.length; i++) tabs[i].classList.remove('active');
            document.getElementById(tabId).classList.add('active');
        }
        window.onload = function() { showTab('candidatesTab'); }

        function filterResults() {
            const districtSelect = document.getElementById('districtSelect').value;
            const constituencySelect = document.getElementById('constituencySelect').value;

            const containers = document.getElementsByClassName('district-const-container');
            for (let i=0;i<containers.length;i++) {
                const district = containers[i].getAttribute('data-district');
                const constituency = containers[i].getAttribute('data-constituency');

                if(districtSelect==='all' && constituencySelect==='all'){
                    containers[i].style.display='block';
                } else if(constituencySelect!=='all'){
                    containers[i].style.display=(district+'__'+constituency===constituencySelect)?'block':'none';
                } else if(districtSelect!=='all'){
                    containers[i].style.display=(district===districtSelect)?'block':'none';
                }
            }
        }
    </script>
</head>
<body>

<h2>Admin Dashboard</h2>
<div class="tabs">
    <button onclick="showTab('candidatesTab')">Manage Candidates</button>
    <button onclick="showTab('resultsTab')">Election Results</button>
    <a href="../logout.php" style="margin-left:20px;">Logout</a>
</div>

<!-- ============================= -->
<!-- Manage Candidates Tab -->
<!-- ============================= -->
<div id="candidatesTab" class="tab-content">
    <p style="text-align:center;"><a href="add_candidate.php">Add New Candidate</a></p>
    <?php
        $candidatesAll = $conn->query($candidatesQuery);
        if($candidatesAll && $candidatesAll->num_rows>0):
    ?>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Party</th><th>Constituency</th><th>District</th><th>Actions</th>
            </tr>
            <?php while($row=$candidatesAll->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['candidate_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['party_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['constituency_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['district_name']); ?></td>
                    <td>
                        <a href="edit_candidate.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="delete_candidate.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No candidates found.</p>
    <?php endif; ?>
</div>

<!-- ============================= -->
<!-- Election Results Tab -->
<!-- ============================= -->
<div id="resultsTab" class="tab-content">
    <h3>🏆 Overall Leading Party: <?php echo htmlspecialchars($overallWinnerParty); ?></h3>

    <!-- Filters -->
    <div style="text-align:center; margin-bottom:20px;">
        <label>District:</label>
        <select id="districtSelect" onchange="filterResults()">
            <option value="all">All Districts</option>
            <?php foreach($districtResults as $district => $consts): ?>
                <option value="<?php echo htmlspecialchars($district); ?>"><?php echo htmlspecialchars($district); ?></option>
            <?php endforeach; ?>
        </select>

        <label>Constituency:</label>
        <select id="constituencySelect" onchange="filterResults()">
            <option value="all">All Constituencies</option>
            <?php foreach($districtResults as $district => $consts): ?>
                <?php foreach($consts as $constName => $cands): ?>
                    <option value="<?php echo htmlspecialchars($district.'__'.$constName); ?>"><?php echo htmlspecialchars($constName); ?></option>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Party Chart -->
    <div class="chart-container"><canvas id="partyChart"></canvas></div>

    <!-- District/Constituency Results -->
    <?php foreach($districtResults as $district => $consts): ?>
        <?php foreach($consts as $constName => $cands): ?>
            <div class="district-const-container" data-district="<?php echo htmlspecialchars($district); ?>" data-constituency="<?php echo htmlspecialchars($constName); ?>">
                <h3>🏛️ District: <?php echo htmlspecialchars($district); ?></h3>
                <h4>Constituency: <?php echo htmlspecialchars($constName); ?></h4>

                <?php if(count($cands)>0): ?>
                    <div class="chart-container"><canvas id="chart_<?php echo md5($district.$constName); ?>"></canvas></div>
                    <table>
                        <tr><th>Candidate</th><th>Party</th><th>Votes</th><th>Percentage</th></tr>
                        <?php 
                            $totalVotes=array_sum(array_column($cands,'votes'));
                            $maxVotes=max(array_column($cands,'votes'));
                            foreach($cands as $cand):
                        ?>
                            <tr class="<?php echo ($cand['votes']==$maxVotes)?'leader':'';?>">
                                <td><?php echo htmlspecialchars($cand['candidate_name']);?></td>
                                <td><?php echo htmlspecialchars($cand['party_name']);?></td>
                                <td><?php echo $cand['votes'];?></td>
                                <td><?php echo $totalVotes>0?round(($cand['votes']/$totalVotes)*100,2).'%' :'0%';?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <script>
                        const ctx_<?php echo md5($district.$constName); ?> = document.getElementById('chart_<?php echo md5($district.$constName); ?>').getContext('2d');
                        new Chart(ctx_<?php echo md5($district.$constName); ?>,{
                            type:'bar',
                            data:{
                                labels:<?php echo json_encode(array_column($cands,'candidate_name'));?>,
                                datasets:[{label:'Votes',data:<?php echo json_encode(array_column($cands,'votes'));?>,backgroundColor:'rgba(0,123,255,0.6)',borderColor:'rgba(0,123,255,1)',borderWidth:1}]
                            },
                            options:{responsive:true,plugins:{legend:{display:false},title:{display:true,text:'Votes per Candidate'}},scales:{y:{beginAtZero:true,stepSize:1}}}
                        });
                    </script>
                <?php else: ?>
                    <p>No candidates in this constituency.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <script>
        const ctxParty = document.getElementById('partyChart').getContext('2d');
        new Chart(ctxParty,{
            type:'bar',
            data:{
                labels: <?php echo json_encode(array_keys($partyVotes)); ?>,
                datasets:[{
                    label:'Votes by Party',
                    data: <?php echo json_encode(array_values($partyVotes)); ?>,
                    backgroundColor:'rgba(54,162,235,0.6)',
                    borderColor:'rgba(54,162,235,1)',
                    borderWidth:1
                }]
            },
            options:{responsive:true,plugins:{legend:{display:false},title:{display:true,text:'Votes by Party'}},scales:{y:{beginAtZero:true,stepSize:1}}}
        });
    </script>
</div>

</body>
</html>
