<!DOCTYPE html>
<html>
<head>
    <title>Course Materials</title>
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

        /* Top Header */
        .header{
            background:#0b3d91;
            color:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .header h2{
            font-weight:bold;
        }

        .header a{
            color:white;
            text-decoration:none;
            margin-left:20px;
            font-size:14px;
        }

        /* Page Title */
        .page-title{
            text-align:center;
            padding:30px 0;
            color:#0b3d91;
        }

        /* Materials Container */
        .materials-container{
            width:90%;
            max-width:1000px;
            margin:0 auto 40px auto;
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
            gap:20px;
        }

        /* Card Design */
        .material-card{
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            transition:0.3s;
        }

        .material-card:hover{
            transform:translateY(-5px);
        }

        .material-card h3{
            color:#0b3d91;
            margin-bottom:10px;
        }

        .material-card p{
            font-size:14px;
            margin-bottom:15px;
            color:#555;
        }

        .btn-download{
            display:inline-block;
            padding:8px 15px;
            background:#0b3d91;
            color:white;
            text-decoration:none;
            border-radius:4px;
            font-size:14px;
        }

        .btn-download:hover{
            background:#1e5aa8;
        }

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

        /* Footer */
        .footer{
            background:#0b3d91;
            color:white;
            text-align:center;
            padding:15px;
        }
    </style>
</head>

<body>


<div class="topbar">
    <div><strong>Sandipani School</strong></div>
    <div class="top-links">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="announcement.php">📢 Announcements</a>
        <a href="result.php">Result</a>
        <a href="settings.php"> Settings</a>
    </div>
</div>



<!-- Page Title -->
<div class="page-title">
    <h1>Course Materials</h1>
    <p>Download study materials for your subjects</p>
</div>

<!-- Materials Section -->
<div class="materials-container">

    <div class="material-card">
        <h3>Mathematics Notes</h3>
        <p>Algebra, Geometry, and Trigonometry complete notes.</p>
        <a href="#" class="btn-download" onclick="downloadAlert()">Download PDF</a>
    </div>

    <div class="material-card">
        <h3>Science Guide</h3>
        <p>Physics, Chemistry and Biology theory material.</p>
        <a href="#" class="btn-download" onclick="downloadAlert()">Download PDF</a>
    </div>

    <div class="material-card">
        <h3>English Grammar</h3>
        <p>Grammar rules, essays, and letter writing format.</p>
        <a href="#" class="btn-download" onclick="downloadAlert()">Download PDF</a>
    </div>

    <div class="material-card">
        <h3>Computer Programming</h3>
        <p>HTML, CSS, JavaScript and PHP learning notes.</p>
        <a href="#" class="btn-download" onclick="downloadAlert()">Download PDF</a>
    </div>

</div>

<!-- Footer -->
 <br></br>
 <br></br>
<div class="footer">
    <br>
    © 2026 Sandipani School | All Rights Reserved
</br>
</div>

<script>
    function downloadAlert(){
        alert("Download started (Demo Only)");
    }
</script>

</body>
</html>