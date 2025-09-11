<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $DienThoai = $_POST['DienThoai'];
    $DiaChi = $_POST['DiaChi'];
    $Email = $_POST['Email'];

    $sql = "INSERT INTO KhachHang (HoTen, DienThoai, DiaChi, Email) 
            VALUES ('$HoTen', '$DienThoai', '$DiaChi', '$Email')";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
