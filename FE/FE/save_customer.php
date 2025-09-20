<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql"; // đổi thành tên CSDL của bạn

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Kết nối thất bại: " . $conn->connect_error); }

$Ho = $_POST['Ho'];
$Ten = $_POST['Ten'];
$HoTen = $Ho . " " . $Ten;
$DienThoai = $_POST['DienThoai'];
$DiaChi = $_POST['DiaChiCuThe'] . ", " . $_POST['Phuong'] . ", " . $_POST['Quan'] . ", " . $_POST['Tinh'];
$Email = $_POST['Email'];

$sql = "INSERT INTO KhachHang (HoTen, DienThoai, DiaChi, Email)
        VALUES ('$HoTen', '$DienThoai', '$DiaChi', '$Email')";

if ($conn->query($sql) === TRUE) {
    echo "Thêm khách hàng thành công! <a href='add_customer.php'>Quay lại</a>";
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>
