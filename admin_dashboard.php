<?php
session_start();
include "../db.php";

// Protect admin page
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

// Fetch stats
$total_students     = $conn->query("SELECT COUNT(*) as cnt FROM users WHERE role='student'")->fetch_assoc()['cnt'];
$total_applications = $conn->query("SELECT COUNT(*) as cnt FROM applications")->fetch_assoc()['cnt'];
$pending_apps       = $conn->query("SELECT COUNT(*) as cnt FROM applications WHERE status='Pending'")->fetch_assoc()['cnt'];
$total_contacts     = $conn->query("SELECT COUNT(*) as cnt FROM contacts WHERE is_read=0")->fetch_assoc()['cnt'];

// Fetch recent applications
$apps = $conn->query("SELECT * FROM applications ORDER BY applied_at DESC LIMIT 5");

// Fetch recent contacts
$contacts = $conn->query("SELECT * FROM contacts ORDER BY sent_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Sandipani School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
        body{ background:#f2f2f2; }

        .topbar{
            background:#0b3d91; color:white;
            padding:15px 30px;
            display:flex; justify-content:space-between; align-items:center;
        }
        .top-links a{ color:white; text-decoration:none; margin-left:20px; font-size:14px; }

        .container{ display:flex; }

        .sidebar{
            width:220px; background:#123e75;
            min-height:100vh; padding-top:20px; color:white;
        }
        .sidebar a{
            display:block; color:white; text-decoration:none;
            padding:12px 20px; font-size:14px; transition:0.3s;
        }
        .sidebar a:hover{ background:#0b3d91; }

        .main{ flex:1; padding:30px; }

        .stats{ display:flex; gap:20px; margin-bottom:30px; flex-wrap:wrap; }
        .stat-card{
            flex:1; min-width:150px;
            padding:20px; border-radius:8px;
            text-align:center; color:white;
            text-decoration:none; display:block;
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card h3{ font-size:32px; }
        .stat-card p{ font-size:13px; margin-top:5px; }
        .s1{ background:#2bb673; }
        .s2{ background:#4a90e2; }
        .s3{ background:#f5a623; }
        .s4{ background:#e94e77; }
        
        table{ width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08); }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:10px 14px; text-align:left; font-size:13px; }
        tr:nth-child(even){ background:#f5f8ff; }
        h3{ margin:20px 0 12px; color:#0b3d91; }

        .badge{
            display:inline-block; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:bold;
        }
        .badge-pending  { background:#fff3cd; color:#856404; }
        .badge-approved { background:#d4edda; color:#155724; }
        .badge-rejected { background:#f8d7da; color:#721c24; }

        @media(max-width:768px){ .sidebar{ display:none; } .stats{ flex-direction:column; } }
    </style>
</head>
<body>

<div class="topbar">
    <div><strong>Sandipani School – Admin</strong></div>
    <div class="top-links">
        <a href="../settings.php">Settings</a>
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
        <a href="timetable.php">📅 Timetable</a>
        <a href="../logout.php">🔒 Logout</a>
    </div>

    <div class="main">
        <h2 style="margin-bottom:20px;">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>

        <div class="stats">
            <a href="students.php" class="stat-card s1">
                <h3><?php echo $total_students; ?></h3>
                <p>Total Students</p>
            </a>
            <a href="applications.php" class="stat-card s2">
                <h3><?php echo $total_applications; ?></h3>
                <p>Applications</p>
            </a>
            <a href="applications.php?status=Pending" class="stat-card s3">
                <h3><?php echo $pending_apps; ?></h3>
                <p>Pending Applications</p>
            </a>
            <a href="messages.php" class="stat-card s4">
                <h3><?php echo $total_contacts; ?></h3>
                <p>Unread Messages</p>
            </a>
        </div>

        <h3>📋 Recent Applications</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Name</th><th>Class</th><th>Parent</th><th>Phone</th><th>Status</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $apps->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['class']; ?></td>
                    <td><?php echo htmlspecialchars($row['parent']); ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td>
                        <span class="badge badge-<?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td><?php echo date('d M Y', strtotime($row['applied_at'])); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h3>📩 Recent Messages</h3>
        <table>
            <thead>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>
            </thead>
            <tbody>
            <?php while($row = $contacts->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['message'], 0, 60)) . '...'; ?></td>
                    <td><?php echo date('d M Y', strtotime($row['sent_at'])); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
