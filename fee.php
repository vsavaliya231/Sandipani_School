<!DOCTYPE html>
<html>
<head>
    <title>Fee Payment</title>
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

        .card{
            background:white;
            padding:25px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            max-width:500px;
        }

        h2{
            margin-bottom:20px;
        }

        .input-group{
            margin-bottom:15px;
        }

        label{
            display:block;
            margin-bottom:5px;
            font-size:14px;
        }

        input, select{
            width:100%;
            padding:8px;
            border:1px solid #ccc;
            border-radius:4px;
        }

        .btn{
            background:#0b3d91;
            color:white;
            padding:10px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            width:100%;
            margin-top:10px;
        }

        .btn:hover{
            background:#092c6b;
        }

        .success{
            margin-top:15px;
            color:green;
            font-weight:bold;
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
        <a href="settings.php">Settings</a>
        <a href="login.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="sidebar">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="courses.php">📚 Courses</a>
        <a href="fee.php">💳 Fees</a>
        <a href="fees.php">💳 Fee Structure</a>
        <a href="fees1.php">💳 Your Fees</a>
        <a href="result.php">📊 Results</a>
        <a href="announcement.php">📢 Announcements</a>
    </div>

    <div class="main">

        <div class="card">
            <h2>Fee Payment</h2>

            <div class="input-group">
                <label>Student Name</label>
                <input type="text" id="name">
            </div>

            <div class="input-group">
                <label>month or year </label>
                <select id="course">
                    <option> 1 year</option>
                    <option> 6 month</option>
                    
                </select>
            </div>

            <div class="input-group">
                <label>Amount</label>
                <input type="number" id="amount">
            </div>

            <div class="input-group">
                <label>Payment Method</label>
                <select id="method">
                    <option>Credit Card</option>
                    <option>Debit Card</option>
                    <option>UPI</option>
                    <option>Net Banking</option>
                </select>
            </div>

            <button class="btn" onclick="payNow()">Pay Now</button>

            <div id="message" class="success"></div>
        </div>

    </div>

</div>

<script>
    function payNow(){
        var name = document.getElementById("name").value;
        var amount = document.getElementById("amount").value;

        if(name === "" || amount === ""){
            alert("Please fill all details");
        } else {
            document.getElementById("message").innerHTML = 
            "Payment Successful! Receipt generated for " + name;
        }
    }
</script>

</body>
</html>  