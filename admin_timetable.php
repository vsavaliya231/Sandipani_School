<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = '';

// Add timetable slot
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
    $class   = $conn->real_escape_string(trim($_POST['class']));
    $day     = $conn->real_escape_string(trim($_POST['day']));
    $period  = (int)$_POST['period'];
    $subject = $conn->real_escape_string(trim($_POST['subject']));
    $teacher = $conn->real_escape_string(trim($_POST['teacher']));
    $start   = $conn->real_escape_string(trim($_POST['start_time']));
    $end     = $conn->real_escape_string(trim($_POST['end_time']));
    $conn->query("INSERT INTO timetable (class,day,period,subject,teacher,start_time,end_time) VALUES ('$class','$day',$period,'$subject','$teacher','$start','$end')");
    header("Location: timetable.php?added=1"); exit();
}

// Delete
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM timetable WHERE id=$id");
    header("Location: timetable.php?deleted=1"); exit();
}

if(isset($_GET['added']))  $msg = "✅ Timetable slot added!";
if(isset($_GET['deleted'])) $msg = "🗑 Slot deleted.";

// Filter by class
$filter_class = isset($_GET['class']) ? $conn->real_escape_string($_GET['class']) : 'Class 10';
$slots = $conn->query("SELECT * FROM timetable WHERE class='$filter_class' ORDER BY FIELD(day,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'), period ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Timetable – Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
        body{ background:#f2f2f2; }
        .topbar{ background:#0b3d91; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
        .top-links a{ color:white; text-decoration:none; margin-left:20px; font-size:14px; }
        .container{ display:flex; }
        .sidebar{ width:220px; background:#123e75; min-height:100vh; padding-top:20px; }
        .sidebar a{ display:block; color:white; text-decoration:none; padding:12px 20px; font-size:14px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#0b3d91; }
        .sidebar a.active{ border-left:4px solid #fff; }
        .main{ flex:1; padding:30px; }
        .page-title{ font-size:22px; color:#0b3d91; font-weight:bold; margin-bottom:20px; }
        .alert{ padding:12px 15px; border-radius:6px; margin-bottom:15px; background:#d4edda; color:#155724; }
        .form-card{ background:white; border-radius:10px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.07); margin-bottom:25px; }
        .form-card h3{ color:#0b3d91; margin-bottom:15px; }
        .form-row{ display:flex; gap:12px; flex-wrap:wrap; }
        .form-row input, .form-row select{ flex:1; min-width:120px; padding:9px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; }
        .btn-add{ background:#0b3d91; color:white; border:none; padding:10px 25px; border-radius:6px; cursor:pointer; margin-top:12px; font-size:14px; }
        .filter-bar{ display:flex; gap:10px; margin-bottom:15px; align-items:center; }
        .filter-bar select{ padding:8px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; }
        .filter-bar button{ background:#0b3d91; color:white; border:none; padding:9px 18px; border-radius:6px; cursor:pointer; }
        .card{ background:white; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; }
        table{ width:100%; border-collapse:collapse; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:11px 14px; text-align:left; font-size:13px; }
        tr:nth-child(even){ background:#f7f9ff; }
        .btn-del{ background:#d9534f; color:white; border:none; padding:5px 12px; border-radius:5px; cursor:pointer; font-size:12px; }
        @media(max-width:768px){ .sidebar{ display:none; } }
    </style>
</head>
<body>
<div class="topbar">
    <div><strong>Sandipani School – Admin</strong></div>
    <div class="top-links">
        <span>👤 <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
        <a href="../logout.php">Logout</a>
    </div>
</div>
<div class="container">
    <div class="sidebar">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="applications.php">📋 Applications</a>
        <a href="messages.php">📩 Messages</a>
        <a href="announcements.php">📢 Announcements</a>
        <a href="students.php">👥 Students</a>
        <a href="results.php">📊 Results</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php" class="active">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>
    <div class="main">
        <div class="page-title">📅 Manage Timetable</div>
        <?php if($msg): ?><div class="alert"><?php echo $msg; ?></div><?php endif; ?>

        <div class="form-card">
            <h3>➕ Add Timetable Slot</h3>
            <form method="POST">
                <div class="form-row">
                    <select name="class" required>
                        <?php foreach(['Class 1','Class 2','Class 3','Class 4','Class 5','Class 6',
                                       'Class 7','Class 8','Class 9','Class 10'] as $c): ?>
                        <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="day" required>
                        <?php foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d): ?>
                        <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="period" placeholder="Period #" min="1" max="10" required>
                    <input type="text" name="subject" placeholder="Subject" required>
                </div>
                <div class="form-row" style="margin-top:12px;">
                    <input type="text" name="teacher" placeholder="Teacher Name">
                    <input type="time" name="start_time">
                    <input type="time" name="end_time">
                </div>
                <button type="submit" name="add" class="btn-add">Add Slot</button>
            </form>
        </div>

        <form method="GET" class="filter-bar">
            <label>View Class:</label>
            <select name="class">
                <?php foreach(['Class 1','Class 2','Class 3','Class 4','Class 5','Class 6',
                               'Class 7','Class 8','Class 9','Class 10'] as $c): ?>
                <option value="<?php echo $c; ?>" <?php echo $filter_class==$c?'selected':''; ?>><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filter</button>
        </form>

        <div class="card">
            <table>
                <thead>
                    <tr><th>#</th><th>Class</th><th>Day</th><th>Period</th><th>Subject</th><th>Teacher</th><th>Start</th><th>End</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if($slots && $slots->num_rows > 0):
                    $i=1; while($row = $slots->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo $row['day']; ?></td>
                        <td>P<?php echo $row['period']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['subject']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['teacher'] ?? '-'); ?></td>
                        <td><?php echo $row['start_time'] ? date('h:i A', strtotime($row['start_time'])) : '-'; ?></td>
                        <td><?php echo $row['end_time']   ? date('h:i A', strtotime($row['end_time']))   : '-'; ?></td>
                        <td>
                            <a href="?delete=<?php echo $row['id']; ?>&class=<?php echo urlencode($filter_class); ?>" onclick="return confirm('Delete?')">
                                <button class="btn-del">Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="9" style="text-align:center;padding:30px;color:#888;">No timetable slots for <?php echo htmlspecialchars($filter_class); ?>.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
