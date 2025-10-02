<?php

include 'connect.php';


if (isset($_GET['MaKH'])) {
    $MaKH = intval($_GET['MaKH']);


    $check_sql = "SELECT * FROM KhachHang WHERE MaKH = $MaKH";
    $check = $conn->query($check_sql);

    if ($check->num_rows > 0) {

        $sql = "DELETE FROM KhachHang WHERE MaKH = $MaKH";
        if ($conn->query($sql) === TRUE) {
            header("Location: customers.php?success_delete=1");
            exit();
        } else {
            header("Location: customers.php?error=" . urlencode("Không thể xóa: " . $conn->error));
            exit();
        }
    } else {
        header("Location: customers.php?error=" . urlencode("Khách hàng không tồn tại"));
        exit();
    }
} else {
    header("Location: customers.php?error=" . urlencode("Thiếu tham số MaKH"));
    exit();
}
