<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/dangNhap.css">
    <title>Đăng nhập</title>

</head>
<body>
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
                <button type = "submid">Đăng nhập</button>
            </div>
            <div class="register">
                <p>
                    Bạn chưa có tài khoản?
                    <a href="dangKy.php">Đăng ký</a>
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
</body>
</html>