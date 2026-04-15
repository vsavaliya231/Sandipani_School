<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f2f4f8;
        }

        /* Topbar */
        .topbar{
            background:#0b3d91;
            color:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
        }

        .topbar a{
            color:white;
            text-decoration:none;
            margin-left:20px;
        }

        /* Layout */
        .container{
            display:flex;
        }

        .sidebar{
            width:220px;
            background:#123e75;
            height:100vh;
            padding-top:20px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:12px 20px;
            font-size:14px;
        }

        .sidebar a:hover{
            background:#0b3d91;
        }

        .main{
            flex:1;
            padding:30px;
        }

        h2{
            margin-bottom:20px;
        }

        /* Course Cards */
        .courses{
            display:flex;
            gap:20px;
            flex-wrap:wrap;
        }

        .card{
            background:white;
            width:280px;
            padding:20px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .card h3{
            margin-bottom:10px;
        }

        .card p{
            font-size:14px;
            margin-bottom:10px;
        }

        .btn{
            background:#0b3d91;
            color:white;
            padding:8px 12px;
            border:none;
            border-radius:4px;
            cursor:pointer;
        }

        .btn:hover{
            background:#092c6b;
        }

        .footer{
            background:#0b3d91;
            color:white;
            text-align:center;
            padding:20px;
            
        }

        @media(max-width:768px){
            .sidebar{
                display:none;
            }
        }
    </style>
</head>

<body>

<div class="topbar">
    <div><strong>Sandipani School</strong></div>
    <div>
        <a href="result.php">Results</a>
        <a href="login.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="sidebar">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="courses.php">📚 Courses</a>
        <a href="assignments.php">📝 Assignments</a>
        <a href="timetable.php">📊 Time Table</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="result.php">📊 Results</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>

    <div class="main">

        <h2>📚 Available Courses</h2>

        <div class="courses">

            <div class="card">
                <h3>Mathematics</h3>
                <p>Learn algebra, geometry, and advanced calculations.</p>
                <button class="btn" onclick="enroll('Mathematics')">Enroll</button>
            </div>

            <div class="card">
                <h3>Science</h3>
                <p>Explore physics, chemistry, and biology concepts.</p>
                <button class="btn" onclick="enroll('Science')">Enroll</button>
            </div>

            <div class="card">
                <h3>English</h3>
                <p>Improve grammar, writing, and communication skills.</p>
                <button class="btn" onclick="enroll('English')">Enroll</button>
            </div>

            <div class="card">
                <h3>Computer Studies</h3>
                <p>Learn programming, web development, and IT basics.</p>
                <button class="btn" onclick="enroll('Computer Studies')">Enroll</button>
            </div>

        </div>

    </div>

</div>

<script>
    function enroll(course){
        alert("You have enrolled in " + course + " (Demo Only)");
    }
</script>


<div class="footer">
    <br>
    © 2026 Sandipani School | All Rights Reserved
</br>
</div>

</body>
</html>