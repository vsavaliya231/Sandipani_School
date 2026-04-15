<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = '';

// Add assignment
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
    $class   = $conn->real_escape_string(trim($_POST['class']));
    $subject = $conn->real_escape_string(trim($_POST['subject']));
    $title   = $conn->real_escape_string(trim($_POST['title']));
    $desc    = $conn->real_escape_string(trim($_POST['description']));
    $due     = $conn->real_escape_string(trim($_POST['due_date']));
    $conn->query("INSERT INTO assignments (class,subject,title,description,due_date) VALUES ('$class','$subject','$title','$desc','$due')");
    header("Location: assignments.php?added=1"); exit();
}

// Delete
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM assignments WHERE id=$id");
    header("Location: assignments.php?deleted=1"); exit();
}

if(isset($_GET['added']))  $msg = "✅ Assignment added!";
if(isset($_GET['deleted'])) $msg = "🗑 Assignment deleted.";

$assignments = $conn->query("SELECT * FROM assignments ORDER BY due_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assignments – Admin Panel</title>
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
        .form-row input, .form-row select, .form-row textarea{ flex:1; min-width:150px; padding:9px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; }
        .form-row textarea{ resize:vertical; height:60px; }
        .btn-add{ background:#0b3d91; color:white; border:none; padding:10px 25px; border-radius:6px; cursor:pointer; margin-top:12px; font-size:14px; }
        .card{ background:white; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; }
        table{ width:100%; border-collapse:collapse; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:11px 14px; text-align:left; font-size:13px; }
        tr:nth-child(even){ background:#f7f9ff; }
        .badge-overdue{ background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:10px; font-size:12px; }
        .badge-soon   { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:10px; font-size:12px; }
        .badge-ok     { background:#d4edda; color:#155724; padding:3px 10px; border-radius:10px; font-size:12px; }
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
        <a href="assignments.php" class="active">📝 Assignments</a>
        <a href="timetable.php">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>
    <div class="main">
        <div class="page-title">📝 Manage Assignments</div>
        <?php if($msg): ?><div class="alert"><?php echo $msg; ?></div><?php endif; ?>

        <div class="form-card">
            <h3>➕ Add Assignment</h3>
            <form method="POST">
                <div class="form-row">
                    <select name="class" required>
                        <?php foreach(['Class 1','Class 2','Class 3','Class 4','Class 5','Class 6',
                                       'Class 7','Class 8','Class 9','Class 10'] as $c): ?>
                        <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="subject" placeholder="Subject" required>
                    <input type="text" name="title" placeholder="Assignment Title" required>
                </div>
                <div class="form-row" style="margin-top:12px;">
                    <textarea name="description" placeholder="Description (optional)"></textarea>
                    <input type="date" name="due_date" required>
                </div>
                <button type="submit" name="add" class="btn-add">Add Assignment</button>
            </form>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr><th>#</th><th>Class</th><th>Subject</th><th>Title</th><th>Description</th><th>Due Date</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if($assignments && $assignments->num_rows > 0):
                    $i=1; while($row = $assignments->fetch_assoc()):
                        $due  = strtotime($row['due_date']);
                        $diff = ($due - time()) / 86400;
                        if($diff < 0)       { $st='Overdue'; $b='badge-overdue'; }
                        elseif($diff <= 2)  { $st='Due Soon'; $b='badge-soon'; }
                        else                { $st='Upcoming'; $b='badge-ok'; }
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars(substr($row['description']??'',0,50)); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['due_date'])); ?></td>
                        <td><span class="<?php echo $b; ?>"><?php echo $st; ?></span></td>
                        <td>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">
                                <button class="btn-del">Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="8" style="text-align:center;padding:30px;color:#888;">No assignments found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
