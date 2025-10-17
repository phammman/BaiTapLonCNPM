<?php
session_start();
include('../connect.php'); // Kết nối CSDL

$error = ""; // Biến chứa thông báo lỗi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['Email']);
    $matkhau = trim($_POST['MatKhau']);

    if (empty($email) || empty($matkhau)) {
        $error = "Vui lòng nhập đầy đủ email và mật khẩu!";
    } else {
        // Chống SQL injection
        $email = mysqli_real_escape_string($conn, $email);
        $matkhau = mysqli_real_escape_string($conn, $matkhau);

        // Kiểm tra tài khoản trong bảng khachhang
        $sql = "SELECT * FROM khachhang WHERE Email = '$email' AND MatKhau = '$matkhau' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $kh = mysqli_fetch_assoc($result);

            // Lưu thông tin đăng nhập vào session
            $_SESSION['MaKH'] = $kh['MaKH'];
            $_SESSION['HoTen'] = $kh['HoTen'];
            $_SESSION['Email'] = $kh['Email'];
            $_SESSION['DienThoai'] = $kh['DienThoai'];
            $_SESSION['DiaChi'] = $kh['DiaChi'];

            // Chuyển hướng đến trang chủ
            header("Location: Trangchu.php");
            exit;
        } else {
            $error = "Email hoặc mật khẩu không đúng!";
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập khách hàng</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #ffffff, #e6f3ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-container {
      background: white;
      width: 400px;
      max-width: 90%;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 30px 25px;
      text-align: center;
    }
    .logo {
      font-size: 2rem;
      font-weight: bold;
      color: #00AEEF;
      margin-bottom: 8px;
      cursor: pointer;
    }
    h2 {
      font-size: 1.2rem;
      font-weight: normal;
      margin-bottom: 20px;
      color: #333;
    }
    .input-field {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 25px;
      font-size: 1rem;
      outline: none;
      box-sizing: border-box;
    }
    .input-field:focus {
      border-color: #00AEEF;
    }
    .password-container {
      position: relative;
    }
    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 16px;
      color: #666;
      user-select: none;
    }
    .login {
      text-align: left;
      font-size: 0.9rem;
      color: #00AEEF;
      text-decoration: none;
      margin-right:200px;
    }
    .forgot-password {
      text-align: right;
      margin: 5px 5px 15px;
      font-size: 0.9rem;
      color: #00AEEF;
      text-decoration: none;
    }
    .links {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
    }
    .login-btn {
      width: 100%;
      background: linear-gradient(to right, #2fd2c0, #56e0cb);
      color: white;
      padding: 12px;
      border: none;
      border-radius: 25px;
      font-size: 1rem;
      cursor: pointer;
      margin-bottom: 15px;
      font-weight: bold;
      margin-top: 15px;
    }
    .login-btn:hover {
      opacity: 0.9;
    }
    .error {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div onclick="location.href='Trangchu.php'" class="logo">Sapo</div>
    <h2>Đăng nhập tài khoản khách hàng</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
      <input type="text" class="input-field" name="Email" placeholder="Nhập email của bạn" required>
      <div class="password-container">
        <input type="password" id="password" name="MatKhau" class="input-field" placeholder="Nhập mật khẩu" required>
        <span class="toggle-password" id="togglePassword">👁</span>
      </div>
      <div class="links">
        <a href="DangKy.php" class="login">Đăng ký</a>
        <a href="#" class="forgot-password">Quên mật khẩu</a>
      </div>
      <button type="submit" class="login-btn">Đăng nhập</button>
    </form>
  </div>

  <script>
    // Ẩn/hiện mật khẩu
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    togglePassword.addEventListener("click", () => {
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
      togglePassword.textContent = type === "password" ? "👁" : "🙈";
    });
  </script>
</body>
</html>
