<?php
include "connect.php";
$id = $_GET["id"];
$result = $conn->query("SELECT * FROM donhang WHERE MaDH='$id'");
$order = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NgayLap = $_POST["NgayLap"];
    $TrangThai = $_POST["TrangThai"];
    $MaKH = $_POST["MaKH"];
    $MaNV = $_POST["MaNV"];

    $sql = "UPDATE donhang SET NgayLap='$NgayLap', TrangThai='$TrangThai', MaKH='$MaKH', MaNV='$MaNV' WHERE MaDH='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: xemDonHang.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa đơn hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>✏️ Sửa đơn hàng <?= $order["MaDH"] ?></h2>
    <form class="form-group" method="post">
        <label>Ngày Lập:</label><input type="date" name="NgayLap" value="<?= $order["NgayLap"] ?>"><br>
        <label>Trạng Thái:</label><input type="text" name="TrangThai" value="<?= $order["TrangThai"] ?>"><br>
        <label>Mã KH:</label><input type="text" name="MaKH" value="<?= $order["MaKH"] ?>"><br>
        <label>Mã NV:</label><input type="text" name="MaNV" value="<?= $order["MaNV"] ?>"><br>
        <button type="submit">Cập nhật</button>
        <a href="xemDonHang.php" class="btn-back">Hủy</a>
    </form>
</div>
</body>
</html>
