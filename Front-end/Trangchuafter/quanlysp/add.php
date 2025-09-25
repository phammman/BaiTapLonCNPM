<?php
        // include('/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/connect.php');
        include __DIR__ . "/../connect.php";
        
        $masp = $_POST['MaSP'] ?? '';
        $tensp = $_POST['TenSP'] ?? '';
        $giaban = $_POST['GiaBan'] ?? '';
        $soluongton = $_POST['SoLuongTon'] ?? '';
        $madm = $_POST['MaDM'] ?? '';
        $masku = $_POST['MaSKU'] ?? '';
        $mota = $_POST['MoTa'] ?? '';
        $giavon = $_POST['GiaVon'] ?? '';
        
        $themsql = "INSERT INTO sanpham (MaSP, TenSP, GiaBan, SoLuongTon, MaDM, MaSKU, MoTa, GiaVon) VALUE ('$masp', '$tensp', '$giaban', '$soluongton', '$madm', '$masku', '$mota', '$giavon')";

        mysqli_query($conn, $themsql);

        // header("location:/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/products.php");
        header("Location: ../products.php");

    ?>