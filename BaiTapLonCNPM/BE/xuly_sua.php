<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaKH = $_POST['MaKH'];
    $HoTen = $_POST['HoTen'];
    $DienThoai = $_POST['DienThoai'];
    $DiaChi = $_POST['DiaChi'];
    $Email = $_POST['Email'];

    $sql = "UPDATE KhachHang 
            SET HoTen='$HoTen', DienThoai='$DienThoai', DiaChi='$DiaChi', Email='$Email' 
            WHERE MaKH=$MaKH";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
