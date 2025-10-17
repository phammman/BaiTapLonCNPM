<?php
session_start();
// Nếu chưa có thông tin, đặt mặc định tránh lỗi warning
if (!isset($tenDangNhap)) $tenDangNhap = "Shop";
if (!isset($sdt)) $sdt = "0123 456 789";

// Nếu người dùng đã đăng nhập, lấy tên khách hàng từ session
$TenKH = isset($_SESSION['TenKH']) ? $_SESSION['TenKH'] : null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($tenDangNhap); ?> - Trang chủ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f9f9f9;
      color: #333;
    }

    /* --- THANH TRÊN --- */
    .top-bar {
      background: #222;
      color: #fff;
      font-size: 14px;
      padding: 5px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .top-bar-left p {
      display: inline-block;
      margin: 0 15px 0 0;
    }

    .top-bar-right a {
      color: #fff;
      text-decoration: none;
      margin-left: 15px;
      transition: 0.2s;
    }

    .top-bar-right a:hover {
      color: #00b894;
    }

    /* --- HEADER CHÍNH --- */
    header {
      background: #fff;
      padding: 15px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #ddd;
    }

    header h1 {
      color: #00b894;
      font-weight: bold;
      cursor: pointer;
    }

    nav a {
      text-decoration: none;
      color: #000;
      margin: 0 10px;
      font-weight: 600;
      transition: 0.2s;
    }

    nav a:hover {
      color: #00b894;
    }

    .icon-cart {
      position: relative;
      cursor: pointer;
    }

    .icon-cart i {
      font-size: 18px;
    }

    .icon-cart span {
      position: absolute;
      top: -5px;
      right: -10px;
      background: #00b894;
      color: white;
      border-radius: 50%;
      font-size: 12px;
      padding: 2px 5px;
    }

    /* Chào người dùng */
    .welcome {
      color: #00b894;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Thanh top -->
  <div class="top-bar">
    <div class="top-bar-left">
      <p>Hotline: <?php echo htmlspecialchars($sdt); ?></p>
      <p>Email: support@<?php echo htmlspecialchars($tenDangNhap); ?>.vn</p>
    </div>
    <div class="top-bar-right">
      <?php if ($TenKH): ?>
        <span class="welcome">Xin chào, <?php echo htmlspecialchars($TenKH); ?></span>
        <a href="dangxuat.php">Đăng Xuất</a>
      <?php else: ?>
        <a href="dangnhap.php">Đăng Nhập</a>
        <a href="dangky.php">Đăng Ký</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Header -->
  <header>
    <h1 onclick="location.href='Trangchu.php'"><?php echo htmlspecialchars($tenDangNhap); ?> Shop</h1>
    <nav>
      <a href="Trangchu.php">TRANG CHỦ</a>
      <a href="gioithieu.php">GIỚI THIỆU</a>
      <a href="sanpham.php">SẢN PHẨM</a>
      <a href="tintuc.php">TIN TỨC</a>
      <a href="lienhe.php">LIÊN HỆ</a>
    </nav>
    <div class="icon-cart" onclick="location.href='giohang.php'">
      <i class="fa-solid fa-cart-shopping"></i>
      <span>0</span>
    </div>
  </header>

</body>
</html>
