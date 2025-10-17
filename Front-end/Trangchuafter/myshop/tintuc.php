<?php
session_start();
include "../connect.php";

// Ưu tiên lấy MaND từ session (nếu đã đăng nhập)
$tenDangNhap = "Khách";
$sdt = "Chưa có";
$mand = 0;

if (isset($_SESSION['MaND'])) {
    $mand = (int)$_SESSION['MaND'];

    // Lấy thông tin người dùng từ bảng nguoidung
    $sql = "SELECT TenDangNhap, SDT FROM nguoidung WHERE MaND = $mand";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tenDangNhap = $row['TenDangNhap'];
        $sdt = $row['SDT'];
    }
}

// Lấy danh sách sản phẩm của người dùng này
$sql_sp = "SELECT MaSP, TenSP, MoTa, GiaBan, img FROM sanpham WHERE MaND = $mand ORDER BY MaSP DESC LIMIT 6";
$result_sp = $conn->query($sql_sp);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tin tức - YOUR SHOP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f9f9f9;
      color: #333;
    }

    .banner {
      background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200') no-repeat center/cover;
      height: 280px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 32px;
      font-weight: bold;
      text-shadow: 0 3px 5px rgba(0,0,0,0.5);
    }

    .news-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 25px;
      padding: 40px 60px;
    }

    .news-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease;
    }

    .news-card:hover {
      transform: translateY(-5px);
    }

    .news-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }

    .news-card .info {
      padding: 15px;
    }

    .news-card h3 {
      color: #00b894;
      margin-bottom: 10px;
      font-size: 18px;
    }

    .news-card p {
      color: #555;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .news-card .price {
      color: #e67e22;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .news-card a {
      text-decoration: none;
      color: #00b894;
      font-weight: bold;
    }

    .news-card a:hover {
      text-decoration: underline;
    }

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

  <?php include "menu.php"; ?>

  <div class="banner">
    <div>Tin tức & sản phẩm mới của <?php echo htmlspecialchars($tenDangNhap); ?></div>
  </div>

  <div class="news-container">
    <?php if ($result_sp && $result_sp->num_rows > 0): ?>
      <?php while ($sp = $result_sp->fetch_assoc()): 
        $imgPath = !empty($sp['img']) ? "../" . htmlspecialchars($sp['img']) : "https://via.placeholder.com/300x200?text=No+Image";
      ?>
        <div class="news-card">
          <img src="<?php echo $imgPath; ?>" alt="<?php echo htmlspecialchars($sp['TenSP']); ?>">
          <div class="info">
            <h3><?php echo htmlspecialchars($sp['TenSP']); ?></h3>
            <p><?php echo htmlspecialchars(mb_strimwidth($sp['MoTa'], 0, 100, "...")); ?></p>
            <div class="price">Giá: <?php echo number_format($sp['GiaBan'], 0, ',', '.'); ?>đ</div>
            <a href="donhang.php?MaSP=<?php echo $sp['MaSP']; ?>">Xem chi tiết</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center; font-size:16px;">Chưa có sản phẩm nào để hiển thị.</p>
    <?php endif; ?>
  </div>

  <footer>
    © 2025 YOUR SHOP — Thiết kế bởi <a href="#">Nhóm LuffyDev</a>
  </footer>

</body>
</html>
