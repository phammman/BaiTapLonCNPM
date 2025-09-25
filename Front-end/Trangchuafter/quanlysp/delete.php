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

        if (isset($_GET['MaSP'])) {
            $masp = $_GET['MaSP'];

            $sql1 = "DELETE FROM chitietdonhang WHERE MaSP = $masp";
            mysqli_query($conn, $sql1);

            $sql2 = "DELETE FROM sanpham WHERE MaSP = $masp";
            mysqli_query($conn, $sql2);

            // header('Location:products.php'); 
            header("Location: ../products.php");

            exit;
        }
?>