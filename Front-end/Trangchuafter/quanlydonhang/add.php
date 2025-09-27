<?php
        // include('/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/connect.php');
        include __DIR__ . "/../connect.php";

        $ngaylap = $_POST['NgayLap'] ?? '';
        // $trangthai = $_POST['TrangThai'] ?? '';
        $thanhtien = $_POST['ThanhTien'] ?? '';
        $tenkh = $_POST['TenKH'] ?? '';
        $madh = $_POST['MaDH'] ?? '';
        $maskh = $_POST['MaKH'] ?? '';


        $checkKH = mysqli_query($conn, "SELECT * FROM khachhang WHERE MaKH = '$maskh'");
        if(mysqli_num_rows($checkKH) == 0) {
            die("Khách hàng không tồn tại, vui lòng thêm khách hàng trước!");
        }

        $sql_nv = "SELECT MaNV, HoTen FROM nhanvien";
        $result_nv = mysqli_query($conn, $sql_nv);
        $themsql = "INSERT INTO donhang (NgayLap, ThanhTien, TenKH, MaDH, MaKH) VALUE ('$ngaylap', '$thanhtien', '$tenkh', '$madh', '$maskh')";

        mysqli_query($conn, $themsql);

        // header("location:/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/products.php");
        header("Location: ../orders.php");


        // // Truy vấn lấy tất cả đơn hàng từ bảng donhang
        // $sql = "SELECT MaNV, HoTen, ChucVu
        //         FROM nhanvien
        //         ORDER BY MaNV ASC";

        // $result = $conn->query($sql);

    ?>