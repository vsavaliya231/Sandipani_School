<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$full_name  = $_SESSION['full_name'] ?? $_SESSION['user'];
$user_class = $_SESSION['class'] ?? 'Class 10';

// Get selected class (default to student's own class)
$selected_class = isset($_GET['class']) ? $_GET['class'] : $user_class;

// Fetch timetable grouped by day
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
$timetable = [];

$stmt = $conn->prepare("SELECT * FROM timetable WHERE class=? ORDER BY day, period ASC");
$stmt->bind_param("s", $selected_class);
$stmt->execute();
$res = $stmt->get_result();

while($row = $res->fetch_assoc()){
    $timetable[$row['day']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Timetable - Sandipani School</title>
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
        .page-title{ font-size:22px; color:#0b3d91; font-weight:bold; margin-bottom:15px; }

        .filter-bar{ margin-bottom:20px; display:flex; align-items:center; gap:15px; }
        .filter-bar select{ padding:8px 14px; border:1px solid #ccc; border-radius:6px; font-size:14px; }
        .filter-bar button{ background:#0b3d91; color:white; border:none; padding:9px 20px; border-radius:6px; cursor:pointer; }

        .day-block{ background:white; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.07); margin-bottom:20px; overflow:hidden; }
        .day-header{ background:#0b3d91; color:white; padding:12px 20px; font-weight:bold; font-size:15px; }

        table{ width:100%; border-collapse:collapse; }
        th{ background:#e8f0ff; color:#0b3d91; padding:10px 15px; text-align:left; font-size:13px; }
        td{ padding:10px 15px; font-size:14px; border-bottom:1px solid #f0f0f0; }
        tr:last-child td{ border-bottom:none; }

        .no-data{ text-align:center; color:#888; padding:30px; background:white; border-radius:10px; }

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
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php" class="active">📊 Time Table</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="result.php">📊 Results</a>
        <a href="faculty.php">👩‍🏫 Faculty</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>

    <div class="main">
        <div class="page-title">📊 Weekly Timetable</div>

        <form method="GET" class="filter-bar">
            <label>Select Class:</label>
            <select name="class">
                <?php foreach(['Class 1','Class 2','Class 3','Class 4','Class 5','Class 6',
                                'Class 7','Class 8','Class 9','Class 10'] as $cls): ?>
                <option value="<?php echo $cls; ?>" <?php echo $selected_class==$cls ? 'selected' : ''; ?>>
                    <?php echo $cls; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">View</button>
        </form>

        <?php if(!empty($timetable)): ?>
            <?php foreach($days as $day): ?>
                <?php if(!isset($timetable[$day])) continue; ?>
                <div class="day-block">
                    <div class="day-header">📅 <?php echo $day; ?></div>
                    <table>
                        <tr>
                            <th>Period</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Time</th>
                        </tr>
                        <?php foreach($timetable[$day] as $slot): ?>
                        <tr>
                            <td>Period <?php echo $slot['period']; ?></td>
                            <td><strong><?php echo htmlspecialchars($slot['subject']); ?></strong></td>
                            <td><?php echo htmlspecialchars($slot['teacher'] ?? '-'); ?></td>
                            <td>
                                <?php echo $slot['start_time'] ? date('h:i A', strtotime($slot['start_time'])) : '-'; ?>
                                <?php echo $slot['end_time'] ? ' – '.date('h:i A', strtotime($slot['end_time'])) : ''; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-data">📭 No timetable found for <strong><?php echo htmlspecialchars($selected_class); ?></strong>. Please check back later.</div>
        <?php endif; ?>
    </div>

</div>
</body>
</html>