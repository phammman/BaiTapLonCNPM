<?php
header("Content-Type: application/json; charset=UTF-8");
include __DIR__ . "/../connect.php"; // chỉnh đúng đường dẫn file connect.php

$q = $_GET['q'] ?? '';
$q = trim($q);

$data = [];

if ($q !== '') {
    $q = mysqli_real_escape_string($conn, $q);
    $sql = "SELECT MaSP, TenSP, GiaBan FROM sanpham 
        WHERE TenSP LIKE '%$q%' OR MaSP LIKE '%$q%'  
        LIMIT 10";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>
