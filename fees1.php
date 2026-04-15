<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$full_name  = $_SESSION['full_name'] ?? $_SESSION['user'];
$student_id = $_SESSION['user_id'];

// Fetch fee records for logged-in student
$fees = $conn->query("SELECT * FROM fees WHERE student_id=$student_id ORDER BY due_date DESC");

// Calculate totals
$total_paid    = 0;
$total_pending = 0;
$fee_rows      = [];
while($f = $fees->fetch_assoc()){
    $fee_rows[] = $f;
    if($f['status'] == 'Paid') $total_paid += $f['amount'];
    else                        $total_pending += $f['amount'];
}

$success = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fee_id'])){
    $fid = (int)$_POST['fee_id'];
    $today = date('Y-m-d');
    $conn->query("UPDATE fees SET status='Paid', paid_date='$today' WHERE id=$fid AND student_id=$student_id");
    header("Location: fees1.php?paid=1");
    exit();
}
if(isset($_GET['paid'])) $success = "✅ Payment recorded successfully!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Fees - Sandipani School</title>
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
        .page-title{ font-size:22px; color:#0b3d91; font-weight:bold; margin-bottom:20px; }

        .summary-cards{ display:flex; gap:20px; margin-bottom:25px; flex-wrap:wrap; }
        .scard{ flex:1; min-width:150px; padding:20px; border-radius:10px; text-align:center; color:white; }
        .scard h3{ font-size:28px; }
        .scard p{ font-size:13px; margin-top:5px; }
        .sc1{ background:#2bb673; }
        .sc2{ background:#e94e77; }
        .sc3{ background:#4a90e2; }

        .alert-success{ background:#d4edda; color:#155724; padding:12px 15px; border-radius:6px; margin-bottom:15px; }

        .card{ background:white; padding:25px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.08); }
        table{ width:100%; border-collapse:collapse; }
        thead{ background:#0b3d91; color:white; }
        th, td{ padding:12px 15px; text-align:left; font-size:14px; }
        tr:nth-child(even){ background:#f5f8ff; }

        .badge-paid    { background:#d4edda; color:#155724; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:bold; }
        .badge-pending { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:bold; }
        .badge-overdue { background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:bold; }

        .pay-btn{ background:#0b3d91; color:white; border:none; padding:6px 14px; border-radius:5px; cursor:pointer; font-size:13px; }
        .pay-btn:hover{ background:#082c6c; }

        .no-data{ text-align:center; color:#888; padding:40px; }

        @media(max-width:768px){ .sidebar{ display:none; } .summary-cards{ flex-direction:column; } }
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
        <a href="fees1.php" class="active">💳 Your Fees</a>
        <a href="result.php">📊 Results</a>
        <a href="faculty.php">👩‍🏫 Faculty</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>

    <div class="main">
        <div class="page-title">💳 My Fee Details</div>

        <?php if($success): ?>
        <div class="alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="summary-cards">
            <div class="scard sc1">
                <h3>₹<?php echo number_format($total_paid, 2); ?></h3>
                <p>Total Paid</p>
            </div>
            <div class="scard sc2">
                <h3>₹<?php echo number_format($total_pending, 2); ?></h3>
                <p>Pending / Overdue</p>
            </div>
            <div class="scard sc3">
                <h3>₹<?php echo number_format($total_paid + $total_pending, 2); ?></h3>
                <p>Total Fee</p>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-bottom:15px;color:#0b3d91;">📋 Fee Records</h3>
            <?php if(!empty($fee_rows)): ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fee Type</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Due Date</th>
                        <th>Paid Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($fee_rows as $i => $f): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo htmlspecialchars($f['fee_type']); ?></td>
                        <td>₹<?php echo number_format($f['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($f['payment_method']); ?></td>
                        <td><?php echo $f['due_date'] ? date('d M Y', strtotime($f['due_date'])) : '-'; ?></td>
                        <td><?php echo $f['paid_date'] ? date('d M Y', strtotime($f['paid_date'])) : '-'; ?></td>
                        <td>
                            <span class="badge-<?php echo strtolower($f['status']); ?>">
                                <?php echo $f['status']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if($f['status'] != 'Paid'): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="fee_id" value="<?php echo $f['id']; ?>">
                                <button type="submit" class="pay-btn" onclick="return confirm('Mark as Paid?')">Mark Paid</button>
                            </form>
                            <?php else: ?>
                                <span style="color:#888;">✔ Paid</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="no-data">📭 No fee records found.</div>
            <?php endif; ?>
        </div>
    </div>

</div>
</body>
</html>