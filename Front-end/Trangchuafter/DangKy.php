<?php
// Kết nối CSDL
include __DIR__ . "/connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $TenDangNhap = mysqli_real_escape_string($conn, $_POST['TenDangNhap']);
    $MatKhau     = mysqli_real_escape_string($conn, $_POST['MatKhau']);
    $QuyenHan    = mysqli_real_escape_string($conn, $_POST['QuyenHan']);
    $SDT         = mysqli_real_escape_string($conn, $_POST['SDT']);

    // --- KIỂM TRA TÊN ĐĂNG NHẬP ĐÃ TỒN TẠI CHƯA ---
    $check_sql = "SELECT * FROM nguoidung WHERE TenDangNhap = '$TenDangNhap'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Nếu tên đăng nhập đã tồn tại
        echo "<script>
                alert('Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!');
                window.history.back(); // Quay lại trang trước
              </script>";
        exit;
    }

    // --- NẾU CHƯA TỒN TẠI THÌ THÊM MỚI ---
    $sql = "INSERT INTO nguoidung (TenDangNhap, MatKhau, QuyenHan, SDT) 
            VALUES ('$TenDangNhap', '$MatKhau', '$QuyenHan', '$SDT')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Đăng ký thành công!');
                window.location.href = 'DangNhap.php';
              </script>";
        exit;
    } else {
        echo "Lỗi khi đăng ký: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký dùng thử - Sapo</title>
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
    }
    h2 { font-size: 1.4rem; font-weight: bold; margin: 5px 0; }
    p.subtitle { font-size: 0.95rem; color: #555; margin-bottom: 20px; }
    .input-row { display: flex; gap: 10px; margin-bottom: 10px; }
    .input-field, .select-field {
      width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 25px;
      font-size: 1rem; box-sizing: border-box; outline: none;
    }
    .input-field:focus, .select-field:focus { border-color: #00AEEF; }
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
      border:none;
      background-color: #f5f8fc;
    }
    .message { margin: 10px 0; font-weight: bold; color: #008000; }
    .message.error { color: red; }
  </style>
</head>
<body>
  <button class="back-link" onclick="window.history.back()">← Quay lại</button>
  <div class="register-container">
    <div class="logo" onclick="location.href='../Trangchubefore/TrangChuBefore.php'">Sapo</div>
    <h2>Dùng thử miễn phí 7 ngày</h2>
    <p class="subtitle">Để khám phá tại sao +230,000 nhà bán hàng tin dùng Sapo</p>

    <?php if (!empty($message)) : ?>
      <p class="message <?php echo strpos($message, 'Lỗi') !== false ? 'error' : ''; ?>">
        <?php echo $message; ?>
      </p>
    <?php endif; ?>

    <form method="POST" action="DangKy.php">
      <div class="input-row">
        <input type="text" class="input-field" name="TenDangNhap" id="TenDangNhap" placeholder="Họ tên của bạn" required>
      </div>
      <div class="input-row">
        <input type="password" class="input-field" name="MatKhau" id="MatKhau" placeholder="Mật khẩu của bạn" required>
      </div>
      <div class="input-row">
        <input type="password" class="input-field" name="XacNhanMatKhau" id="XacNhanMatKhau" placeholder="Xác nhận mật khẩu" required>
      </div>
      <div class="input-row">
        <select class="select-field" name="QuyenHan" id="QuyenHan" required>
          <option value="">Chọn quyền hạn của bạn</option>
          <option name="KhachHang">Khách hàng</option>
          <option name="NhanVien">Nhân viên</option>
        </select>
        <input type="text" class="input-field" name="SDT" id="SDT" placeholder="Số điện thoại của bạn" required>
      </div>

      <div class="terms">
        <input type="checkbox" id="agree" required>
        <label for="agree">Tôi đã đọc, đồng ý với 
          <a href="#">Chính sách bảo vệ dữ liệu cá nhân</a> & 
          <a href="#">Quy định sử dụng</a> của Sapo
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
    const TenDangNhap = document.getElementById("TenDangNhap");
    const MatKhau = document.getElementById("MatKhau");
    const XacNhanMatKhau = document.getElementById("XacNhanMatKhau");
    const QuyenHan = document.getElementById("QuyenHan");
    const SDT = document.getElementById("SDT");
    const agree = document.getElementById("agree");
    const registerBtn = document.getElementById("registerBtn");

    function checkForm() {
      if (
        TenDangNhap.value.trim() &&
        MatKhau.value.trim() &&
        XacNhanMatKhau.value.trim() &&
        SDT.value.trim() &&
        QuyenHan.value &&
        agree.checked
      ) {
        registerBtn.classList.add("active");
        registerBtn.disabled = false;
      } else {
        registerBtn.classList.remove("active");
        registerBtn.disabled = true;
      }
    }

    [TenDangNhap, MatKhau, XacNhanMatKhau, QuyenHan, SDT, agree].forEach(el => {
      el.addEventListener("input", checkForm);
      el.addEventListener("change", checkForm);
    });

    checkForm();
  </script>
</body>
</html>
