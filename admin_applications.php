<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = '';

// Handle approve/reject
if(isset($_GET['action']) && isset($_GET['id'])){
    $id     = (int)$_GET['id'];
    $action = $_GET['action'] == 'approve' ? 'Approved' : 'Rejected';
    $conn->query("UPDATE applications SET status='$action' WHERE id=$id");
    header("Location: applications.php?done=$action");
    exit();
}

if(isset($_GET['done'])) $msg = "✅ Application " . $_GET['done'] . " successfully.";

// Search/filter
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';

$where = "WHERE 1";
if($search) $where .= " AND (name LIKE '%$search%' OR phone LIKE '%$search%')";
if($filter) $where .= " AND status='$filter'";

$apps = $conn->query("SELECT * FROM applications $where ORDER BY applied_at DESC");
$total = $conn->query("SELECT COUNT(*) as c FROM applications")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) as c FROM applications WHERE status='Pending'")->fetch_assoc()['c'];
$approved = $conn->query("SELECT COUNT(*) as c FROM applications WHERE status='Approved'")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Applications – Admin Panel</title>
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
        .stats{ display:flex; gap:15px; margin-bottom:20px; flex-wrap:wrap; }
        .stat{ flex:1; min-width:120px; background:white; border-radius:8px; padding:18px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
        .stat h3{ font-size:28px; color:#0b3d91; }
        .stat p{ font-size:12px; color:#666; margin-top:4px; }
        .filter-bar{ display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
        .filter-bar input, .filter-bar select{ padding:8px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; }
        .filter-bar button{ background:#0b3d91; color:white; border:none; padding:9px 18px; border-radius:6px; cursor:pointer; }
        .alert{ padding:12px 15px; border-radius:6px; margin-bottom:15px; background:#d4edda; color:#155724; }
        .card{ background:white; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; }
        table{ width:100%; border-collapse:collapse; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:11px 14px; text-align:left; font-size:13px; }
        tr:nth-child(even){ background:#f7f9ff; }
        .badge{ display:inline-block; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:bold; }
        .badge-pending  { background:#fff3cd; color:#856404; }
        .badge-approved { background:#d4edda; color:#155724; }
        .badge-rejected { background:#f8d7da; color:#721c24; }
        .btn-approve{ background:#1a9e4a; color:white; border:none; padding:5px 12px; border-radius:5px; cursor:pointer; font-size:12px; }
        .btn-reject { background:#d9534f; color:white; border:none; padding:5px 12px; border-radius:5px; cursor:pointer; font-size:12px; }
        .btn-approve:hover{ background:#157a39; }
        .btn-reject:hover { background:#b52b27; }
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
        <a href="applications.php" class="active">📋 Applications</a>
        <a href="messages.php">📩 Messages</a>
        <a href="announcements.php">📢 Announcements</a>
        <a href="students.php">👥 Students</a>
        <a href="results.php">📊 Results</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>
    <div class="main">
        <div class="page-title">📋 Admission Applications</div>

        <div class="stats">
            <div class="stat"><h3><?php echo $total; ?></h3><p>Total</p></div>
            <div class="stat"><h3><?php echo $pending; ?></h3><p>Pending</p></div>
            <div class="stat"><h3><?php echo $approved; ?></h3><p>Approved</p></div>
        </div>

        <?php if($msg): ?><div class="alert"><?php echo $msg; ?></div><?php endif; ?>

        <form method="GET" class="filter-bar">
            <input type="text" name="search" placeholder="Search name or phone..." value="<?php echo htmlspecialchars($search); ?>">
            <select name="status">
                <option value="">All Status</option>
                <option value="Pending"  <?php echo $filter=='Pending'  ? 'selected' : ''; ?>>Pending</option>
                <option value="Approved" <?php echo $filter=='Approved' ? 'selected' : ''; ?>>Approved</option>
                <option value="Rejected" <?php echo $filter=='Rejected' ? 'selected' : ''; ?>>Rejected</option>
            </select>
            <button type="submit">Filter</button>
            <a href="applications.php" style="padding:9px 18px;border-radius:6px;background:#6c757d;color:white;text-decoration:none;font-size:14px;">Reset</a>
        </form>

        <div class="card">
            <table>
                <thead>
                    <tr><th>#</th><th>Name</th><th>DOB</th><th>Gender</th><th>Class</th><th>Parent</th><th>Phone</th><th>Address</th><th>Status</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if($apps && $apps->num_rows > 0):
                    $i = 1;
                    while($row = $apps->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                        <td><?php echo date('d M Y', strtotime($row['dob'])); ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo htmlspecialchars($row['parent']); ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo htmlspecialchars(substr($row['address'],0,30)).'...'; ?></td>
                        <td><span class="badge badge-<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></td>
                        <td><?php echo date('d M Y', strtotime($row['applied_at'])); ?></td>
                        <td>
                            <?php if($row['status'] == 'Pending'): ?>
                            <a href="?action=approve&id=<?php echo $row['id']; ?>" onclick="return confirm('Approve?')"><button class="btn-approve">Approve</button></a>
                            <a href="?action=reject&id=<?php echo $row['id']; ?>"  onclick="return confirm('Reject?')"><button class="btn-reject">Reject</button></a>
                            <?php else: echo '<span style="color:#aaa;">Done</span>'; endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="11" style="text-align:center;padding:30px;color:#888;">No applications found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
