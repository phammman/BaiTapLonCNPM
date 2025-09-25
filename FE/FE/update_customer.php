<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql"; // đổi thành tên CSDL của bạn

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$MaKH = $_POST['MaKH']; // nhận từ input hidden trong edit_customer.php
$Ho = $_POST['Ho'];
$Ten = $_POST['Ten'];
$HoTen = $Ho . " " . $Ten;
$DienThoai = $_POST['DienThoai'];
$DiaChi = $_POST['DiaChiCuThe'] . ", " . $_POST['Phuong'] . ", " . $_POST['Quan'] . ", " . $_POST['Tinh'];
$Email = $_POST['Email'];

// Câu lệnh UPDATE (không còn NgaySinh)
$sql = "UPDATE KhachHang 
        SET HoTen = '$HoTen', DienThoai = '$DienThoai', DiaChi = '$DiaChi', Email = '$Email'
        WHERE MaKH = '$MaKH'";

if ($conn->query($sql) === TRUE) {
    // Chuyển hướng kèm thông báo
    header("Location: customers.php?updated=1");
    exit();
} else {
    header("Location: customers.php?error=" . urlencode($conn->error));
    exit();
}

$conn->close();
?>
