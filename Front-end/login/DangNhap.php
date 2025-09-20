<?php
session_start();
include "../Trangchuafter/connect.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenDangNhap = $_POST["tenDangNhap"];
    $matKhau = $_POST["matKhau"];
    $quyenHan = $_POST["quyenHan"];

    // Lấy user từ DB
    $stmt = $conn->prepare("SELECT * FROM dangnhap WHERE tenDangNhap=? AND quyenHan=?");
    $stmt->bind_param("ss", $tenDangNhap, $quyenHan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // So sánh mật khẩu plain text (m đang lưu thường, chưa mã hóa)
        if ($matKhau === $user["matKhau"]) {
            $_SESSION["tenDangNhap"] = $user["tenDangNhap"];
            $_SESSION["quyenHan"] = $user["quyenHan"];

            header("Location: ../Trangchuafter/manuadmin.php");
            exit();
        } else {
            echo "<script>alert('Sai mật khẩu!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Tài khoản không tồn tại hoặc sai quyền hạn!'); window.history.back();</script>";
    }
}
?>
