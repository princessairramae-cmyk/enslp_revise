<?php
error_reporting(0);
include 'config.php';

date_default_timezone_set('Asia/Manila');

header('Content-Type: application/json');

// 🔥 GET RFID INPUT
$rfid = isset($_POST['rfid']) ? trim($_POST['rfid']) : '';

// OPTIONAL: remove non-numeric (kung may weird chars scanner mo)
$rfid = preg_replace('/[^0-9]/', '', $rfid);

if(empty($rfid)){
    echo json_encode([
        "status"=>"invalid",
        "msg"=>"No RFID detected",
        "photo"=>"assets/images/default.png"
    ]);
    exit();
}

// 🔥 EXACT MATCH QUERY (FIXED NA ❗)
$stmt = $conn->prepare("
    SELECT id, full_name, rfid_uid, photo 
    FROM employees 
    WHERE rfid_uid = ?
");
$stmt->execute([$rfid]);
$found = $stmt->fetch(PDO::FETCH_ASSOC);

// ❌ PAG WALANG MATCH
if(!$found){
    echo json_encode([
        "status"=>"invalid",
        "msg"=>"Unknown Card",
        "photo"=>"assets/images/default.png"
    ]);
    exit();
}

$emp_id = $found['id'];
$name   = $found['full_name'];
$photo  = !empty($found['photo']) ? $found['photo'] : "default.png";

$today = date('Y-m-d');
$time_now = date('H:i:s');

// 🔥 CHECK TODAY ATTENDANCE
$check = $conn->prepare("
    SELECT * FROM attendance 
    WHERE employee_id=? AND att_date=?
");
$check->execute([$emp_id, $today]);
$existing = $check->fetch(PDO::FETCH_ASSOC);

// =============================
// ✅ TIME IN
// =============================
if(!$existing){

    $insert = $conn->prepare("
        INSERT INTO attendance (employee_id, att_date, time_in, status)
        VALUES (?,?,?,?)
    ");
    $insert->execute([$emp_id, $today, $time_now, "Present"]);

    echo json_encode([
        "status"=>"time_in",
        "name"=>$name,
        "photo"=>"assets/images/".$photo,
        "time"=>$time_now
    ]);
    exit();
}

// =============================
// ⏰ TIME OUT
// =============================
if(empty($existing['time_out'])){

    $update = $conn->prepare("
        UPDATE attendance 
        SET time_out=? 
        WHERE id=?
    ");
    $update->execute([$time_now, $existing['id']]);

    echo json_encode([
        "status"=>"time_out",
        "name"=>$name,
        "photo"=>"assets/images/".$photo,
        "time"=>$time_now
    ]);
    exit();
}

// =============================
// ⚠️ ALREADY RECORDED
// =============================
echo json_encode([
    "status"=>"already",
    "name"=>$name,
    "photo"=>"assets/images/".$photo
]);
exit();
?>