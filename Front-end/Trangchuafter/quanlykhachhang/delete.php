<?php
    // //Lấy dữ liệu cần xóa
    // $masp = $_GET['MaSP'];

    // //kết nối 
    // include('connect.php');

    // //câu lệnh sql
    // $xoa_sql = "DELETE FROM sanpham WHERE MaSP=$masp";

    // mysqli_query($conn, $xoa_sql);

    // header("location:orders.php");


    // include('connect.php');
        include __DIR__ . "/../connect.php";

        if (isset($_GET['MaKH'])) {
            $makh = $_GET['MaKH'];
 
            $sql2 = "DELETE FROM khachhang WHERE MaKH = $makh";
            mysqli_query($conn, $sql2);

            // header('Location:products.php'); 
            header("Location: ../customers.php");

            exit;
        }
?>