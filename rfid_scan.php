<?php
error_reporting(0);
include 'config.php';

date_default_timezone_set('Asia/Manila'); // 🔥 IMPORTANT

header('Content-Type: application/json');

$rfid = isset($_POST['rfid']) ? trim($_POST['rfid']) : '';

if(empty($rfid)){
    echo json_encode(["status"=>"invalid"]);
    exit();
}

// 🔥 GET USERS
$stmt = $conn->prepare("SELECT id, full_name, rfid_uid, photo FROM employees");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$found = null;

foreach($users as $u){

    $db_rfid = preg_replace('/[^0-9]/', '', $u['rfid_uid']);
    $scan_rfid = preg_replace('/[^0-9]/', '', $rfid);

    for($i=0; $i < strlen($scan_rfid)-3; $i++){
        $part = substr($scan_rfid, $i, 4);

        if(strpos($db_rfid, $part) !== false){
            $found = $u;
            break 2;
        }
    }
}

if(!$found){
    echo json_encode([
        "status"=>"invalid",
        "photo"=>"assets/images/default.png"
    ]);
    exit();
}

$emp_id = $found['id'];
$name   = $found['full_name'];
$photo  = !empty($found['photo']) ? $found['photo'] : "default.png";

$today = date('Y-m-d');
$time_now = date('H:i:s'); // 🔥 CURRENT TIME

// 🔥 CHECK TODAY RECORD
$check = $conn->prepare("SELECT * FROM attendance WHERE employee_id=? AND att_date=?");
$check->execute([$emp_id, $today]);
$existing = $check->fetch(PDO::FETCH_ASSOC);

if(!$existing){

    // ✅ TIME IN
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

}else{

    if(empty($existing['time_out'])){

        // ✅ TIME OUT
        $update = $conn->prepare("
        UPDATE attendance SET time_out=? WHERE id=?
        ");
        $update->execute([$time_now, $existing['id']]);

        echo json_encode([
            "status"=>"time_out",
            "name"=>$name,
            "photo"=>"assets/images/".$photo,
            "time"=>$time_now
        ]);
        exit();

    }else{

        // ✅ ALREADY RECORDED
        echo json_encode([
            "status"=>"already",
            "name"=>$name,
            "photo"=>"assets/images/".$photo
        ]);
        exit();
    }
}
?>