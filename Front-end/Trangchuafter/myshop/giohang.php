<?php
session_start();
include "../connect.php";

// --- 1. XÁC ĐỊNH NGƯỜI DÙNG HIỆN TẠI ---
$tenDangNhap = "Khách";
$sdt = "Chưa có";
$maKH = 0;

if (isset($_SESSION['MaND'])) {
    $mand = (int)$_SESSION['MaND'];
    $sql = "SELECT khachhang.MaKH, nguoidung.TenDangNhap, nguoidung.SDT
            FROM khachhang 
            JOIN nguoidung ON khachhang.MaND = nguoidung.MaND
            WHERE khachhang.MaND = $mand";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tenDangNhap = $row['TenDangNhap'];
        $sdt = $row['SDT'];
        $maKH = $row['MaKH'];
    }
}

// --- 2. XỬ LÝ GIỎ HÀNG ---
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Xóa sản phẩm
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($maKH > 0) {
        $conn->query("DELETE FROM giohang WHERE MaKH = $maKH AND MaSP = $id");
    } else {
        unset($_SESSION['cart'][$id]);
    }
    echo "<script>alert('Đã xóa sản phẩm khỏi giỏ hàng!'); window.location='giohang.php';</script>";
    exit;
}

// Cập nhật số lượng
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        $id = (int)$id;
        $qty = max(1, (int)$qty);

        if ($maKH > 0) {
            $conn->query("UPDATE giohang SET SoLuong = $qty WHERE MaKH = $maKH AND MaSP = $id");
        } else {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] = $qty;
            }
        }
    }
    echo "<script>alert('Cập nhật giỏ hàng thành công!'); window.location='giohang.php';</script>";
    exit;
}

// --- 3. LẤY DỮ LIỆU GIỎ HÀNG ---
$cart_items = [];
$tong = 0;

if ($maKH > 0) {
    $sql = "SELECT sanpham.MaSP, sanpham.TenSP, sanpham.GiaBan, sanpham.img, giohang.SoLuong
            FROM giohang
            JOIN sanpham ON giohang.MaSP = sanpham.MaSP
            WHERE giohang.MaKH = $maKH";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $row['ThanhTien'] = $row['GiaBan'] * $row['SoLuong'];
        $cart_items[] = $row;
        $tong += $row['ThanhTien'];
    }
} else {
    foreach ($_SESSION['cart'] as $id => $item) {
        $thanhtien = $item['price'] * $item['quantity'];
        $cart_items[] = [
            'MaSP' => $id,
            'TenSP' => $item['name'],
            'GiaBan' => $item['price'],
            'img' => $item['img'],
            'SoLuong' => $item['quantity'],
            'ThanhTien' => $thanhtien
        ];
        $tong += $thanhtien;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Giỏ hàng</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

/* Khung chính */
.container {
    width: 85%;
    margin: 30px auto;
    background: white;
    border-radius: 6px;
    box-shadow: 0 0 8px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* Header bảng */
.cart-header {
    background-color: #fafafa;
    padding: 15px;
    display: grid;
    grid-template-columns: 40px 2fr 1fr 1fr 1fr 100px;
    font-weight: 600;
    border-bottom: 1px solid #eee;
}

/* Item */
.cart-item {
    display: grid;
    grid-template-columns: 40px 2fr 1fr 1fr 1fr 100px;
    align-items: center;
    border-bottom: 1px solid #f0f0f0;
    padding: 15px;
}
.cart-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    margin-right: 10px;
}
.cart-item .product-info {
    display: flex;
    align-items: center;
}
.cart-item input[type="number"] {
    width: 60px;
    text-align: center;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

/* Footer */
.cart-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: #fafafa;
    border-top: 1px solid #eee;
}
.cart-footer .total {
    font-size: 18px;
    font-weight: bold;
    color: #00b894;
}
.cart-footer button {
    background: #00b894;
    color: white;
    border: none;
    padding: 12px 30px;
    font-size: 16px;
    border-radius: 3px;
    cursor: pointer;
}
.cart-footer button:hover {
    background: #019670;
}
.remove-link {
    color: #00b894;
    text-decoration: none;
}
.remove-link:hover {
    text-decoration: underline;
}

</style>
</head>
<body>

<?php include "menu.php"; ?>

<div class="container">
  <h2 style="padding:15px; border-bottom:1px solid #eee;">🛒 Giỏ hàng</h2>

  <?php if (!empty($cart_items)): ?>
  <form method="POST">
      <div class="cart-header">
          <div><input type="checkbox"></div>
          <div>Sản phẩm</div>
          <div>Đơn giá</div>
          <div>Số lượng</div>
          <div>Số tiền</div>
          <div>Thao tác</div>
      </div>

      <?php foreach ($cart_items as $item): ?>
      <div class="cart-item">
          <div><input type="checkbox"></div>
          <div class="product-info">
              <img src="../<?php echo htmlspecialchars($item['img']); ?>" alt="">
              <span><?php echo htmlspecialchars($item['TenSP']); ?></span>
          </div>
          <div><?php echo number_format($item['GiaBan'], 0, ',', '.'); ?>đ</div>
          <div>
              <input type="number" name="quantity[<?php echo $item['MaSP']; ?>]" value="<?php echo $item['SoLuong']; ?>" min="1">
          </div>
          <div><?php echo number_format($item['ThanhTien'], 0, ',', '.'); ?>đ</div>
          <div><a href="?action=remove&id=<?php echo $item['MaSP']; ?>" class="remove-link">Xóa</a></div>
      </div>
      <?php endforeach; ?>

      <div class="cart-footer">
          <div>Tổng cộng: <span class="total"><?php echo number_format($tong, 0, ',', '.'); ?>đ</span></div>
          <div>
              <button type="submit" name="update_cart">Cập nhật</button>
              <button type="button" onclick="window.location.href='thanhtoan.php'">Mua hàng</button>
          </div>
      </div>
  </form>
  <?php else: ?>
      <p style="text-align:center; padding:40px;">Giỏ hàng của bạn đang trống 😢</p>
      <div style="text-align:center; margin-bottom:20px;">
        <a href="TrangChu.php" style="background:#00b894; color:white; padding:10px 20px; text-decoration:none; border-radius:3px;">⬅ Tiếp tục mua sắm</a>
      </div>
  <?php endif; ?>
</div>


</body>
</html>
