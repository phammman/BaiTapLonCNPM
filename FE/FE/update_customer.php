<?php
include 'db_connect.php';


$MaKH = $_POST['MaKH']; 
$Ho = $_POST['Ho'];
$Ten = $_POST['Ten'];
$HoTen = $Ho . " " . $Ten;
$DienThoai = $_POST['DienThoai'];
$DiaChi = $_POST['DiaChiCuThe'] . ", " . $_POST['Phuong'] . ", " . $_POST['Quan'] . ", " . $_POST['Tinh'];
$Email = $_POST['Email'];


$sql = "UPDATE KhachHang 
        SET HoTen = '$HoTen', DienThoai = '$DienThoai', DiaChi = '$DiaChi', Email = '$Email'
        WHERE MaKH = '$MaKH'";

if ($conn->query($sql) === TRUE) {

    header("Location: customers.php?updated=1");
    exit();
} else {
    header("Location: customers.php?error=" . urlencode($conn->error));
    exit();
}

$conn->close();
?>
