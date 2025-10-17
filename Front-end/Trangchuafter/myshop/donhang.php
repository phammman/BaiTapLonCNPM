<?php
session_start();
include "../connect.php";

// 🔹 Lấy sản phẩm hiện tại theo MaSP
if (isset($_GET['MaSP'])) {
    $MaSP = intval($_GET['MaSP']);
    $sql = "SELECT * FROM sanpham WHERE MaSP = $MaSP";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $TenSP = $row['TenSP'];
        $GiaBan = number_format($row['GiaBan'], 0, ',', '.');
        $SoLuongTon = $row['SoLuongTon'];
        $MoTa = $row['MoTa'];
        $img = !empty($row['img']) ? $row['img'] : 'uploads/default.png';
        $MaND_SP = $row['MaND']; // 🔸 Chủ shop của sản phẩm này
    } else {
        echo "<h2>Không tìm thấy sản phẩm!</h2>";
        exit;
    }
} else {
    echo "<h2>Không có sản phẩm được chọn!</h2>";
    exit;
}

// 🔹 Lấy thông tin người dùng đăng nhập (nếu có)
$tenDangNhap = "Khách";
$sdt = "Chưa có";

if (isset($_SESSION['MaND'])) {
    $mand = (int)$_SESSION['MaND'];
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
    <title><?php echo htmlspecialchars($TenSP); ?> - Chi tiết sản phẩm</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f6f7fb;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 85%;
            margin: 50px auto;
            display: flex;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .product-image {
            flex: 1;
            background: #fafafa;
            text-align: center;
            padding: 40px;
        }

        .product-image img {
            width: 100%;
            max-width: 450px;
            border-radius: 12px;
            transition: transform 0.3s;
        }

        .product-image img:hover {
            transform: scale(1.05);
        }

        .product-info {
            flex: 1;
            padding: 40px;
        }

        .product-info h2 {
            font-size: 28px;
            color: #222;
            margin-bottom: 15px;
        }

        .price {
            font-size: 24px;
            color: #d63031;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .quantity {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .description {
            font-size: 15px;
            line-height: 1.6;
            color: #444;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 14px 22px;
            background: linear-gradient(135deg, #007bff, #00b4d8);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: linear-gradient(135deg, #0056b3, #0096c7);
            transform: translateY(-2px);
        }

        /* ----- Sản phẩm liên quan ----- */
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 30px 10%;
        }

        .related-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .related-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .related-card .info {
            padding: 15px;
        }

        .related-card h3 {
            color: #00b894;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .related-card p {
            color: #555;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .related-card .price {
            color: #e67e22;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .related-card .view-btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .related-card .view-btn:hover {
            background: #0056b3;
        }

        footer {
            background: #222;
            color: #ccc;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        footer a {
            color: #00b894;
            text-decoration: none;
        }

        /* ===== Popup thêm giỏ hàng ===== */
        .popup {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #fff;
            border-radius: 10px;
            width: 400px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            position: relative;
            animation: fadeIn 0.3s ease;
        }

        .popup-content h3 {
            margin-bottom: 15px;
            text-align: center;
        }

        .popup-body {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .popup-body img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .popup-info {
            flex: 1;
        }

        .popup .close {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 22px;
            cursor: pointer;
        }

        #quantity {
            width: 70px;
            padding: 6px;
            font-size: 16px;
            margin-top: 5px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<?php include "menu.php"; ?>

<div class="container">
    <div class="product-image">
        <img src="../<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($TenSP); ?>">
    </div>

    <div class="product-info">
        <h2><?php echo htmlspecialchars($TenSP); ?></h2>
        <div class="price"><?php echo $GiaBan; ?> VNĐ</div>
        <div class="quantity">Còn lại: <?php echo $SoLuongTon; ?> sản phẩm</div>
        <div class="description"><?php echo nl2br(htmlspecialchars($MoTa)); ?></div>
        <button class="btn" id="addToCartBtn">🛒 Thêm vào giỏ hàng</button>
    </div>
</div>

<!-- 🔹 Popup thêm vào giỏ hàng -->
 <form action="add_giohang.php" method="post" enctype="multipart/form-data">
     <input type="hidden" name="MaSP" value="<?php echo $MaSP; ?>">
     <div id="cartPopup" class="popup">
         <div class="popup-content">
             <span class="close">&times;</span>
             <h3>Thêm sản phẩm vào giỏ hàng</h3>
             <div class="popup-body">
                 <img name="img" src="../<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($TenSP); ?>">
                 <div class="popup-info">
                     <h4 name="TenSP"><?php echo htmlspecialchars($TenSP); ?></h4>
                     <p class="price" name="GiaBan"><?php echo $GiaBan; ?> VNĐ</p>
                     <label>Số lượng:</label>
                     <input name="SoLuong" type="number" id="quantity" value="1" min="1" max="<?php echo $SoLuongTon; ?>">
                 </div>
             </div>
             <button type="submit" id="confirmAdd" class="btn">Thêm vào giỏ hàng</button>
         </div>
     </div>
 </form>

<!-- 🔹 Sản phẩm liên quan -->
<h3 style="margin-left: 10%; font-size: 22px; color: #222; margin-top: 50px;">
  🔎 Sản phẩm khác từ cửa hàng này
</h3>

<div class="related-grid">
  <?php
  $sqlMand = "SELECT MaND FROM sanpham WHERE MaSP = $MaSP";
  $mandResult = mysqli_query($conn, $sqlMand);
  $mandRow = mysqli_fetch_assoc($mandResult);
  $mandSP = $mandRow['MaND'];

  $sql_related = "SELECT MaSP, TenSP, MoTa, GiaBan, img 
                  FROM sanpham 
                  WHERE MaND = $mandSP AND MaSP != $MaSP 
                  ORDER BY MaSP DESC 
                  LIMIT 6";
  $related_result = mysqli_query($conn, $sql_related);

  if ($related_result && mysqli_num_rows($related_result) > 0):
      while ($sp = mysqli_fetch_assoc($related_result)):
          $imgPath = !empty($sp['img']) ? "../" . htmlspecialchars($sp['img']) : "../uploads/default.png";
  ?>
      <div class="related-card">
          <img src="<?php echo $imgPath; ?>" alt="<?php echo htmlspecialchars($sp['TenSP']); ?>">
          <div class="info">
              <h3><?php echo htmlspecialchars($sp['TenSP']); ?></h3>
              <p><?php echo htmlspecialchars(mb_strimwidth($sp['MoTa'], 0, 100, "...")); ?></p>
              <div class="price"><?php echo number_format($sp['GiaBan'], 0, ',', '.'); ?> VNĐ</div>
              <a href="donhang.php?MaSP=<?php echo $sp['MaSP']; ?>" class="view-btn">Xem chi tiết</a>
          </div>
      </div>
  <?php endwhile; else: ?>
      <p style="margin-left:10%; color:#777;">Không có sản phẩm nào khác từ cửa hàng này.</p>
  <?php endif; ?>
</div>

<footer>
    © 2025 YOUR SHOP — Thiết kế bởi <a href="#">Nhóm LuffyDev</a>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const popup = document.getElementById("cartPopup");
    const btn = document.getElementById("addToCartBtn");
    const close = document.querySelector(".popup .close");
    const confirmBtn = document.getElementById("confirmAdd");

    btn.addEventListener("click", () => {
        popup.style.display = "flex";
    });

    close.addEventListener("click", () => popup.style.display = "none");
    window.addEventListener("click", (e) => {
        if (e.target === popup) popup.style.display = "none";
    });

    confirmBtn.addEventListener("click", () => {
        const quantity = document.getElementById("quantity").value;
        window.location.href = `giohang.php?add=<?php echo $MaSP; ?>&soluong=${quantity}`;
    });
});
</script>

</body>
</html>
