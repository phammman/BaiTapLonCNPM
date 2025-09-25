<?php
      // include('connect.php');
      include __DIR__ . "/../connect.php";

        
        $makh = $_POST['MaKH'] ?? '';
        $hoten = $_POST['HoTen'] ?? '';
        $dienthoai = $_POST['DienThoai'] ?? '';
        $diachi = $_POST['DiaChi'] ?? '';
        $email = $_POST['Email'] ?? '';

    $capnhat_sql = "UPDATE khachhang SET HoTen = '$hoten', DienThoai = '$dienthoai', DiaChi = '$diachi', Email = '$email' WHERE MaKH=$makh";


    mysqli_query($conn, $capnhat_sql);

    // header("location:products.php");
    header("Location: ../customers.php");

?>