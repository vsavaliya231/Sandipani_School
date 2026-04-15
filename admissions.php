<?php
include "db.php";
$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];

    if($name=="" || $email=="" || $phone=="" || $class==""){
        $message = "⚠ Please fill all fields";
    } else {
        // Map admissions layout to applications table schema
        $dob = date('Y-m-d');
        $gender = "Other";
        $parent = $email; // store email in parent field
        $address = "Submitted via admissions.php";

        $stmt = $conn->prepare("INSERT INTO applications(name,dob,gender,class,parent,phone,address) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss",$name,$dob,$gender,$class,$parent,$phone,$address);

        if($stmt->execute()){
            $message = "✅ Application submitted successfully!";
        } else {
            $message = "❌ Error! " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admissions - EduSphere School</title>
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
            align-items:center;
        }

        .header a{
            color:white;
            text-decoration:none;
            margin-left:20px;
            font-size:14px;
        }

        .container{
            width:90%;
            max-width:600px;
            margin:40px auto;
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        h2{
            color:#0b3d91;
            margin-bottom:20px;
        }

        input, select{
            width:100%;
            padding:8px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:4px;
        }

        button{
            background:#0b3d91;
            color:white;
            border:none;
            padding:8px 15px;
            border-radius:4px;
            cursor:pointer;
        }

        .message{
            margin-top:15px;
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

    <h2>Admission Form</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Student Full Name">
        <input type="email" name="email" placeholder="Parent/Guardian Email">
        <input type="text" name="phone" placeholder="Phone Number">

        <select name="class">
            <option value="">Select Class</option>
            <option value="1">Class 1</option>
            <option value="2">Class 2</option>
            <option value="3">Class 3</option>
            <option value="4">Class 4</option>
            <option value="5">Class 5</option>
            <option value="6">Class 6</option>
            <option value="7">Class 7</option>
            <option value="8">Class 8</option>
            <option value="9">Class 9</option>
            <option value="10">Class 10</option>
        </select>

        <button type="submit">Apply Now</button>
    </form>

    <div class="message">
        <?php echo $message; ?>
    </div>

</div>
<br></br>
<br></br>

<div class="footer">
    <br>
    © 2026 Sandipani School | All Rights Reserved
</br>
</div>

</body>
</html>
