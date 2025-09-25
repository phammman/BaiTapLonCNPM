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
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}
.container {
    width: 450px;
    margin: 60px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.container h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 22px;
    color: #333;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #444;
}

.form-group input {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: all 0.3s ease;
}

.form-group input:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 6px rgba(76, 175, 80, 0.3);
}

button[type="submit"] {
    width: 100%;
    padding: 12px;
    border: none;
    background: #4CAF50;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

button[type="submit"]:hover {
    background: #45a049;
}

.btn-back {
    display: inline-block;
    text-align: center;
    margin-top: 12px;
    width: 100%;
    padding: 10px;
    background: #f44336;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
    font-weight: 600;
}

.btn-back:hover {
    background: #d32f2f;
}

</style>
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
