<?php
include "connect.php";
$sql = "SELECT * FROM donhang";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>📋 Danh sách đơn hàng</h2>
    <a href="themDonHang.php" class="btn-back">➕ Thêm đơn hàng</a>
    <table>
        <tr>
            <th>Mã ĐH</th>
            <th>Ngày Lập</th>
            <th>Trạng Thái</th>
            <th>Mã KH</th>
            <th>Mã NV</th>
            <th>Hành động</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["MaDH"] ?></td>
            <td><?= $row["NgayLap"] ?></td>
            <td><?= $row["TrangThai"] ?></td>
            <td><?= $row["MaKH"] ?></td>
            <td><?= $row["MaNV"] ?></td>
            <td>
                <a class="btn-edit" href="suaDonHang.php?id=<?= $row["MaDH"] ?>">✏️ Sửa</a>
                <a class="btn-delete" href="xoaDonHang.php?id=<?= $row["MaDH"] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">🗑️ Xóa</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
