<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

include __DIR__ . "/../connect.php";

$MaND = $_SESSION['MaND'] ?? null;
$q = $_GET['q'] ?? '';
$q = trim($q);
$data = [];

if ($MaND && $q !== '') {
    $q = mysqli_real_escape_string($conn, $q);

    $sql = "
        SELECT MaKH, HoTen, Email, DienThoai
        FROM khachhang
        WHERE MaND = '$MaND'
          AND (
              HoTen LIKE '%$q%' 
              OR Email LIKE '%$q%' 
              OR DienThoai LIKE '%$q%'
          )
        LIMIT 10
    ";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
