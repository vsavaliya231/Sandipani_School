<?php
session_start();
include "db.php";

// Protect page – redirect to login if not logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$full_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f2f2f2;
        }

        /* Top Navbar */
        .topbar{
            background:#0b3d91;
            color:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .top-links a{
            color:white;
            text-decoration:none;
            margin-left:20px;
            font-size:14px;
        }

        /* Layout */
        .container{
            display:flex;
        }

        /* Sidebar */
        .sidebar{
            width:220px;
            background:#123e75;
            height:100vh;
            padding-top:20px;
            color:white;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:12px 20px;
            font-size:14px;
            transition:0.3s;
        }

        .sidebar a:hover{
            background:#0b3d91;
        }

        /* Main Content */
        .main{
            flex:1;
            padding:30px;
        }

        .welcome{
            font-size:22px;
            margin-bottom:20px;
        }

        /* Cards */
        .cards{
            display:flex;
            gap:20px;
            margin-bottom:30px;
        }

        .card{
            flex:1;
            padding:20px;
            border-radius:8px;
            text-align:center;
            transition:0.3s;
        }

        .card a{
            color:white;
            text-decoration:none;
            font-weight:bold;
            font-size:16px;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card1{ background:#2bb673; }
        .card2{ background:#4a90e2; }
        .card3{ background:#f5a623; }
        .card4{ background:#e94e77; }

        /* Gallery */
        .gallery{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(220px,1fr));
            gap:20px;
            margin-top:20px;
        }

        .gallery-item{
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
            text-align:center;
            transition:0.3s;
        }

        .gallery-item:hover{
            transform:scale(1.05);
        }

        .gallery-item img{
            width:100%;
            height:220px;
            object-fit:cover;
        }

        .gallery-item p{
            padding:12px;
            font-weight:bold;
            color:#0b3d91;
        }

        .hidden{
            display:none;
        }

        /* View More Button */
       .more-btn{
    text-align:center;
    margin-top:25px;
}

.more-btn button{
    background:#0b3d91;
    color:white;
    padding:10px 25px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:14px;
    transition:0.3s;
}

.more-btn button:hover{
    background:#082c6c;
}

        @media(max-width:768px){
            .cards{
                flex-direction:column;
            }
            .sidebar{
                display:none;
            }
        }

    </style>
</head>

<body>

<div class="topbar">
    <div><strong>Sandipani School</strong></div>
    <div class="top-links">
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <!-- Sidebar -->
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
        <a href="instructions.php">📌 Instructions</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>

    <!-- Main Content -->
    <div class="main">

        <div class="welcome">Welcome, <?php echo htmlspecialchars($full_name); ?>!</div>

        <div class="cards">
            <div class="card card1"><a href="elearning.php">E-Learning</a></div>
            <div class="card card2"><a href="course-materials.php">Course Materials</a></div>
            <div class="card card3"><a href="examination.php">Examination</a></div>
            <div class="card card4"><a href="certificates.php">Certificates</a></div>
        </div>

        <h3>📸 School Gallery</h3>

        <div class="gallery">

            <div class="gallery-item">
                <img src="image/JSS_0920.JPG" alt="">
                <p>Annual Function</p>
            </div>

            <div class="gallery-item">
                <img src="image/JSS_8640.JPG" alt="">
                <p>Sports Day</p>
            </div>

            <div class="gallery-item">
                <img src="image/IMG_0907.JPG" alt="">
                <p>Science Fair</p>
            </div>

            <div class="gallery-item">
                <img src="image/JSS_3734.JPG" alt="">
                <p>Independence Day</p>
            </div>

            <!-- Hidden Images -->
            <div class="gallery-item hidden extra">
                <img src="image/JSS_0920.JPG" alt="">
                <p>Annual Function 2</p>
            </div>

            <div class="gallery-item hidden extra">
                <img src="image/JSS_8640.JPG" alt="">
                <p>Sports Day 2</p>
            </div>

        </div>

        <div class="more-btn">
    <a href="gallery-more.php">
        <button>View More</button>
    </a>
</div>

    </div>

</div>

<script>
function showMore(){
    let items = document.querySelectorAll('.extra');
    items.forEach(item => {
        item.classList.remove('hidden');
    });

    document.querySelector('.more-btn').style.display = "none";
}
</script>

</body>
</html>