<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$user_id   = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'] ?? $_SESSION['user'];
$msg       = '';
$msg_type  = '';

// Fetch current user data
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Update profile info
    if(isset($_POST['update_profile'])){
        $new_name  = $conn->real_escape_string(trim($_POST['full_name']));
        $new_email = $conn->real_escape_string(trim($_POST['email']));

        if($new_name == ''){
            $msg = "⚠ Full name cannot be empty.";
            $msg_type = 'warn';
        } else {
            $conn->query("UPDATE users SET full_name='$new_name', email='$new_email' WHERE id=$user_id");
            $_SESSION['full_name'] = $new_name;
            $full_name = $new_name;
            $user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
            $msg = "✅ Profile updated successfully!";
            $msg_type = 'success';
        }
    }

    // Change password
    if(isset($_POST['change_password'])){
        $current  = MD5(trim($_POST['current_password']));
        $new_pass = trim($_POST['new_password']);
        $confirm  = trim($_POST['confirm_password']);

        if($current !== $user['password']){
            $msg = "❌ Current password is incorrect.";
            $msg_type = 'error';
        } elseif(strlen($new_pass) < 6){
            $msg = "⚠ New password must be at least 6 characters.";
            $msg_type = 'warn';
        } elseif($new_pass !== $confirm){
            $msg = "⚠ New passwords do not match.";
            $msg_type = 'warn';
        } else {
            $hashed = MD5($new_pass);
            $conn->query("UPDATE users SET password='$hashed' WHERE id=$user_id");
            $msg = "✅ Password changed successfully!";
            $msg_type = 'success';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings - Sandipani School</title>
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

        .main{ flex:1; padding:30px; max-width:700px; }
        .page-title{ font-size:22px; color:#0b3d91; font-weight:bold; margin-bottom:25px; }

        .profile-card{
            background:white; border-radius:12px; padding:30px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08); margin-bottom:25px;
        }
        .profile-card h3{ color:#0b3d91; margin-bottom:20px; font-size:17px; border-bottom:2px solid #e8f0ff; padding-bottom:10px; }

        .avatar{
            width:70px; height:70px; border-radius:50%;
            background:#0b3d91; color:white;
            display:flex; align-items:center; justify-content:center;
            font-size:28px; margin-bottom:15px;
        }
        .user-info p{ font-size:14px; color:#555; margin-bottom:4px; }
        .user-info strong{ color:#0b3d91; }

        .form-group{ margin-bottom:16px; }
        .form-group label{ display:block; font-size:13px; color:#555; margin-bottom:6px; font-weight:bold; }
        .form-group input{
            width:100%; padding:10px 12px; border:1px solid #ddd;
            border-radius:6px; font-size:14px; transition:0.3s;
        }
        .form-group input:focus{ outline:none; border-color:#0b3d91; box-shadow:0 0 0 3px rgba(11,61,145,0.1); }

        .btn-save{ background:#0b3d91; color:white; border:none; padding:10px 25px; border-radius:6px; cursor:pointer; font-size:14px; }
        .btn-save:hover{ background:#082c6c; }

        .alert{ padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
        .alert-success{ background:#d4edda; color:#155724; }
        .alert-warn   { background:#fff3cd; color:#856404; }
        .alert-error  { background:#f8d7da; color:#721c24; }

        .badge-role{ background:#e8f0ff; color:#0b3d91; padding:3px 12px; border-radius:10px; font-size:12px; font-weight:bold; }

        @media(max-width:768px){ .sidebar{ display:none; } }
    </style>
</head>
<body>

<div class="topbar">
    <div><strong>Sandipani School</strong></div>
    <div class="top-links">
        <span>👤 <?php echo htmlspecialchars($full_name); ?></span>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="sidebar">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📊 Time Table</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="result.php">📊 Results</a>
        <a href="announcement.php">📢 Announcements</a>
        <a href="settings.php">⚙ Settings</a>
        <a href="logout.php">🔒 Logout</a>
    </div>

    <div class="main">
        <div class="page-title">⚙ Account Settings</div>

        <?php if($msg): ?>
        <div class="alert alert-<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <!-- Profile Info -->
        <div class="profile-card">
            <h3>👤 Profile Information</h3>
            <div class="user-info" style="margin-bottom:20px;">
                <div class="avatar"><?php echo strtoupper(substr($user['full_name'],0,1)); ?></div>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Class:</strong> <?php echo htmlspecialchars($user['class'] ?? 'N/A'); ?></p>
                <p><strong>Role:</strong> <span class="badge-role"><?php echo ucfirst($user['role']); ?></span></p>
                <p><strong>Joined:</strong> <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
            </div>
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" placeholder="Enter your email">
                </div>
                <button type="submit" name="update_profile" class="btn-save">💾 Update Profile</button>
            </form>
        </div>

        <!-- Change Password -->
        <div class="profile-card">
            <h3>🔑 Change Password</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" placeholder="Enter current password" required>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" placeholder="Enter new password (min. 6 chars)" required>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                </div>
                <button type="submit" name="change_password" class="btn-save">🔒 Change Password</button>
            </form>
        </div>

    </div>
</div>

</body>
</html>