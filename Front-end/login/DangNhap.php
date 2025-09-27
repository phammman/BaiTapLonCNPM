<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="DangNhap.css">
    <title>Đăng nhập</title>
    <style>
        .logo img{
            height: 100px;
        }
        .badge {
            background: #fff;
            }
        .dau_vao input {
            padding-left: 10px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include("../Trangchuafter/connect.php");
    if (isset($_POST['dangnhap'])) {
        $TenDangNhap = $_POST['TenDangNhap'];
        $MatKhau = $_POST['MatKhau'];
        
        // Prepare SQL statement
        $sql = "SELECT * FROM nguoidung WHERE TenDangNhap = ? AND MatKhau = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $TenDangNhap, $MatKhau); // Bind parameters
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $nguoidung = $result->fetch_assoc(); 
            $_SESSION['login'] = $nguoidung['MaND']; 
            $_SESSION['TenDangNhap'] = $nguoidung['TenDangNhap']; 
            header('Location: ../Trangchubefore/TrangChuBefore.php');
            exit; 
        } else {
            echo "Tên đăng nhập hoặc mật khẩu không chính xác.";
        }
    }
    ?>
    <div class="background"></div>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="logo.jpg" alt="Sapo Logo">
            </div>
            <div class="menu">
                <a href="#">Giải pháp ▾</a>
                <a href="#">Bảng giá</a>
                <a href="#">Khách hàng</a>
                <a href="#">Enterprise</a>
                <a href="#">Quản Lý Cửa Hàng <span class="badge">NEW</span></a>
                <a href="#">Thêm ▾</a>
                <button class="btn-register"><a href="dangKy.php">Đăng ký</a></button>
            </div>
        </nav>
    </header>
    
    <div class="box">
        <form id="formDangNhap" action="dangNhap.php" method="post">
            <h2>Đăng Nhập</h2>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="dau_vao">
                <label for="TenDangNhap">Tên đăng nhập</label>
                <input type="text" id="TenDangNhap" placeholder="Nhập tên đăng nhập của bạn" name="TenDangNhap" required style="opacity: 0.6;">
            </div>
            <div class="dau_vao">
                <label for="MatKhau">Mật khẩu</label>
                <input type="password" id="MatKhau" placeholder="Nhập mật khẩu của bạn" name="MatKhau" required style="opacity: 0.6;">
            </div>
            <div class="btn">
                <button type="submit" name="dangnhap">Đăng nhập</button>
            </div>
            <div class="register">
                <p>Bạn chưa có tài khoản? <a href="dangKy.php">Đăng Kí</a></p>
            </div>
        </form>
    </div>

    <script>
        var formDangNhap = document.getElementById('formDangNhap');
        formDangNhap.addEventListener('submit', function (event) {
            var tenDangNhap = document.getElementById('tenDangNhap');
            var matKhau = document.getElementById('matKhau');
            var isValid = true;

            if (tenDangNhap.value.trim() === '') {
                isValid = false;
                tenDangNhap.classList.add('input-error');
            } else {
                tenDangNhap.classList.remove('input-error');
            }

            if (matKhau.value.trim() === '') {
                isValid = false;
                matKhau.classList.add('input-error');
            } else {
                matKhau.classList.remove('input-error');
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>