<?php
include("../Trangchuafter/connect.php");
function checkLogin($conn, $TenDangNhap, $MatKhau)
{
    $sql = "SELECT * FROM nguoidung WHERE TenDangNhap = ? AND MatKhau = ?";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);

    // Kiểm tra câu lệnh đã sẵn sàng chưa
    if ($stmt) {
        $stmt->bind_param("ss", $TenDangNhap, $MatKhau);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Lấy thông tin người dùng
            $nguoidung = $result->fetch_assoc();
            
            return true;
        } else {
            return false; // Nếu không có tài khoản
        }
    }
    return false;
}
?>