<!DOCTYPE html>
<html>
<head>
<title>E-Learning</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
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

/* Sidebar */
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

/* Main */
.main{
    flex:1;
    padding:30px;
}

.cards{
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
    margin-bottom:15px;
}

button{
    padding:8px 12px;
    background:#0b3d91;
    color:white;
    border:none;
    border-radius:4px;
    cursor:pointer;
}

button:hover{
    background:#092c6b;
}

.video-section{
    margin-top:40px;
    background:white;
    padding:20px;
    border-radius:8px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
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
    </div>

    <div class="main">

        <h2>📘 E-Learning Materials</h2>
        <br>

        <div class="cards">

            <div class="card">
                <h3>Mathematics Video</h3>
                <p>Watch algebra basics and practice problems.</p>
                <button onclick="watchVideo('Mathematics')">Watch Now</button>
            </div>

            <div class="card">
                <h3>Science Video</h3>
                <p>Learn physics concepts with animations.</p>
                <button onclick="watchVideo('Science')">Watch Now</button>
            </div>

            <div class="card">
                <h3>English Grammar</h3>
                <p>Improve your grammar skills step by step.</p>
                <button onclick="watchVideo('English')">Watch Now</button>
            </div>

        </div>

        <div class="video-section" id="videoSection" style="display:none;">
            <h3 id="videoTitle"></h3>
            <p>📺 Demo Video Playing... (Sample Content)</p>
        </div>

    </div>

</div>

<script>
function watchVideo(subject){
    document.getElementById("videoSection").style.display = "block";
    document.getElementById("videoTitle").innerHTML = subject + " - Learning Video";
}
</script>

</body>
</html>