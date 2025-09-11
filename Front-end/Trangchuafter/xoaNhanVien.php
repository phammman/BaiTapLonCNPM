<?php
    include("connect.php");
    if (isset($_GET["MaNV"])){
        $MaNV = $_GET["MaNV"];
    }
    $sql = "DELETE FROM nhanvien WHERE MaNV = $MaNV";
    $result = mysqli_query($conn, $sql);
    header("Location: quanLyNhanVien.php");
?>