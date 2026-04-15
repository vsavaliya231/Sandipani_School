
<?php
include "db.php";
$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $parent = $_POST['parent'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if($name=="" || $dob=="" || $gender=="" || $class=="" || $parent=="" || $phone=="" || $address==""){
        $message = "⚠ Please fill all fields";
    } else {

        $stmt = $conn->prepare("INSERT INTO applications(name,dob,gender,class,parent,phone,address) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss",$name,$dob,$gender,$class,$parent,$phone,$address);

        if($stmt->execute()){
            $message = "✅ Application Submitted Successfully!";
        } else {
            $message = "❌ Error!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply Now - EduSphere School</title>
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
        
        .logo{
            font-size:20px;
            font-weight:bold;
        }

        .navbar{
            background:#0b3d91;
            padding:15px 8%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            color:white;
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

        .header{
            background:#0b3d91;
            color:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
        }

        .header a{
            color:white;
            text-decoration:none;
            margin-left:20px;
        }

        .container{
            width:95%;
            max-width:700px;
            margin:40px auto;
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        h2{
            color:#0b3d91;
            margin-bottom:20px;
            text-align:center;
        }

        input, select, textarea{
            width:100%;
            padding:8px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:4px;
        }

        textarea{
            resize:none;
            height:80px;
        }

        .gender-box{
            display:flex;
            gap:15px;
            margin-bottom:15px;
        }

        button{
            background:#0b3d91;
            color:white;
            border:none;
            padding:10px;
            border-radius:4px;
            width:100%;
            cursor:pointer;
        }

        .message{
            margin-top:15px;
            text-align:center;
            font-size:14px;
        }

        .footer{
            background:#0b3d91;
            color:white;
            text-align:center;
            padding:15px;
            margin-top:40px;
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
        <a href="login.php">log in </a>
        <a href="apply.php" class="btn-nav">Apply Now</a>
    </div>
</div>

<div class="container">

    <h2>Apply Now</h2>

    <form method="POST">

        <input type="text" name="name" placeholder="Student Full Name">

        <input type="date" name="dob">

        <div class="gender-box">
            <label><input type="radio" name="gender" value="Male"> Male</label>
            <label><input type="radio" name="gender" value="Female"> Female</label>
        </div>

        <select name="class">
            <option value="">Select Class</option>
            <option>Class 1</option>
            <option>Class 2</option>
            <option>Class 3</option>
            <option>Class 4</option>
            <option>Class 5</option>
            <option>Class 6</option>
            <option>Class 7</option>
            <option>Class 8</option>
            <option>Class 9</option>
            <option>Class 10</option>
        </select>

        <input type="text" name="parent" placeholder="Parent/Guardian Name">
        <input type="text" name="phone" placeholder="Phone Number">

        <textarea name="address" placeholder="Full Address"></textarea>

        <button type="submit">Submit Application</button>

    </form>

    <div class="message">
        <?php echo $message; ?>
    </div>

</div>

<div class="footer">
    <br>
    © 2026 Sandipani School | All Rights Reserved
</br>
</div>

</body>
</html>
