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
  <title>Liên hệ - YOUR SHOP</title>
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
      height: 300px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 32px;
      font-weight: bold;
      text-shadow: 0 3px 5px rgba(0,0,0,0.5);
    }

    .contact-container {
      display: flex;
      justify-content: space-between;
      padding: 50px 80px;
      gap: 40px;
    }

    .contact-info {
      width: 40%;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }

    .contact-info h3 {
      color: #00b894;
      margin-bottom: 15px;
    }

    .contact-info p {
      margin: 8px 0;
    }

    .contact-form {
      width: 60%;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }

    form label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
    }

    form input, form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    form button {
      background: #00b894;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    form button:hover {
      background: #019670;
    }

  </style>
</head>
<body>

  <?php include "menu.php"; ?>

  <div class="contact-container">
    <div class="contact-info">
      <h3>Thông tin liên hệ</h3>
      <p><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($tenDangNhap); ?> Shop, 123 Nguyễn Trãi, Hà Nội</p>
      <p><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($sdt); ?></p>
      <p><i class="fa-solid fa-envelope"></i> support@<?php echo htmlspecialchars($tenDangNhap); ?>shop.vn</p>
      <p><i class="fa-solid fa-clock"></i> 8:00 - 21:00 (T2 - CN)</p>
    </div>

    <div class="contact-form">
      <h3>Gửi tin nhắn cho chúng tôi</h3>
      <form action="#" method="post">
        <label for="name">Họ và tên</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Nội dung</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Gửi liên hệ</button>
      </form>
    </div>
  </div>

</body>
</html>
