<?php
session_start();
include "../connect.php";

// Lấy MaND
$tenDangNhap = "Khách";
$sdt = "Chưa có";
$mand = 0;

if (isset($_SESSION['MaND'])) {
    $mand = (int)$_SESSION['MaND'];

    // Lấy thông tin người dùng
    $sql = "SELECT TenDangNhap, SDT FROM nguoidung WHERE MaND = $mand";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tenDangNhap = $row['TenDangNhap'];
        $sdt = $row['SDT'];
    }
}

// Lấy danh sách sản phẩm bán chạy nhất của người dùng này
$sql_hot = "
SELECT sp.*, SUM(ct.SoLuong) AS TongBan
FROM sanpham sp
JOIN chitietdonhang ct ON sp.MaSP = ct.MaSP
JOIN donhang dh ON ct.MaDH = dh.MaDH
WHERE sp.MaND = $mand
GROUP BY sp.MaSP
ORDER BY TongBan DESC
LIMIT 8
";
$result_hot = $conn->query($sql_hot);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YOUR SHOP - Trang chủ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f9f9f9;
      color: #333;
    }

    /* Top bar */
    .top-bar {
      background: #222;
      color: #fff;
      font-size: 14px;
      padding: 5px 40px;
      display: flex;
      justify-content: space-between;
    }

    /* Header */
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

    /* Banner */
    .banner {
      background: url('https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=1200') no-repeat center center/cover;
      height: 350px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
    }

    .banner h2 {
      background: rgba(0, 0, 0, 0.6);
      padding: 20px 40px;
      border-radius: 8px;
      font-size: 32px;
    }

    /* Section */
    .section {
      padding: 40px 60px;
      text-align: center;
    }

    .section h2 {
      color: #00b894;
      margin-bottom: 20px;
      font-size: 26px;
    }

    /* Product grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 20px;
    }

    .product-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      padding: 15px;
      transition: transform 0.2s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 6px;
    }

    .product-card h3 {
      margin: 10px 0 5px;
      font-size: 18px;
    }

    .product-card p {
      color: #777;
      font-size: 14px;
      margin: 5px 0;
    }

    .product-card .price {
      color: #00b894;
      font-weight: bold;
      font-size: 16px;
      margin-bottom: 10px;
    }

    .product-card button {
      background: #00b894;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.3s;
    }

    .product-card button:hover {
      background: #019670;
    }

    /* Footer */
    footer {
      background: #222;
      color: #ccc;
      text-align: center;
      padding: 20px 0;
      font-size: 14px;
      margin-top: 40px;
    }

    footer a {
      color: #00b894;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>

 <?php
if (isset($_SESSION['TenKH'])) {
    include "menuafter.php"; // menu sau khi đăng nhập
} else {
    include "menu.php"; // menu mặc định khi chưa đăng nhập
}
?>


  <!-- Banner -->
  <section class="banner">
    <h2>Chào mừng đến với <?php echo htmlspecialchars($tenDangNhap); ?> Shop<br>Mua sắm thời trang & phụ kiện cực chất!</h2>
  </section>

  <!-- Sản phẩm nổi bật -->
  <section class="section">
    <h2>Sản phẩm bán chạy nhất</h2>
    <div class="product-grid">
      <?php if ($result_hot && $result_hot->num_rows > 0): ?>
        <?php while ($sp = $result_hot->fetch_assoc()): ?>
          <div class="product-card">
            <img src="<?php echo !empty($sp['img']) ? '../' . htmlspecialchars($sp['img']) : 'https://via.placeholder.com/200'; ?>" alt="<?php echo htmlspecialchars($sp['TenSP']); ?>">
            <h3><?php echo htmlspecialchars($sp['TenSP']); ?></h3>
            <div class="price"><?php echo number_format($sp['GiaBan']); ?>đ</div>
            <button><i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ</button>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Chưa có sản phẩm bán chạy nào.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    © 2025 YOUR SHOP — Thiết kế bởi <a href="#">Nhóm LuffyDev</a>
  </footer>

</body>
</html>
