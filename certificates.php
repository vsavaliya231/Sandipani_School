<!DOCTYPE html>
<html>
<head>
    <title>Certificates</title>
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

        /* Header */
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

        /* Page Title */
        .page-title{
            text-align:center;
            padding:30px 0;
            color:#0b3d91;
        }

        /* Certificate Container */
        .certificate-container{
            width:95%;
            max-width:1100px;
            margin:0 auto 40px auto;
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
            gap:20px;
        }

        /* Card */
        .certificate-card{
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            transition:0.3s;
            text-align:center;
        }

        .certificate-card:hover{
            transform:translateY(-5px);
        }

        .certificate-card h3{
            color:#0b3d91;
            margin-bottom:10px;
        }

        .certificate-card p{
            font-size:14px;
            color:#555;
            margin-bottom:15px;
        }

        .btn{
            padding:8px 15px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            font-size:14px;
            margin:5px;
        }

        .btn-view{
            background:#0b3d91;
            color:white;
        }

        .btn-download{
            background:#1e5aa8;
            color:white;
        }

        .btn:hover{
            opacity:0.9;
        }

        /* Footer */
        .footer{
            background:#0b3d91;
            color:white;
            text-align:center;
            padding:15px;
        }

        @media(max-width:600px){
            .certificate-card{
                padding:15px;
            }
        }

    </style>
</head>

<body>

<!-- Header -->
<div class="header">
    <h2>Sandipani School</h2>
    <div>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="announcement.php">📢 Announcements</a>
        <a href="result.php">Results</a>
        <a href="login.php">Logout</a>
    </div>
</div>

<!-- Title -->
<div class="page-title">
    <h1>My Certificates</h1>
    <p>View and download your earned certificates</p>
</div>

<!-- Certificates -->
<div class="certificate-container">

    <div class="certificate-card">
        <h3>Academic Excellence</h3>
        <p>Awarded for outstanding academic performance.</p>
        <button class="btn btn-view" onclick="viewCert()">View</button>
        <button class="btn btn-download" onclick="downloadCert()">Download</button>
    </div>

    <div class="certificate-card">
        <h3>Science Fair Winner</h3>
        <p>First prize in Annual Science Exhibition.</p>
        <button class="btn btn-view" onclick="viewCert()">View</button>
        <button class="btn btn-download" onclick="downloadCert()">Download</button>
    </div>

    <div class="certificate-card">
        <h3>Sports Achievement</h3>
        <p>Winner of Inter-School Football Tournament.</p>
        <button class="btn btn-view" onclick="viewCert()">View</button>
        <button class="btn btn-download" onclick="downloadCert()">Download</button>
    </div>

    <div class="certificate-card">
        <h3>Programming Contest</h3>
        <p>Participation in Coding Competition.</p>
        <button class="btn btn-view" onclick="viewCert()">View</button>
        <button class="btn btn-download" onclick="downloadCert()">Download</button>
    </div>

</div>

<!-- Footer -->
 <br></br>
 <br></br>
 <br></br>
 <br></br>
 <br></br>
 <br></br>
 <br></br>
 <br></br>
<div class="footer">
    <br>
    © 2026 Sandipani School | All Rights Reserved
</br>
</div>

<script>
    function viewCert(){
        alert("Certificate Preview (Demo Only)");
    }

    function downloadCert(){
        alert("Certificate Download Started (Demo Only)");
    }
</script>

</body>
</html>