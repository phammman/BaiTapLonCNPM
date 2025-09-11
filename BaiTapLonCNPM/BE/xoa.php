<?php
$MaKH = $_GET['MaKH'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xóa khách hàng</title>
</head>
<body>
  <h2>Bạn có chắc muốn xóa khách hàng có mã <?php echo $MaKH; ?>?</h2>
  <form method="POST" action="xuly_xoa.php">
    <input type="hidden" name="MaKH" value="<?php echo $MaKH; ?>">
    <button type="submit">Xóa</button>
    <a href="index.php">Hủy</a>
  </form>
</body>
</html>
