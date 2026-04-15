<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sandipani School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background:#f4f4f4;
        }

        /* ===== Navbar ===== */
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

        .menu a:hover{
            text-decoration:underline;
        }

        .btn-nav{
            background:red;
            padding:8px 14px;
            border-radius:4px;
        }

        /* ===== Hero Section ===== */
        .hero{
            height:400px;
            background:url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f') no-repeat center/cover;
            display:flex;
            align-items:center;
            padding-left:8%;
            color:white;
        }

        .hero-content{
            background:rgba(0,0,0,0.5);
            padding:30px;
            border-radius:6px;
        }

        .hero h1{
            font-size:32px;
            margin-bottom:10px;
        }

        .hero p{
            font-size:14px;
            margin-bottom:15px;
        }

        .btn{
            padding:10px 18px;
            border:none;
            cursor:pointer;
            border-radius:4px;
            margin-right:10px;
        }

        .btn-red{
            background:red;
            color:white;
        }

        .btn-white{
            background:white;
            color:black;
        }

        /* ===== Section ===== */
        .section{
            padding:40px 8%;
        }

        .section h2{
            margin-bottom:20px;
        }

        .cards{
            display:flex;
            gap:20px;
        }

        .card{
            background:white;
            flex:1;
            border-radius:6px;
            overflow:hidden;
            box-shadow:0 3px 8px rgba(0,0,0,0.1);
        }

        .card img{
            width:100%;
            height:150px;
            object-fit:cover;
        }

        .card-content{
            padding:15px;
        }

        /* ===== Footer ===== */
        footer{
            background:#0b3d91;
            color:white;
            text-align:center;
            padding:15px;
            margin-top:30px;
        }

        /* Responsive */
        @media(max-width:768px){
            .cards{
                flex-direction:column;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
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

<!-- Hero Section -->
<div class="hero">
    <div class="hero-content">
        <h1>Welcome to Sandipani School</h1>
        <p>Empowering students to achieve excellence in academics and life.</p>
        <button class="btn btn-red" onclick="learnMore()"><a href="learnmore.php">Learn More</a></button>
        <button class="btn btn-white"><a href="apply.php">Apply Now</a></button>
    </div>
</div>

<!-- Programs Section -->
<div class="section">
    <h2>Our Programs</h2>
    <div class="cards">
        <div class="card">
            <img src="https://images.unsplash.com/photo-1588072432836-e10032774350">
            <div class="card-content">
                <h3>Primary Education</h3>
                <p>Strong foundation for young learners.</p>
            </div>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7">
            <div class="card-content">
                <h3>Secondary Education</h3>
                <p>Preparing students for future success.</p>
            </div>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644">
            <div class="card-content">
                <h3>Sports & Activities</h3>
                <p>Encouraging creativity and teamwork.</p>
            </div>
        </div>
    </div>
</div>

<footer>
    <br>
    © 2026 Sandipani School | All Rights Reserved
</br>
</footer>

<script>
    function learnMore(){
        alert("Welcome to EduSphere School! We provide quality education.");
    }
</script>

</body>
</html>