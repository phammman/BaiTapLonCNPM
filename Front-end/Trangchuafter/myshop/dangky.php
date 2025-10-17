<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $HoTen       = mysqli_real_escape_string($conn, $_POST['HoTen']);
    $MatKhau     = mysqli_real_escape_string($conn, $_POST['MatKhau']);
    $XacNhanMatKhau = mysqli_real_escape_string($conn, $_POST['XacNhanMatKhau']);
    $DienThoai   = mysqli_real_escape_string($conn, $_POST['DienThoai']);
    // $DiaChi      = mysqli_real_escape_string($conn, $_POST['DiaChi']);
    $Email       = mysqli_real_escape_string($conn, $_POST['Email']);

    // Kiểm tra xác nhận mật khẩu
    if ($MatKhau !== $XacNhanMatKhau) {
        echo "<script>alert('Mật khẩu xác nhận không khớp!'); history.back();</script>";
        exit;
    }

    // Thêm vào bảng khachhang (không mã hóa mật khẩu)
    $sql = "INSERT INTO khachhang (HoTen, DienThoai, Email, MatKhau)
            VALUES ('$HoTen', '$DienThoai', '$Email', '$MatKhau')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Đăng ký khách hàng thành công!');
                window.location.href = 'DangNhap.php';
              </script>";
        exit;
    } else {
        echo 'Lỗi: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký khách hàng - Sapo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f8fc;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .register-container {
      background: white;
      width: 500px;
      max-width: 95%;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      padding: 30px 25px;
      text-align: center;
      position: relative;
    }
    .logo {
      font-size: 2rem;
      font-weight: bold;
      color: #00AEEF;
      margin-bottom: 8px;
      cursor: pointer;
    }
    h2 { font-size: 1.4rem; font-weight: bold; margin: 5px 0; }
    p.subtitle { font-size: 0.95rem; color: #555; margin-bottom: 20px; }
    .input-row { display: flex; gap: 10px; margin-bottom: 10px; }
    .input-field {
      width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 25px;
      font-size: 1rem; box-sizing: border-box; outline: none;
    }
    .input-field:focus { border-color: #00AEEF; }
    .terms { display: flex; align-items: flex-start; font-size: 0.85rem;
      margin: 15px 0; text-align: left; }
    .terms input { margin-top: 3px; margin-right: 5px; }
    .terms a { color: #0077ff; text-decoration: none; }
    .register-btn {
      width: 100%; background: #d1d1d1; color: white; padding: 12px; border: none;
      border-radius: 30px; font-size: 1rem; cursor: not-allowed;
      display: flex; justify-content: center; align-items: center; gap: 8px;
      transition: background 0.3s ease;
    }
    .register-btn.active { background: linear-gradient(90deg, #00c853, #00e676); cursor: pointer; }
    .register-btn:hover.active { opacity: 0.9; }
    .or-text { margin: 15px 0 10px; color: #777; font-size: 0.9rem; }
    .social-login { display: flex; justify-content: center; gap: 15px; }
    .social-login button {
      display: flex; align-items: center; justify-content: center;
      width: 130px; padding: 10px; border-radius: 25px;
      border: 1px solid #ccc; background: white;
      cursor: pointer; font-size: 0.95rem; font-weight: bold;
    }
    .facebook { color: #3b5998; }
    .google { color: #db4437; }
    .back-link {
      position: absolute; top: 20px; left: 20px;
      text-decoration: none; font-size: 0.95rem; color: #0077ff;
      border:none; background-color: #f5f8fc;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <button class="back-link" onclick="window.history.back()">← Quay lại</button>
  <div class="register-container">
    <div class="logo" onclick="location.href='../Trangchubefore/TrangChuBefore.php'">Sapo</div>
    <h2>Đăng ký khách hàng</h2>

    <form method="POST" action="DangKy.php">
      <div class="input-row">
        <input type="text" class="input-field" name="HoTen" id="HoTen" placeholder="Họ tên của bạn" required>
      </div>
      <div class="input-row">
        <input type="text" class="input-field" name="DienThoai" id="DienThoai" placeholder="Số điện thoại của bạn" required>
      </div>
      <!-- <div class="input-row">
        <input type="text" class="input-field" name="DiaChi" id="DiaChi" placeholder="Địa chỉ của bạn" required>
      </div> -->
      <div class="input-row">
        <input type="email" class="input-field" name="Email" id="Email" placeholder="Email của bạn" required>
      </div>
      <div class="input-row">
        <input type="password" class="input-field" name="MatKhau" id="MatKhau" placeholder="Mật khẩu của bạn" required>
      </div>
      <div class="input-row">
        <input type="password" class="input-field" name="XacNhanMatKhau" id="XacNhanMatKhau" placeholder="Xác nhận mật khẩu" required>
      </div>

      <div class="terms">
        <input type="checkbox" id="agree" required>
        <label for="agree">Tôi đã đọc và đồng ý với 
          <a href="#">Chính sách bảo mật</a> & 
          <a href="#">Điều khoản sử dụng</a>
        </label>
      </div>

      <button type="submit" class="register-btn" id="registerBtn">Đăng ký →</button>
    </form>

    <p class="or-text">hoặc đăng ký bằng</p>
    <div class="social-login">
      <button class="facebook">Facebook</button>
      <button class="google">Google</button>
    </div>
  </div>

  <script>
    const fields = ["HoTen", "DienThoai", "Email", "MatKhau", "XacNhanMatKhau"];
    const agree = document.getElementById("agree");
    const registerBtn = document.getElementById("registerBtn");

    function checkForm() {
      const allFilled = fields.every(id => document.getElementById(id).value.trim() !== "");
      if (allFilled && agree.checked) {
        registerBtn.classList.add("active");
        registerBtn.disabled = false;
      } else {
        registerBtn.classList.remove("active");
        registerBtn.disabled = true;
      }
    }

    fields.forEach(id => {
      document.getElementById(id).addEventListener("input", checkForm);
    });
    agree.addEventListener("change", checkForm);

    checkForm();
  </script>
</body>
</html>
