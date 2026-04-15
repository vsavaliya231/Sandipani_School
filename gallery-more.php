<!DOCTYPE html>
<html>
<head>
    <title>More Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            font-family: Arial, sans-serif;
            padding:30px;
            background:#f2f2f2;
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
        h2{
            color:#0b3d91;
        }
        .gallery{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(220px,1fr));
            gap:20px;
            margin-top:20px;
        }
        .gallery img{
            width:100%;
            height:220px;
            object-fit:cover;
            border-radius:8px;
        }
        .back-btn{
            margin-top:30px;
        }
        .back-btn a{
            text-decoration:none;
            background:#0b3d91;
            color:white;
            padding:8px 20px;
            border-radius:6px;
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
    <div class="topbar">
    <div><strong>Sandipani School</strong></div>
    <div class="top-links">
        <a href="settings.php">Settings</a>
        <a href="login.php">Logout</a>
    </div>
</div>

<h2>📸 More Gallery Images</h2>

<div class="gallery">
    <img src="image/2023_04_01_09_14_IMG_1566.JPG">
    <img src="image/JSS_8976.JPG">
    <img src="image/IMG_3564.JPG">
    <img src="image/2024_01_05_08_37_IMG_6137.JPG">
    <img src="image/JSS_8640.JPG">
    <img src="image/20220301_110912.jpg">
    <img src="image/2023_09_04_17_49_IMG_3510.JPG">
    <img src="image/IUJX8323.JPG">
    <img src="image/IMG-20260101-WA0178.jpg">
    <img src="image/IMG_1018.JPG">
    <img src="image/JSS_2195.JPG">
    <img src="image/JSS_9109.JPG">
    <img src="image/03.JPG">
    <img src="image/2023_03_07_11_33_IMG_1038.JPG">
    <img src="image/2023_03_07_11_34_IMG_1041.JPG">
    <img src="image/2023_04_01_09_14_IMG_1566.JPG">
    <img src="image/2023_04_01_11_19_IMG_1649.JPG">
    <img src="image/2023_07_05_10_33_IMG_2968.JPG">
</div>

<div class="back-btn">
    <a href="dashboard.php">⬅ Back to Dashboard</a>
    <div class="footer">
    <br>
    © 2026 Sandipani School | All Rights Reserved
    </br>
</div>
</div>

</body>
</html>