<!DOCTYPE html>
<html>
<head>
    <title>Weekly Test - Sandipani School</title>
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
}

/* Container */
.container{
    width:95%;
    max-width:900px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:8px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h1{
    text-align:center;
    color:#0b3d91;
    margin-bottom:20px;
}

select{
    padding:8px;
    font-size:15px;
    margin-bottom:20px;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#184190;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border:1px solid #ddd;
}

tr:nth-child(even){
    background:#f2f2f2;
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

<div class="header">
    <h2>Sandipani School</h2>
    <div>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="weeklytest.php">📝 Weekly Test</a>
        <a href="fee.php">💳 Fees</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>
</div>

<div class="container">

<h1 id="title">Weekly Test Schedule - Std 1</h1>

<center>
<select onchange="changeClass(this.value)">
    <option value="1">Std 1</option>
    <option value="2">Std 2</option>
    <option value="3">Std 3</option>
    <option value="4">Std 4</option>
    <option value="5">Std 5</option>
    <option value="6">Std 6</option>
    <option value="7">Std 7</option>
    <option value="8">Std 8</option>
    <option value="9">Std 9</option>
    <option value="10">Std 10</option>
    <option value="11">Std 11</option>
    <option value="12">Std 12</option>
</select>
</center>

<table>
<tr>
    <th>Date</th>
    <th>Day</th>
    <th>Subject</th>
</tr>

<tr><td>19/07/2025</td><td>Saturday</td><td>Mathematics</td></tr>
<tr><td>26/07/2025</td><td>Saturday</td><td>English</td></tr>
<tr><td>02/08/2025</td><td>Saturday</td><td>Gujarati</td></tr>
<tr><td>23/08/2025</td><td>Saturday</td><td>Science</td></tr>
<tr><td>30/08/2025</td><td>Saturday</td><td>English</td></tr>
<tr><td>08/09/2025</td><td>Monday</td><td>General Knowledge</td></tr>
<tr><td>13/09/2025</td><td>Saturday</td><td>Gujarati</td></tr>
<tr><td>20/09/2025</td><td>Saturday</td><td>Mathematics</td></tr>
<tr><td>27/09/2025</td><td>Saturday</td><td>English</td></tr>

</table>

</div>

<div class="footer">
    <br>
© 2026 Sandipani School | All Rights Reserved
</br>
</div>

<script>
function changeClass(std){
    document.getElementById("title").innerHTML = 
    "Weekly Test Schedule - Std " + std;
}
</script>

</body>
</html>