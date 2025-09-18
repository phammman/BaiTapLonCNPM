<?php
      include('connect.php');
        
        $masp = $_POST['MaSP'] ?? '';
        $tensp = $_POST['TenSP'] ?? '';
        $giaban = $_POST['GiaBan'] ?? '';
        $soluongton = $_POST['SoLuongTon'] ?? '';
        $madm = $_POST['MaDM'] ?? '';
        $masku = $_POST['MaSKU'] ?? '';
        $mota = $_POST['MoTa'] ?? '';
        $giavon = $_POST['GiaVon'] ?? '';

    $capnhat_sql = "UPDATE sanpham SET TenSP = '$tensp', GiaBan = '$giaban', SoLuongTon = '$soluongton', MaDM = '$madm', MaSKU = '$masku', MoTa = '$mota', GiaVon = '$giavon' WHERE MaSP=$masp";


    mysqli_query($conn, $capnhat_sql);

    header("location:products.php");
?>