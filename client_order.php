<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Place Order</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background: #f1f5f9;
    font-family: 'Segoe UI', sans-serif;
    min-height:100vh;
    margin:0;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* CENTER */
.container-center{
    width:100%;
    display:flex;
    justify-content:center;
}

/* CARD */
.order-card{
    background: #ffffff;
    padding:35px;
    border-radius:16px;
    width:100%;
    max-width:440px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    border:1px solid #e5e7eb;
}

/* TITLE */
.order-card h3{
    text-align:center;
    margin-bottom:25px;
    font-weight:600;
    color:#111827;
}

/* LABEL */
label{
    font-size:14px;
    font-weight:500;
    color:#374151;
}

/* INPUT */
.form-control{
    border-radius:10px;
    padding:10px;
    border:1px solid #d1d5db;
    transition:0.2s;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 2px rgba(37,99,235,0.1);
}

/* BUTTON */
.btn-submit{
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color:white;
    border:none;
    border-radius:10px;
    padding:12px;
    font-weight:500;
    transition:0.3s;
}

.btn-submit:hover{
    transform:translateY(-1px);
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
}

/* SUCCESS */
.alert{
    border-radius:10px;
    font-size:14px;
}

</style>
</head>

<body>

<div class="container-center">
<div class="order-card">

<h3>Place Your Order</h3>

<form method="POST">

<div class="mb-3">
<label>Name</label>
<input type="text" name="client_name" class="form-control" required>
</div>

<div class="mb-3">
<label>Contact Number</label>
<input type="text" name="contact" maxlength="11" class="form-control" required>
</div>

<div class="mb-3">
<label>Email Address</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Order Details</label>
<select name="order_details" id="product" class="form-control" required>
<option value="">Select Product</option>

<?php
$stmt = $conn->query("
SELECT item_name, selling_price 
FROM inventory_items 
WHERE category='Finished Good' AND status='active'
");

foreach($stmt as $row){
?>
<option 
value="<?= $row['item_name'] ?>"
data-price="<?= $row['selling_price'] ?>"
>
<?= $row['item_name'] ?>
</option>
<?php } ?>

</select>
</div>

<div class="mb-3">
<label>Quantity</label>
<input type="number" name="quantity" class="form-control" required>
</div>

<button type="submit" name="submit_order" class="btn btn-submit w-100">
Submit Order
</button>

</form>

<?php
if(isset($_POST['submit_order'])){
    $stmt = $conn->prepare("
    INSERT INTO orders (client_name, contact, email, order_details, quantity)
    VALUES (?,?,?,?,?)
    ");
    
    $stmt->execute([
        $_POST['client_name'],
        $_POST['contact'],
        $_POST['email'],
        $_POST['order_details'],
        $_POST['quantity']
    ]);

    echo "<div class='alert alert-success mt-3 text-center'>
            ✅ Order submitted successfully!
          </div>";
}
?>

</div>
</div>

</body>
</html>