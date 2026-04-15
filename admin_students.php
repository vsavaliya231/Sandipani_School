<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = '';

// Add new student
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
    $username  = $conn->real_escape_string(trim($_POST['username']));
    $password  = MD5(trim($_POST['password']));
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $email     = $conn->real_escape_string(trim($_POST['email']));
    $class     = $conn->real_escape_string(trim($_POST['class']));

    // Check username
    $exists = $conn->query("SELECT id FROM users WHERE username='$username'")->num_rows;
    if($exists){ $msg = "⚠ Username already exists."; }
    else {
        $conn->query("INSERT INTO users (username,password,full_name,email,role,class) VALUES ('$username','$password','$full_name','$email','student','$class')");
        header("Location: students.php?added=1"); exit();
    }
}

// Delete student
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id AND role='student'");
    header("Location: students.php?deleted=1"); exit();
}

if(isset($_GET['added']))  $msg = "✅ Student added successfully!";
if(isset($_GET['deleted'])) $msg = "🗑 Student deleted.";

$students = $conn->query("SELECT * FROM users WHERE role='student' ORDER BY created_at DESC");
$total    = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='student'")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Students – Admin Panel</title>
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
        .stats{ display:flex; gap:15px; margin-bottom:20px; }
        .stat{ flex:1; background:white; border-radius:8px; padding:18px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
        .stat h3{ font-size:28px; color:#0b3d91; }
        .stat p{ font-size:12px; color:#666; }
        .alert{ padding:12px 15px; border-radius:6px; margin-bottom:15px; background:#d4edda; color:#155724; }
        .alert-warn{ background:#fff3cd; color:#856404; }
        .form-card{ background:white; border-radius:10px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.07); margin-bottom:25px; }
        .form-card h3{ color:#0b3d91; margin-bottom:15px; }
        .form-row{ display:flex; gap:15px; flex-wrap:wrap; }
        .form-row input, .form-row select{ flex:1; min-width:160px; padding:9px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; }
        .btn-add{ background:#1a9e4a; color:white; border:none; padding:10px 25px; border-radius:6px; cursor:pointer; font-size:14px; margin-top:12px; }
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
        <a href="students.php" class="active">👥 Students</a>
        <a href="results.php">📊 Results</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>
    <div class="main">
        <div class="page-title">👥 Manage Students</div>
        <div class="stats">
            <div class="stat"><h3><?php echo $total; ?></h3><p>Total Students</p></div>
        </div>
        <?php if($msg): ?>
            <div class="alert <?php echo str_contains($msg,'⚠') ? 'alert-warn' : ''; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="form-card">
            <h3>➕ Add New Student</h3>
            <form method="POST">
                <div class="form-row">
                    <input type="text" name="full_name" placeholder="Full Name" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-row" style="margin-top:12px;">
                    <input type="email" name="email" placeholder="Email Address">
                    <select name="class">
                        <?php foreach(['Class 1','Class 2','Class 3','Class 4','Class 5','Class 6',
                                       'Class 7','Class 8','Class 9','Class 10'] as $c): ?>
                        <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="add" class="btn-add">Add Student</button>
            </form>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr><th>#</th><th>Full Name</th><th>Username</th><th>Email</th><th>Class</th><th>Joined</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if($students && $students->num_rows > 0):
                    $i=1; while($row = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['full_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($row['class'] ?? '-'); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this student?')">
                                <button class="btn-del">Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="7" style="text-align:center;padding:30px;color:#888;">No students found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
