<?php
include "db.php";
$message  = "";
$msg_type = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST['email']);

    if($email == ""){
        $message  = "⚠ Please enter your email address.";
        $msg_type = "warn";
    } else {
        // Check if email exists in DB
        $stmt = $conn->prepare("SELECT id, full_name, username FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            // In a real system you'd send an email. We'll simulate and show username hint.
            $message  = "✅ Account found! Your username is: <strong>" . htmlspecialchars($row['username']) . "</strong>. Please contact admin to reset your password.";
            $msg_type = "success";
        } else {
            $message  = "❌ No account found with that email address.";
            $msg_type = "error";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password - Sandipani School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }

        body{
            background: linear-gradient(135deg, #0b3d91 0%, #1e5aa8 50%, #123e75 100%);
            min-height:100vh;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }

        .box{
            background:white;
            padding:35px 30px;
            width:95%;
            max-width:400px;
            border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
            text-align:center;
        }

        .school-name{
            color:#0b3d91;
            font-size:14px;
            font-weight:bold;
            letter-spacing:1px;
            margin-bottom:10px;
        }

        h2{
            color:#0b3d91;
            margin-bottom:8px;
            font-size:22px;
        }

        .subtitle{
            color:#888;
            font-size:13px;
            margin-bottom:25px;
        }

        .form-group{ text-align:left; margin-bottom:16px; }
        .form-group label{ display:block; font-size:13px; color:#555; margin-bottom:6px; font-weight:bold; }

        input[type="email"]{
            width:100%; padding:10px 12px;
            border:1px solid #ddd; border-radius:6px; font-size:14px;
            transition:0.3s;
        }
        input[type="email"]:focus{ outline:none; border-color:#0b3d91; box-shadow:0 0 0 3px rgba(11,61,145,0.1); }

        button{
            background:#0b3d91; color:white;
            border:none; padding:11px;
            border-radius:6px; cursor:pointer;
            width:100%; font-size:15px;
            transition:0.3s; margin-top:5px;
        }
        button:hover{ background:#082c6c; }

        .alert{
            margin-top:18px; padding:12px 15px;
            border-radius:8px; font-size:13px; text-align:left;
        }
        .alert-success{ background:#d4edda; color:#155724; }
        .alert-warn   { background:#fff3cd; color:#856404; }
        .alert-error  { background:#f8d7da; color:#721c24; }

        .back-link{
            display:block; margin-top:20px;
            font-size:14px; color:#0b3d91; text-decoration:none;
        }
        .back-link:hover{ text-decoration:underline; }

        .footer{
            margin-top:20px; color:rgba(255,255,255,0.6);
            font-size:12px; text-align:center;
        }
    </style>
</head>
<body>

<div class="box">
    <div class="school-name">🎓 SANDIPANI SCHOOL</div>
    <h2>Forgot Password?</h2>
    <p class="subtitle">Enter your registered email to find your account.</p>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email"
                   placeholder="Enter your email address"
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>
        <button type="submit">🔍 Find My Account</button>
    </form>

    <?php if($message): ?>
    <div class="alert alert-<?php echo $msg_type; ?>">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>

    <a href="login.php" class="back-link">← Back to Login</a>
</div>

<div class="footer">© 2026 Sandipani School | All Rights Reserved</div>

</body>
</html>
