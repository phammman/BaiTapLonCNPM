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
  <title>Giới thiệu - YOUR SHOP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f9f9f9;
      color: #333;
    }

    .banner {
      background: url('https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?w=1200') no-repeat center/cover;
      height: 300px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 32px;
      font-weight: bold;
      text-shadow: 0 3px 5px rgba(0,0,0,0.5);
    }

    .content {
      padding: 50px 80px;
      background: #fff;
      margin: 40px auto;
      border-radius: 8px;
      max-width: 1000px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      line-height: 1.6;
    }

    h2 {
      color: #00b894;
      margin-bottom: 15px;
    }

    p {
      margin-bottom: 15px;
    }

  </style>
</head>
<body>

  <?php include "menu.php"; ?>

  <div class="content">
    <h2>Chào mừng đến với <?php echo htmlspecialchars($tenDangNhap); ?> SHOP!</h2>
    <p>Được thành lập từ năm 2020, <?php echo htmlspecialchars($tenDangNhap); ?> SHOP là cửa hàng chuyên cung cấp các sản phẩm thời trang và phụ kiện dành cho giới trẻ. Với tiêu chí “Chất lượng – Uy tín – Phong cách”, chúng tôi luôn nỗ lực mang đến những sản phẩm tốt nhất cho khách hàng.</p>

    <p>Đội ngũ của <?php echo htmlspecialchars($tenDangNhap); ?> SHOP không ngừng cập nhật xu hướng thời trang mới nhất, đa dạng về mẫu mã, màu sắc và chất liệu để đáp ứng nhu cầu ngày càng cao của người tiêu dùng.</p>

    <h2>Tầm nhìn & Sứ mệnh</h2>
    <p>Trở thành thương hiệu thời trang được yêu thích hàng đầu Việt Nam, mang đến trải nghiệm mua sắm hiện đại, tiện lợi và đầy cảm hứng.</p>

    <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($tenDangNhap); ?> SHOP, 123 Nguyễn Trãi, Hà Nội<br>
       <b>Hotline:</b> <?php echo htmlspecialchars($sdt); ?><br>
       <b>Email:</b> support@<?php echo htmlspecialchars($tenDangNhap); ?>shop.vn</p>
  </div>

</body>
</html>
