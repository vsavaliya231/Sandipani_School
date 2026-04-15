<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$full_name  = $_SESSION['full_name'] ?? $_SESSION['user'];
$student_id = $_SESSION['user_id'];

// Fetch results for this student
$results = $conn->query("SELECT * FROM results WHERE student_id=$student_id ORDER BY subject ASC");

$total_marks   = 0;
$obtained      = 0;
$rows_arr      = [];

if($results && $results->num_rows > 0){
    while($r = $results->fetch_assoc()){
        $rows_arr[]    = $r;
        $total_marks  += $r['total_marks'];
        $obtained     += $r['marks'];
    }
}

$percentage = $total_marks > 0 ? round(($obtained / $total_marks) * 100, 2) : 0;
$grade = '';
$pass  = ($percentage >= 35);

if($percentage >= 90)      $grade = 'A+';
elseif($percentage >= 75)  $grade = 'A';
elseif($percentage >= 60)  $grade = 'B';
elseif($percentage >= 45)  $grade = 'C';
elseif($percentage >= 35)  $grade = 'D';
else                        $grade = 'F';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Results - Sandipani School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
        body{ background:#f2f4f8; }

        .topbar{ background:#0b3d91; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
        .top-links a{ color:white; text-decoration:none; margin-left:20px; font-size:14px; }

        .container{ display:flex; }

        .sidebar{ width:220px; background:#123e75; min-height:100vh; padding-top:20px; }
        .sidebar a{ display:block; color:white; text-decoration:none; padding:12px 20px; font-size:14px; transition:0.3s; }
        .sidebar a:hover{ background:#0b3d91; }
        .sidebar a.active{ background:#0b3d91; border-left:4px solid #fff; }

        .main{ flex:1; padding:30px; }

        .page-title{ font-size:22px; color:#0b3d91; font-weight:bold; margin-bottom:20px; }

        .card{ background:white; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.08); margin-bottom:25px; }

        table{ width:100%; border-collapse:collapse; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:12px 15px; text-align:left; font-size:14px; }
        tr:nth-child(even){ background:#f5f8ff; }
        td:last-child{ font-weight:bold; }

        .pass{ color:#1a9e4a; }
        .fail{ color:#d9534f; }

        .summary{
            display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;
        }
        .sum-box{
            flex:1; min-width:120px; background:#f0f4ff;
            border-radius:8px; padding:18px; text-align:center;
            border-top:4px solid #0b3d91;
        }
        .sum-box h3{ font-size:26px; color:#0b3d91; }
        .sum-box p{ font-size:13px; color:#666; margin-top:4px; }
        .result-badge{
            display:inline-block; padding:6px 20px; border-radius:20px;
            font-weight:bold; font-size:15px; margin-top:5px;
        }
        .badge-pass{ background:#d4edda; color:#155724; }
        .badge-fail{ background:#f8d7da; color:#721c24; }

        .no-data{ text-align:center; color:#888; padding:40px; font-size:15px; }

        @media(max-width:768px){ .sidebar{ display:none; } .summary{ flex-direction:column; } }
    </style>
</head>
<body>

<div class="topbar">
    <div><strong>Sandipani School</strong></div>
    <div class="top-links">
        <span>👤 <?php echo htmlspecialchars($full_name); ?></span>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="sidebar">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="gallery-more.php">📸 Gallery</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📊 Time Table</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="result.php" class="active">📊 Results</a>
        <a href="faculty.php">👩‍🏫 Faculty</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>

    <div class="main">

        <div class="page-title">📊 My Exam Results</div>

        <?php if(!empty($rows_arr)): ?>

        <div class="card">
            <h3 style="margin-bottom:15px;color:#0b3d91;">
                📋 <?php echo htmlspecialchars($rows_arr[0]['exam_type']); ?> – <?php echo $rows_arr[0]['exam_year']; ?>
            </h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Marks Obtained</th>
                        <th>Total Marks</th>
                        <th>Percentage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($rows_arr as $i => $r):
                    $pct = round(($r['marks'] / $r['total_marks']) * 100, 1);
                    $subPass = $r['marks'] >= ($r['total_marks'] * 0.35);
                ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo htmlspecialchars($r['subject']); ?></td>
                        <td><?php echo $r['marks']; ?></td>
                        <td><?php echo $r['total_marks']; ?></td>
                        <td><?php echo $pct; ?>%</td>
                        <td class="<?php echo $subPass ? 'pass' : 'fail'; ?>">
                            <?php echo $subPass ? '✔ Pass' : '✘ Fail'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3 style="margin-bottom:15px;color:#333;">📈 Summary</h3>
            <div class="summary">
                <div class="sum-box">
                    <h3><?php echo $obtained; ?></h3>
                    <p>Total Obtained</p>
                </div>
                <div class="sum-box">
                    <h3><?php echo $total_marks; ?></h3>
                    <p>Total Marks</p>
                </div>
                <div class="sum-box">
                    <h3><?php echo $percentage; ?>%</h3>
                    <p>Percentage</p>
                </div>
                <div class="sum-box">
                    <h3><?php echo $grade; ?></h3>
                    <p>Grade</p>
                </div>
                <div class="sum-box">
                    <span class="result-badge <?php echo $pass ? 'badge-pass' : 'badge-fail'; ?>">
                        <?php echo $pass ? '🎉 PASS' : '❌ FAIL'; ?>
                    </span>
                    <p style="margin-top:6px;">Final Result</p>
                </div>
            </div>
        </div>

        <?php else: ?>
            <div class="card no-data">📭 No results found. Please contact your class teacher.</div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>