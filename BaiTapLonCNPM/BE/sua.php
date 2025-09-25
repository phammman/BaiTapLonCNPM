<?php
include 'db.php';
$MaKH = $_GET['MaKH'];
$result = $conn->query("SELECT * FROM KhachHang WHERE MaKH=$MaKH");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa khách hàng</title>
</head>
<body>
  <h2>Sửa khách hàng</h2>
  <form method="POST" action="xuly_sua.php">
    <input type="hidden" name="MaKH" value="<?php echo $row['MaKH']; ?>">
    <input type="text" name="HoTen" value="<?php echo $row['HoTen']; ?>" required><br><br>
    <input type="text" name="DienThoai" value="<?php echo $row['DienThoai']; ?>"><br><br>
    <input type="text" name="DiaChi" value="<?php echo $row['DiaChi']; ?>"><br><br>
    <input type="email" name="Email" value="<?php echo $row['Email']; ?>"><br><br>
    <button type="submit">Cập nhật</button>
  </form>
  <p><a href="index.php">Quay lại danh sách</a></p>
</body>
</html>
