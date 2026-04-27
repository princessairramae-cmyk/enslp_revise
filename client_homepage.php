<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EnSLP Client Portal</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter', sans-serif;
}

body{
    background:#ffffff;
    color:#1f2937;
}

/* NAVBAR */
.navbar{
    background:#0a1f44;
    padding:18px 60px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar h1{
    color:white;
    font-size:18px;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin-left:25px;
    font-size:14px;
}

/* HERO */
.hero{
    padding:100px 20px;
    text-align:center;
    background:linear-gradient(to bottom,#eef2ff,#e0e7ff);
}

.hero h2{
    font-size:36px;
    color:#0a1f44;
    margin-bottom:10px;
}

.hero p{
    max-width:650px;
    margin:auto;
    color:#475569;
    line-height:1.6;
}

/* BUTTON */
.btn{
    display:inline-block;
    margin-top:30px;
    padding:12px 30px;
    background:#0d3b8c;
    color:white;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
}

.btn:hover{
    background:#0a2e6e;
}

/* SECTION */
section{
    padding:70px 20px;
    max-width:1000px;
    margin:auto;
}

/* ABOUT */
.about p{
    text-align:center;
    color:#475569;
    line-height:1.8;
}

/* STEPS */
.steps{
    display:flex;
    gap:25px;
    flex-wrap:wrap;
    justify-content:center;
    margin-top:30px;
}

.step{
    width:280px;
    background:#f8fafc;
    padding:25px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.step h4{
    color:#0d3b8c;
    margin-bottom:10px;
}

/* CTA */
.cta{
    text-align:center;
    background:#0d3b8c;
    color:white;
    padding:60px 20px;
}

.cta h3{
    margin-bottom:15px;
}

.cta .btn{
    background:white;
    color:#0d3b8c;
}

/* FOOTER */
footer{
    text-align:center;
    padding:20px;
    background:#0a1f44;
    color:white;
    font-size:13px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h1>EnSLP Inc.</h1>
    <div>
        <a href="#">Home</a>
        <a href="#about">About</a>
        <a href="#process">How to Order</a>
        <a href="homepage.php">Admin</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h2>Client Ordering Portal</h2>
    <p>
        Welcome to the EnSLP Client Portal. This platform allows you to submit orders 
        for Flexible Flat Cable (FFC) products in a fast, organized, and efficient manner.
    </p>

    <a href="client_order.php" class="btn">Place an Order</a>
</div>

<!-- ABOUT -->
<section id="about" class="about">
    <h3 style="text-align:center;margin-bottom:25px;">About the System</h3>
    <p>
        The EnSLP Ordering System is designed to streamline the ordering process for clients. 
        It ensures accurate data submission, faster processing, and improved communication 
        between clients and the manufacturing team.
    </p>
</section>

<!-- PROCESS -->
<section id="process">
    <h3 style="text-align:center;margin-bottom:25px;">How to Place an Order</h3>

    <div class="steps">
        <div class="step">
            <h4>1. Fill Out Form</h4>
            <p>Provide your name, contact details, and email address.</p>
        </div>

        <div class="step">
            <h4>2. Select Product</h4>
            <p>Choose your desired product and specify the quantity.</p>
        </div>

        <div class="step">
            <h4>3. Submit Order</h4>
            <p>Review your details and submit your order request.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<div class="cta">
    <h3>Ready to place your order?</h3>
    <a href="client_order.php" class="btn">Proceed to Order Form</a>
</div>

<!-- FOOTER -->
<footer>
© 2026 EnSLP Inc. || Lot 1 Blk 1 Science Park III, Sto. Tomas City Batangas, Philippines
</footer>

</body>
</html>