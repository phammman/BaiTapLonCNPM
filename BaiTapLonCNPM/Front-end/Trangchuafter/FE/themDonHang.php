<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NgayLap = $_POST["NgayLap"];
    $TrangThai = $_POST["TrangThai"];
    $MaKH = $_POST["MaKH"];
    $MaNV = $_POST["MaNV"];

    // KHÔNG insert MaDH vì nó AUTO_INCREMENT
    $sql = "INSERT INTO donhang (NgayLap, TrangThai, MaKH, MaNV) 
            VALUES ('$NgayLap', '$TrangThai', '$MaKH', '$MaNV')";

    if ($conn->query($sql) === TRUE) {
        header("Location: orders.php");
        exit();
    } else {
        echo "Lỗi SQL: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm đơn hàng</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            width: 400px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #444;
        }
        .form-group input {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: 0.3s;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0,123,255,0.5);
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 10px;
            padding: 8px;
            background: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-back:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>➕ Thêm đơn hàng</h2>
    <form class="form-group" method="post">
        <label>Ngày Lập:</label><input type="date" name="NgayLap" required><br>
        <label>Trạng Thái:</label><input type="text" name="TrangThai" required><br>
        <label>Mã KH:</label><input type="text" name="MaKH" required><br>
        <label>Mã NV:</label><input type="text" name="MaNV" required><br>
        <button type="submit">Thêm mới</button>
        <a href="orders.php" class="btn-back">Hủy</a>
    </form>
</div>
</body>
</html>
