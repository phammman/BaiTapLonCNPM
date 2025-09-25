<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách khách hàng</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f2f2f2; }
    a.btn { padding: 5px 10px; background: #007bff; color: #fff; text-decoration: none; border-radius: 4px; }
    a.btn:hover { background: #0056b3; }
  </style>
</head>
<body>
  <h2>Danh sách khách hàng</h2>
  <a href="them.php" class="btn">+ Thêm khách hàng</a>
  <table>
    <tr>
      <th>Mã KH</th>
      <th>Họ tên</th>
      <th>Điện thoại</th>
      <th>Địa chỉ</th>
      <th>Email</th>
      <th>Hành động</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM KhachHang");
    while ($row = $result->fetch_assoc()) {
      echo "<tr>
              <td>{$row['MaKH']}</td>
              <td>{$row['HoTen']}</td>
              <td>{$row['DienThoai']}</td>
              <td>{$row['DiaChi']}</td>
              <td>{$row['Email']}</td>
              <td>
                <a href='sua.php?MaKH={$row['MaKH']}'>Sửa</a> | 
                <a href='xoa.php?MaKH={$row['MaKH']}'>Xóa</a>
              </td>
            </tr>";
    }
    ?>
  </table>
</body>
</html>
