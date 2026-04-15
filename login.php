<?php
session_start();
include "db.php";

$error = "";

// Redirect if already logged in
if(isset($_SESSION['user'])){
    header("Location: dashboard.php");
    exit();
}

// Handle login form submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if($user == "" || $pass == ""){
        $error = "⚠ Please enter both username and password.";
    } else {
        $hashed = MD5($pass);
        $stmt = $conn->prepare("SELECT id, full_name, role, class FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $user, $hashed);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $_SESSION['user']      = $user;
            $_SESSION['user_id']   = $row['id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['role']      = $row['role'];
            $_SESSION['class']     = $row['class'];

            if($row['role'] == 'admin'){
                header("Location: admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "❌ Invalid username or password.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Login - Sandipani School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f4f6f9;
        }

        .navbar{
            background:#0b3d91;
            padding:15px 8%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            color:white;
        }

        .logo{
            font-size:20px;
            font-weight:bold;
        }

        .menu a{
            color:white;
            text-decoration:none;
            margin-left:20px;
            font-size:14px;
        }

        .btn-nav{
            background:red;
            padding:8px 14px;
            border-radius:4px;
        }

        .container{
            width:90%;
            max-width:400px;
            margin:60px auto;
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            text-align:center;
        }

        h2{
            color:#0b3d91;
            margin-bottom:20px;
        }

        .input-group{
            text-align:left;
            margin-bottom:15px;
        }

        label{
            font-size:14px;
            display:block;
            margin-bottom:5px;
            color:#333;
        }

        input[type="text"],
        input[type="password"]{
            width:100%;
            padding:9px 12px;
            border:1px solid #ccc;
            border-radius:4px;
            font-size:14px;
        }

        input:focus{
            outline:none;
            border-color:#0b3d91;
        }

        .btn-group{
            display:flex;
            justify-content:space-between;
            margin-top:15px;
        }

        .btn{
            padding:9px 15px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            width:48%;
            font-size:14px;
        }

        .btn-login{
            background:#0b3d91;
            color:white;
        }

        .btn-forgot{
            background:#1e5aa8;
            color:white;
        }

        .btn:hover{
            opacity:0.9;
        }

        #error-msg{
            color:red;
            margin-top:12px;
            font-size:14px;
            background:#fff0f0;
            padding:8px;
            border-radius:4px;
            display: <?php echo $error ? 'block' : 'none'; ?>;
        }

        .footer{
            background:#0b3d91;
            color:white;
            text-align:center;
            padding:15px;
            margin-top:80px;
        }

        .demo-hint{
            margin-top:15px;
            font-size:12px;
            color:#666;
            background:#f0f4ff;
            padding:8px;
            border-radius:4px;
        }
    </style>
</head>

<body>

<div class="navbar">
    <div class="logo">Sandipani School</div>
    <div class="menu">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="admissions.php">Admissions</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Log In</a>
        <a href="apply.php" class="btn-nav">Apply Now</a>
    </div>
</div>

<div class="container">
    <h2>Student Login</h2>

    <form method="POST" onsubmit="return validateForm()">

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   placeholder="Enter username"
                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-login">Login</button>
            <button type="button" class="btn btn-forgot" onclick="window.location='forgot.php'">Forgot</button>
        </div>

    </form>

    <div id="error-msg">
        <?php echo $error; ?>
    </div>

    <div class="demo-hint">
        <strong>Demo:</strong> admin / admin123 &nbsp;|&nbsp; student1 / student123
    </div>
</div>

<br><br>

<div class="footer">
    <br>
    &copy; 2026 Sandipani School | All Rights Reserved
    </br>
</div>

<script>
function validateForm(){
    var user = document.getElementById('username').value.trim();
    var pass = document.getElementById('password').value.trim();
    var errDiv = document.getElementById('error-msg');

    if(user === "" || pass === ""){
        errDiv.style.display = 'block';
        errDiv.innerHTML = "⚠ Please enter both username and password.";
        return false;
    }
    return true;
}
</script>

</body>
</html>