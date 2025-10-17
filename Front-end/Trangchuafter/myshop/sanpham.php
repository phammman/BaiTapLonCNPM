<?php
session_start();
include "../connect.php";

// Ưu tiên lấy MaND từ session (nếu đã đăng nhập)
$tenDangNhap = "Khách";
$sdt = "Chưa có";

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
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YOUR SHOP - Sản phẩm</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f9f9f9;
      color: #333;
    }

    /* Top bar + header dùng chung */
    .top-bar {
      background: #222;
      color: #fff;
      font-size: 14px;
      padding: 5px 40px;
      display: flex;
      justify-content: space-between;
    }

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

    nav a:hover, nav a.active {
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

    /* Breadcrumb */
    .breadcrumb {
      background: #f4f4f4;
      padding: 12px 40px;
      font-size: 14px;
    }

    .breadcrumb a {
      color: #333;
      text-decoration: none;
    }

    .breadcrumb a:hover {
      color: #00b894;
    }

    /* Container */
    .container {
      display: flex;
      padding: 30px 40px;
      gap: 30px;
    }

    /* Sidebar */
    .sidebar {
      width: 25%;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      height: fit-content;
    }

    .sidebar h3 {
      border-bottom: 2px solid #00b894;
      padding-bottom: 5px;
      margin-bottom: 15px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin-bottom: 10px;
    }

    .sidebar ul li a {
      text-decoration: none;
      color: #333;
      transition: color 0.2s;
    }

    .sidebar ul li a:hover {
      color: #00b894;
    }

    /* Main product list */
    .product-list {
      flex: 1;
    }

    .product-list h2 {
      color: #00b894;
      margin-bottom: 20px;
    }

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

  <?php include "menu.php"; ?>

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="index.php">Trang chủ</a> / <span>Sản phẩm</span>
  </div>

  <!-- Container -->
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h3>Danh mục sản phẩm</h3>
      <ul>
        <li><a href="#">Áo quần</a></li>
        <li><a href="#">Giày dép</a></li>
        <li><a href="#">Phụ kiện</a></li>
        <li><a href="#">Túi xách</a></li>
        <li><a href="#">Khuyến mãi</a></li>
      </ul>

      <h3>Bộ lọc giá</h3>
      <ul>
        <li><a href="#">Dưới 200.000đ</a></li>
        <li><a href="#">200.000đ - 500.000đ</a></li>
        <li><a href="#">500.000đ - 1.000.000đ</a></li>
        <li><a href="#">Trên 1.000.000đ</a></li>
      </ul>
    </aside>

    <!-- Product list -->
        <!-- Product list -->
    <!-- Product list -->
    <section class="product-list">
      <h2>Sản phẩm </h2>
      <div class="product-grid">
        <?php
        // Kiểm tra người dùng đã đăng nhập chưa
        if (isset($_SESSION['MaND'])) {
            $MaND = (int)$_SESSION['MaND'];

            // Lấy sản phẩm theo MaND
            $sql = "SELECT TenSP, GiaBan, MoTa, img FROM sanpham WHERE MaND = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $MaND);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    // Kiểm tra đường dẫn ảnh
                    $imgPath = !empty($row['img']) ? "../" . htmlspecialchars($row['img']) : "https://via.placeholder.com/300x200?text=No+Image";
        ?>
                    <div class="product-card">
                      <img src="<?php echo $imgPath; ?>" alt="<?php echo htmlspecialchars($row['TenSP']); ?>">
                      <h3><?php echo htmlspecialchars($row['TenSP']); ?></h3>
                      
                      <div class="price"><?php echo number_format($row['GiaBan'], 0, ',', '.'); ?>đ</div>
                      <button><i class="fa-solid fa-cart-plus"></i> Mua ngay</button>
                    </div>
        <?php
                endwhile;
            else:
                echo "<p>Bạn chưa thêm sản phẩm nào.</p>";
            endif;

            $stmt->close();
        } else {
            echo "<p>Vui lòng đăng nhập để xem sản phẩm của bạn.</p>";
        }
        ?>
      </div>
    </section>
  </div>

  <footer>
    © 2025 YOUR SHOP — Thiết kế bởi <a href="#">Nhóm LuffyDev</a>
  </footer>

</body>
</html>
