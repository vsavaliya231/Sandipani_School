<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = '';

// Mark as read
if(isset($_GET['read'])){
    $id = (int)$_GET['read'];
    $conn->query("UPDATE contacts SET is_read=1 WHERE id=$id");
    header("Location: messages.php");
    exit();
}

// Delete message
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM contacts WHERE id=$id");
    header("Location: messages.php?deleted=1");
    exit();
}

if(isset($_GET['deleted'])) $msg = "🗑 Message deleted.";

$contacts = $conn->query("SELECT * FROM contacts ORDER BY sent_at DESC");
$unread   = $conn->query("SELECT COUNT(*) as c FROM contacts WHERE is_read=0")->fetch_assoc()['c'];
$total    = $conn->query("SELECT COUNT(*) as c FROM contacts")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages – Admin Panel</title>
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
        .stat p{ font-size:12px; color:#666; margin-top:4px; }
        .alert-info{ background:#d1ecf1; color:#0c5460; padding:12px 15px; border-radius:6px; margin-bottom:15px; }
        .card{ background:white; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; }
        table{ width:100%; border-collapse:collapse; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:11px 14px; text-align:left; font-size:13px; }
        tr:nth-child(even){ background:#f7f9ff; }
        tr.unread td{ font-weight:bold; background:#fffbe6; }
        .badge-unread{ background:#fff3cd; color:#856404; padding:3px 10px; border-radius:10px; font-size:12px; }
        .badge-read  { background:#e2e3e5; color:#555; padding:3px 10px; border-radius:10px; font-size:12px; }
        .btn-read  { background:#4a90e2; color:white; border:none; padding:5px 12px; border-radius:5px; cursor:pointer; font-size:12px; }
        .btn-delete{ background:#d9534f; color:white; border:none; padding:5px 12px; border-radius:5px; cursor:pointer; font-size:12px; margin-left:5px; }
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
        <a href="messages.php" class="active">📩 Messages</a>
        <a href="announcements.php">📢 Announcements</a>
        <a href="students.php">👥 Students</a>
        <a href="results.php">📊 Results</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>
    <div class="main">
        <div class="page-title">📩 Contact Messages</div>
        <div class="stats">
            <div class="stat"><h3><?php echo $total; ?></h3><p>Total Messages</p></div>
            <div class="stat"><h3><?php echo $unread; ?></h3><p>Unread</p></div>
        </div>
        <?php if($msg): ?><div class="alert-info"><?php echo $msg; ?></div><?php endif; ?>
        <div class="card">
            <table>
                <thead>
                    <tr><th>#</th><th>Name</th><th>Email</th><th>Message</th><th>Status</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if($contacts && $contacts->num_rows > 0):
                    $i=1; while($row = $contacts->fetch_assoc()): ?>
                    <tr class="<?php echo !$row['is_read'] ? 'unread' : ''; ?>">
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td>
                            <?php if(!$row['is_read']): ?>
                            <span class="badge-unread">Unread</span>
                            <?php else: ?>
                            <span class="badge-read">Read</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d M Y, h:i A', strtotime($row['sent_at'])); ?></td>
                        <td>
                            <?php if(!$row['is_read']): ?>
                            <a href="?read=<?php echo $row['id']; ?>"><button class="btn-read">Mark Read</button></a>
                            <?php endif; ?>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this message?')">
                                <button class="btn-delete">Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="7" style="text-align:center;padding:30px;color:#888;">No messages found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
