<?php
$conn = new mysqli("localhost", "root", "", "chuyendedinhhuongcnpm");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");

$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

$sql = "SELECT MaSP, TenSP, GiaBan FROM sanpham 
        WHERE TenSP LIKE '%$q%' OR MaSP LIKE '%$q%'
        LIMIT 10";

$result = $conn->query($sql);
$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);
$conn->close();
