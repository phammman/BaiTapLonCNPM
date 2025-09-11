<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="DangNhap.css">
    <title>Đăng nhập</title>
</head>
<body>
   <div class="background"></div>
   <header>
    <nav class="navbar">
      <div class="logo">
        <img src="logo.jpg" alt="Sapo Logo">
      </div>
      <div class="menu">
        <a href="#">Giải pháp </a>
        <a href="#">Bảng giá</a>
        <a href="#">Khách hàng</a>
        <a href="#">Enterprise</a>
        <a href="#">Quản Lý Cửa Hàng <span class="badge">NEW</span></a>
        <a href="#">Thêm </a>
        <button class="btn-register">Đăng ký</button>
      </div>
    </nav>
  </header>
  <div class="box">
        <form id="formDangNhap" action="dangNhap.php" method="post">
            <h2>Đăng Nhập</h2>
            <div class="dau_vao">
                <label for="tenDangNhap">Tên đăng nhập</label>
                <input type="text" id="tenDangNhap" placeholder="Nhập tên đăng nhập của bạn" name="tenDangNhap">
            </div>
            <span class="error" id="tenDangNhapError">Tên đăng nhập không được để trống</span>

            <div class="dau_vao">
                <label for="matKhau">Mật khẩu</label>
                <input type="password" id="matKhau" placeholder="Nhập mật khẩu của bạn" name="matKhau">
            </div>
            <span class="error" id="matKhauError">Mật khẩu không được để trống</span>
            <div class="btn">
                <button type="submit">Đăng nhập</button>
            </div>
            <div class="register">
                <p>
                    Bạn chưa có tài khoản? 
                    <a href="dangKy.php">Đăng Kí</a>
                </p>
            </div>
        </form>
    </div>
    <script>
        var formDangNhap = document.getElementById('formDangNhap');

        var tenDangNhap = document.getElementById('tenDangNhap');
        var matKhau = document.getElementById('matKhau');
        var tenDangNhapError = document.getElementById('tenDangNhapError');
        var matKhauError = document.getElementById('matKhauError');

        formDangNhap.addEventListener('submit', function (event) {
            var isValid = true;

            if (tenDangNhap.value.trim() === '') {
                tenDangNhapError.style.display = 'block';
                tenDangNhap.classList.add('input-error');
                isValid = false;
            } else {
                tenDangNhapError.style.display = 'none';
                tenDangNhap.classList.remove('input-error');
            }

            if (matKhau.value.trim() === '') {
                matKhauError.style.display = 'block';
                matKhau.classList.add('input-error');
                isValid = false;
            } else {
                matKhauError.style.display = 'none';
                matKhau.classList.remove('input-error');
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
   <div class="footer">
    <div class="footer-content">
        <h2>Vào Ứng Dụng Ngay Thôi</h2>
        <p>Để trải nghiệm phần mềm quản lý bán hàng hiệu quả nhất.</p>
        <button class="btn-free-trial">Bắt Đầu Trải Nghiệm</button>
    </div>
    <div class="footer-columns">
        <div class="footer-column">
            <h3>Quản Lý Cửa Hàng</h3>
            <a href="#">Giới thiệu</a>
            <a href="#">Tin tức</a>
            <a href="#">Liên hệ</a>
        </div>
        <div class="footer-column">
            <h3>Giải pháp</h3>
            <a href="#">Quản lý bán hàng</a>
            <a href="#">Quản lý kho</a>
            <a href="#">Quản lý đơn hàng</a>
        </div>
        <div class="footer-column">
            <h3>Sản phẩm</h3>
            <a href="#">Phần mềm quản lý</a>
            <a href="#">Ứng dụng di động</a>
            <a href="#">Thiết bị bán hàng</a>
        </div>
        <div class="footer-column">
            <h3>Hỗ trợ</h3>
            <a href="#">Trung tâm hỗ trợ</a>
            <a href="#">Câu hỏi thường gặp</a>
            <a href="#">Tài liệu hướng dẫn</a>
        </div>
        <div class="footer-column">
            <h3>Social</h3>
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
            <a href="#">LinkedIn</a>
        </div>
    </div>
</div>
</div>
</body>
</html>