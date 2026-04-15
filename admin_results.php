<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = '';

// Add result
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
    $sid     = (int)$_POST['student_id'];
    $subject = $conn->real_escape_string(trim($_POST['subject']));
    $marks   = (int)$_POST['marks'];
    $total   = (int)$_POST['total_marks'];
    $etype   = $conn->real_escape_string(trim($_POST['exam_type']));
    $year    = (int)$_POST['exam_year'];

    $conn->query("INSERT INTO results (student_id,subject,marks,total_marks,exam_type,exam_year) VALUES ($sid,'$subject',$marks,$total,'$etype',$year)");
    header("Location: results.php?added=1"); exit();
}

// Delete result
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM results WHERE id=$id");
    header("Location: results.php?deleted=1"); exit();
}

if(isset($_GET['added']))  $msg = "✅ Result added!";
if(isset($_GET['deleted'])) $msg = "🗑 Result deleted.";

$students = $conn->query("SELECT id, full_name, class FROM users WHERE role='student' ORDER BY full_name");
$results  = $conn->query("
    SELECT r.*, u.full_name, u.class FROM results r
    JOIN users u ON r.student_id=u.id
    ORDER BY u.full_name, r.subject
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Results – Admin Panel</title>
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
        .form-row input, .form-row select{ flex:1; min-width:140px; padding:9px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; }
        .btn-add{ background:#0b3d91; color:white; border:none; padding:10px 25px; border-radius:6px; cursor:pointer; margin-top:12px; font-size:14px; }
        .card{ background:white; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; }
        table{ width:100%; border-collapse:collapse; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:11px 14px; text-align:left; font-size:13px; }
        tr:nth-child(even){ background:#f7f9ff; }
        .btn-del{ background:#d9534f; color:white; border:none; padding:5px 12px; border-radius:5px; cursor:pointer; font-size:12px; }
        .pass{ color:#1a9e4a; font-weight:bold; }
        .fail{ color:#d9534f; font-weight:bold; }
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
        <a href="results.php" class="active">📊 Results</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>
    <div class="main">
        <div class="page-title">📊 Manage Results</div>
        <?php if($msg): ?><div class="alert"><?php echo $msg; ?></div><?php endif; ?>

        <div class="form-card">
            <h3>➕ Add Result</h3>
            <form method="POST">
                <div class="form-row">
                    <select name="student_id" required>
                        <option value="">Select Student</option>
                        <?php while($s = $students->fetch_assoc()): ?>
                        <option value="<?php echo $s['id']; ?>">
                            <?php echo htmlspecialchars($s['full_name']); ?> (<?php echo $s['class']; ?>)
                        </option>
                        <?php endwhile; ?>
                    </select>
                    <input type="text" name="subject" placeholder="Subject" required>
                    <input type="number" name="marks" placeholder="Marks" required min="0">
                    <input type="number" name="total_marks" placeholder="Total Marks" value="100" required min="1">
                </div>
                <div class="form-row" style="margin-top:12px;">
                    <input type="text" name="exam_type" placeholder="Exam Type (e.g. Mid-Term)" value="Mid-Term">
                    <input type="number" name="exam_year" placeholder="Year" value="<?php echo date('Y'); ?>">
                </div>
                <button type="submit" name="add" class="btn-add">Add Result</button>
            </form>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr><th>#</th><th>Student</th><th>Class</th><th>Subject</th><th>Marks</th><th>Total</th><th>%</th><th>Exam</th><th>Year</th><th>Status</th><th>Del</th></tr>
                </thead>
                <tbody>
                <?php if($results && $results->num_rows > 0):
                    $i=1; while($row = $results->fetch_assoc()):
                        $pct   = round(($row['marks']/$row['total_marks'])*100, 1);
                        $pass  = $pct >= 35;
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['full_name']); ?></strong></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td><?php echo $row['marks']; ?></td>
                        <td><?php echo $row['total_marks']; ?></td>
                        <td><?php echo $pct; ?>%</td>
                        <td><?php echo htmlspecialchars($row['exam_type']); ?></td>
                        <td><?php echo $row['exam_year']; ?></td>
                        <td class="<?php echo $pass ? 'pass' : 'fail'; ?>"><?php echo $pass ? '✔ Pass' : '✘ Fail'; ?></td>
                        <td>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">
                                <button class="btn-del">Del</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="11" style="text-align:center;padding:30px;color:#888;">No results found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
