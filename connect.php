<?php

$conn = mysqli_connect("localhost", "root", "", "paymentdb"); 
function getData($query) {
    global $conn;
    $results = []; 
    $myquery = mysqli_query($conn, $query); 
    while($result = mysqli_fetch_assoc($myquery)) {
        $results[] = $result;
    }
    return $results;
}

function insertData($data, $id_pesanan) {
    global $conn;
    $vnama   = $data['nama']; 
    $vemail  = $data['email']; 
    $vharga  = 10000;
    $status  = 1;
    mysqli_query($conn, "INSERT INTO client VALUES(NULL,'$vnama', '$vemail', '$vharga','$id_pesanan', '$status', '', '', '')");
}

function updateStatus($tid, $tst, $oid, $status) {
    global $conn;
    mysqli_query($conn, "UPDATE client SET transaction_id='$tid', transaction_status='$tst', oid='$oid', status='$status' WHERE id_pesanan='$oid'");
}



?>