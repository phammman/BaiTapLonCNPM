<?php
        // include('/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/connect.php');
        include __DIR__ . "/../connect.php";
        
        $makh = $_POST['MaKH'] ?? '';
        $hoten = $_POST['HoTen'] ?? '';
        $dienthoai = $_POST['DienThoai'] ?? '';
        $diachi = $_POST['DiaChi'] ?? '';
        $email = $_POST['Email'] ?? '';
        
        $themsql = "INSERT INTO khachhang (MaKH, HoTen, DienThoai, DiaChi, Email) VALUE ('$makh', '$hoten', '$dienthoai', '$diachi', '$email')";

        mysqli_query($conn, $themsql);

        // header("location:/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/products.php");
        header("Location: ../customers.php");

    ?>