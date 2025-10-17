<?php
session_start();
include __DIR__ . "/../connect.php"; // Kết nối CSDL

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['MaND'])) {
    header("Location: ../dangnhap.php");
    exit();
}

$MaND = $_SESSION['MaND']; // Lấy mã người dùng đang đăng nhập

// Lấy dữ liệu từ form
$HoTen = $_POST['HoTen'] ?? '';
$Email = $_POST['Email'] ?? '';
$DiaChi = $_POST['DiaChi'] ?? '';
$DienThoai = $_POST['DienThoai'] ?? '';

// Kiểm tra dữ liệu
if (empty($HoTen) || empty($Email) || empty($DiaChi) || empty($DienThoai)) {
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin khách hàng!'); history.back();</script>";
    exit();
}

// Thêm khách hàng mới vào bảng `khachhang`
$sql = "INSERT INTO khachhang (HoTen, Email, DiaChi, DienThoai, MaND)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $HoTen, $Email, $DiaChi, $DienThoai, $MaND);

if ($stmt->execute()) {
    header("Location: ../customers.php");
    exit();
} else {
    echo "<script>alert('Lỗi khi thêm khách hàng: " . $conn->error . "'); history.back();</script>";
}

$stmt->close();
$conn->close();
?>
