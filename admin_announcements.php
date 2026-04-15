<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = '';

// Add new announcement
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
    $title   = $conn->real_escape_string(trim($_POST['title']));
    $content = $conn->real_escape_string(trim($_POST['content']));
    $by      = htmlspecialchars($_SESSION['full_name']);
    if($title && $content){
        $conn->query("INSERT INTO announcements (title,content,posted_by) VALUES ('$title','$content','$by')");
        header("Location: announcements.php?added=1");
        exit();
    } else { $msg = "⚠ Please fill all fields."; }
}

// Delete
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM announcements WHERE id=$id");
    header("Location: announcements.php?deleted=1");
    exit();
}

if(isset($_GET['added']))  $msg = "✅ Announcement posted!";
if(isset($_GET['deleted'])) $msg = "🗑 Announcement deleted.";

$announcements = $conn->query("SELECT * FROM announcements ORDER BY posted_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Announcements – Admin Panel</title>
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
        .alert-warn{ background:#fff3cd; color:#856404; }
        .form-card{ background:white; border-radius:10px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.07); margin-bottom:25px; }
        .form-card h3{ color:#0b3d91; margin-bottom:15px; }
        .form-card input[type="text"],
        .form-card textarea{ width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; margin-bottom:12px; }
        .form-card textarea{ height:100px; resize:vertical; }
        .btn-post{ background:#0b3d91; color:white; border:none; padding:10px 25px; border-radius:6px; cursor:pointer; font-size:14px; }
        .ann-card{ background:white; border-left:5px solid #0b3d91; border-radius:8px; padding:18px 20px; margin-bottom:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); display:flex; justify-content:space-between; align-items:flex-start; gap:15px; }
        .ann-body h3{ color:#0b3d91; font-size:16px; margin-bottom:5px; }
        .ann-body p{ color:#555; font-size:14px; line-height:1.6; }
        .ann-meta{ font-size:12px; color:#999; margin-top:8px; }
        .btn-del{ background:#d9534f; color:white; border:none; padding:6px 14px; border-radius:5px; cursor:pointer; font-size:13px; white-space:nowrap; }
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
        <a href="announcements.php" class="active">📢 Announcements</a>
        <a href="students.php">👥 Students</a>
        <a href="results.php">📊 Results</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>
    <div class="main">
        <div class="page-title">📢 Manage Announcements</div>

        <?php if($msg): ?>
            <div class="alert <?php echo str_contains($msg,'⚠') ? 'alert-warn' : ''; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="form-card">
            <h3>➕ Post New Announcement</h3>
            <form method="POST">
                <input type="text" name="title" placeholder="Announcement Title" required>
                <textarea name="content" placeholder="Announcement details..." required></textarea>
                <button type="submit" name="add" class="btn-post">Post Announcement</button>
            </form>
        </div>

        <h3 style="margin-bottom:15px;color:#333;">📋 All Announcements</h3>

        <?php if($announcements && $announcements->num_rows > 0):
            while($row = $announcements->fetch_assoc()): ?>
            <div class="ann-card">
                <div class="ann-body">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    <div class="ann-meta">
                        📅 <?php echo date('d M Y, h:i A', strtotime($row['posted_at'])); ?>
                        &nbsp;|&nbsp; By: <?php echo htmlspecialchars($row['posted_by']); ?>
                    </div>
                </div>
                <div>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this announcement?')">
                        <button class="btn-del">Delete</button>
                    </a>
                </div>
            </div>
            <?php endwhile; else: ?>
            <div style="text-align:center;color:#888;padding:30px;">No announcements yet.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
