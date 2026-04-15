<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION['full_name'] ?? $_SESSION['user'];

// Fetch announcements from DB
$result = $conn->query("SELECT * FROM announcements ORDER BY posted_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Announcements - Sandipani School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
        body{ background:#f2f2f2; }

        .topbar{ background:#0b3d91; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
        .top-links a{ color:white; text-decoration:none; margin-left:20px; font-size:14px; }

        .container{ display:flex; }

        .sidebar{ width:220px; background:#123e75; min-height:100vh; padding-top:20px; color:white; }
        .sidebar a{ display:block; color:white; text-decoration:none; padding:12px 20px; font-size:14px; transition:0.3s; }
        .sidebar a:hover{ background:#0b3d91; }
        .sidebar a.active{ background:#0b3d91; border-left:4px solid #fff; }

        .main{ flex:1; padding:30px; }

        .page-title{ font-size:22px; margin-bottom:25px; color:#0b3d91; font-weight:bold; }

        .announcement{
            background:white;
            padding:20px 25px;
            border-left:5px solid #0b3d91;
            border-radius:8px;
            margin-bottom:15px;
            box-shadow:0 2px 8px rgba(0,0,0,0.07);
            transition:0.3s;
        }
        .announcement:hover{ transform:translateX(4px); }
        .announcement h3{ color:#0b3d91; margin-bottom:6px; font-size:16px; }
        .announcement p{ color:#555; font-size:14px; line-height:1.6; }
        .date{ font-size:12px; color:#999; margin-top:8px; }
        .badge-new{ background:#e8f4fd; color:#0b3d91; font-size:11px; padding:2px 8px; border-radius:10px; margin-left:8px; }

        .no-data{ text-align:center; color:#888; margin-top:40px; font-size:15px; }

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
        <a href="timetable.php">📊 Time Table</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="result.php">📊 Results</a>
        <a href="faculty.php">👩‍🏫 Faculty</a>
        <a href="announcement.php" class="active">📢 Announcements</a>
    </div>

    <div class="main">
        <div class="page-title">📢 School Announcements</div>

        <?php if($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): 
                $isNew = (strtotime($row['posted_at']) > strtotime('-7 days'));
            ?>
            <div class="announcement">
                <h3>
                    <?php echo htmlspecialchars($row['title']); ?>
                    <?php if($isNew): ?><span class="badge-new">NEW</span><?php endif; ?>
                </h3>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <div class="date">
                    📅 <?php echo date('d M Y, h:i A', strtotime($row['posted_at'])); ?>
                    &nbsp;|&nbsp; Posted by: <?php echo htmlspecialchars($row['posted_by']); ?>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-data">📭 No announcements at this time. Check back later!</div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>