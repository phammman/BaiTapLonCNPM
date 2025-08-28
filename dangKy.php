<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="./css/dangKy.css">
    <title>Đăng ký</title>
</head>
<body>
    <div class="box">
        <h2>Đăng ký</h2>
        <form id="formDangKy" action="dangKy.php" method="post">
            <div class="dau_vao">
                <label for="hoVaTen">Họ và tên</label>
                <input type="text" id="hoVaTen" name="hoVaTen" placeholder="Nhập họ và tên">
            </div>
            <span class="error " id="hoVaTenError"> Họ và tên không được để trống</span>
            
            <div class="dau_vao">
                <label for="soDienThoai">Số điện thoại</label>
                <input type="text" id="soDienThoai" name="soDienThoai" placeholder="Nhập số điện thoại">
            </div>
            <span class="error" id="soDienThoaiError"> Số điện thoại không được để trống</span>
            
            <div class="gioi_tinh">
                <p>Giới tính</p>
                <input type="radio" name="gioiTinh" value="nam"> Nam
                <input type="radio" name="gioiTinh" value="nu"> Nữ
            </div>
            <div class="dau_vao">
                <label for="tenDangNhap">Tên đăng nhập</label>
                <input type="text" id="tenDangNhap" name="tenDangNhap" placeholder="Nhập tên đăng nhập">
            </div>

            <span class="error" id="tenDangNhapError"> Tên đăng nhập không được để trống</span>
            <div class="dau_vao">
                <label for="matKhau">Mật khẩu</label>
                <input type="password" id="matKhau" name="matKhau" placeholder="Nhập mật khẩu">
                <div class="eye" onclick="togglePassword('matKhau', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
            </div>
            <span class="error" id="matKhauError"> Mật khẩu không được để trống</span>
            
            <div class="dau_vao">
                <label for="nhapLaiMatKhau">Nhập lại mật khẩu</label>
                <input type="password" id="nhapLaiMatKhau" name="nhapLaiMatKhau" placeholder="Nhập lại mật khẩu">
                <div class="eye" onclick="togglePassword('nhapLaiMatKhau', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
            </div>
            <span class="error" id="nhapLaiMatKhauError">Nhập lại mật khẩu sai </span>
            <div class="btn-dangKy">
                <button type="submit">Đăng ký</button>
            </div>
        </form>
    </div>
    <script>
        var hoVaTen = document.getElementById('hoVaTen');
        var soDienThoai = document.getElementById('soDienThoai');
        var tenDangNhap = document.getElementById('tenDangNhap');
        var matKhau = document.getElementById('matKhau');
        var nhapLaiMatKhau = document.getElementById('nhapLaiMatKhau');

        var formDangKy = document.getElementById('formDangKy');

        var hoVaTenError = document.getElementById('hoVaTenError');
        var soDienThoaiError = document.getElementById('soDienThoaiError');
        var tenDangNhapError = document.getElementById('tenDangNhapError');
        var matKhauError = document.getElementById('matKhauError');
        var nhapLaiMatKhauError = document.getElementById('nhapLaiMatKhauError');

        formDangKy.addEventListener("submit", function (e) { 
            var check = true;
            if (hoVaTen.value.trim() === "") { 
                check = false;
                hoVaTenError.style.display = "block";
            }
            else { 
                hoVaTenError.style.display = "none";
            }

            if (soDienThoai.value.trim() === "") { 
                soDienThoaiError.style.display = "block";
            } else {
                soDienThoaiError.style.display = "none";
            }

            if (tenDangNhap.value.trim() === "") {
                check = false;
                tenDangNhapError.style.display = "block";
            } else {
                tenDangNhapError.style.display = "none";
            }

            if (matKhau.value.trim() === "") {
                check = false;
                matKhauError.style.display = "block";
            } else {
                matKhauError.style.display = "none";
            }

            if (nhapLaiMatKhau.value.trim() === "") {
                check = false;
                nhapLaiMatKhauError.style.display = "block";
            } else {
                nhapLaiMatKhauError.style.display = "none";
            }

            if (matKhau.value !== nhapLaiMatKhau.value) {
                check = false;
                nhapLaiMatKhauError.style.display = "block";
                nhapLaiMatKhauError.innerHTML = "Mật khẩu nhập lại không khớp với mật khẩu ";
            }

        if (!check) {
            e.preventDefault();
        }
    })
        function togglePassword(inputId, eyeElement) {
            const inputField = document.getElementById(inputId);
            const icon = eyeElement.querySelector('i');

            if (inputField.type === 'password') {
                inputField.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                inputField.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>