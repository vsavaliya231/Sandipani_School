<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$full_name  = $_SESSION['full_name'] ?? $_SESSION['user'];
$user_class = $_SESSION['class'] ?? '';

// Fetch assignments for this student's class
$stmt = $conn->prepare("SELECT * FROM assignments WHERE class=? ORDER BY due_date ASC");
$stmt->bind_param("s", $user_class);
$stmt->execute();
$results = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assignments - Sandipani School</title>
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

        .card{ background:white; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.08); }

        table{ width:100%; border-collapse:collapse; margin-top:10px; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:12px 15px; text-align:left; font-size:14px; }
        tr:nth-child(even){ background:#f5f8ff; }

        .badge-overdue { background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:bold; }
        .badge-due     { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:bold; }
        .badge-ok      { background:#d4edda; color:#155724; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:bold; }

        .no-data{ text-align:center; color:#888; padding:40px; }

        @media(max-width:768px){ .sidebar{ display:none; } }
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
        <a href="assignments.php" class="active">📝 Assignments</a>
        <a href="timetable.php">📊 Time Table</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="result.php">📊 Results</a>
        <a href="faculty.php">👩‍🏫 Faculty</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>

    <div class="main">
        <div class="page-title">📝 My Assignments – <?php echo htmlspecialchars($user_class); ?></div>

        <div class="card">
            <?php if($results && $results->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; while($row = $results->fetch_assoc()):
                    $due     = strtotime($row['due_date']);
                    $today   = time();
                    $diff    = ($due - $today) / 86400;
                    if($diff < 0)       { $status = 'Overdue'; $badge = 'badge-overdue'; }
                    elseif($diff <= 2)  { $status = 'Due Soon'; $badge = 'badge-due'; }
                    else                { $status = 'Upcoming'; $badge = 'badge-ok'; }
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['description'] ?? '-'); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['due_date'])); ?></td>
                        <td><span class="<?php echo $badge; ?>"><?php echo $status; ?></span></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="no-data">📭 No assignments found for your class.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>