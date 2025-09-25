<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm khách hàng</title>
</head>
<body>
  <h2>Thêm khách hàng</h2>
  <form method="POST" action="xuly_them.php">
    <input type="text" name="HoTen" placeholder="Họ tên" required><br><br>
    <input type="text" name="DienThoai" placeholder="Điện thoại"><br><br>
    <input type="text" name="DiaChi" placeholder="Địa chỉ"><br><br>
    <input type="email" name="Email" placeholder="Email"><br><br>
    <button type="submit">Thêm</button>
  </form>
  <p><a href="index.php">Quay lại danh sách</a></p>
</body>
</html>
