<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="dangKy.css">
    <style>
        h2{
            margin: 20px 0;
        }
        .dau_vao input {
            height: 35px;
        }
        .gioi_tinh p{
            margin: 10px 0;
        }
        .error {
            color: red;
            display: none;
        }

        .red {
            color: red;

        }
    </style>
</head>
<body>
    <?php
    include("../Trangchuafter/connect.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy tên đăng nhập từ form
        $tenDangNhap = $_POST['tenDangNhap'];

        // Kiểm tra tên đăng nhập đã tồn tại trong cơ sở dữ liệu chưa
        $sql = "SELECT * FROM nguoidung WHERE TenDangNhap = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $tenDangNhap);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Tên đăng nhập đã tồn tại
            $error = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
        } else {
            $hoVaTen = $_POST['hoVaTen'];  // thực hiện hứng dữ liệu bằng cách gán chúng vào 1 biến khác
            $soDienThoai = $_POST['soDienThoai'];
            $quyenHan = $_POST['quyenHan'];
            $gioiTinh = $_POST['gioiTinh'];
            $tenDangNhap = $_POST['tenDangNhap'];
            $matKhau = $_POST['matKhau'];
            $nhapLaiMatKhau = $_POST['nhapLaiMatKhau'];

            $sql = "INSERT INTO nguoidung (TenDangNhap, MatKhau, HoTen, SoDienThoai, GioiTinh, QuyenHan) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $tenDangNhap, $matKhau, $hoVaTen, $soDienThoai, $gioiTinh , $quyenHan);
            if ($stmt->execute()) {
    // Lưu ID của người dùng vừa tạo
                $maND = $conn->insert_id; 
                if ($quyenHan == 'Nhanvien') {
                    $sqlNhanVien = "INSERT INTO nhanvien (HoTen, MaND) VALUES (?, ?)";
                    $stmtNhanVien = $conn->prepare($sqlNhanVien);
                    $stmtNhanVien->bind_param("si", $hoVaTen, $maND); // Thêm MaND vào đây
                    $stmtNhanVien->execute();
                }elseif ($quyenHan == 'Khachhang') {
                $sqlKhachHang = "INSERT INTO khachhang (HoTen, MaND) VALUES (?, ?)";
                $stmtKhachHang = $conn->prepare($sqlKhachHang);
                $stmtKhachHang->bind_param("si", $hoVaTen, $maND);
                $stmtKhachHang->execute();
                }
                header('Location: dangNhap.php');
                exit; 
            }
        }
    }
    ?>
    <div class="box">
        <h2>Đăng ký</h2>
        <form id="formDangKy" action="dangKy.php" method="post">
            <div class="dau_vao">
                <label for="hoVaTen">Họ và tên</label>
                <input type="text" id="hoVaTen" name="hoVaTen" placeholder="Nhập họ và tên" style="opacity: 0.6;">
            </div>
            <span class="error " id="hoVaTenError"> Họ và tên không được để trống</span>
            <div class="dau_vao">
                <label for="soDienThoai">Số điện thoại</label>
                <input type="text" id="soDienThoai" name="soDienThoai" placeholder="Nhập số điện thoại" style="opacity: 0.6;">
            </div>
            <span class="error" id="soDienThoaiError"> Số điện thoại không được để trống</span>
            
            <div class="gioi_tinh">
                <p>Giới tính</p>
                <input type="radio" name="gioiTinh" value="Nam">Nam
                <input type="radio" name="gioiTinh" value="Nữ">Nữ
            </div>
            <div class="dau_vao">
                <label for="tenDangNhap">Tên đăng nhập</label>
                <input type="text" id="tenDangNhap" name="tenDangNhap" placeholder="Nhập tên đăng nhập" style="opacity: 0.6;">
            </div>
            <span class="red"><?php echo empty($error) ? ' ' : $error ?></span>
            <span class="error" id="tenDangNhapError"> Tên đăng nhập không được để trống</span>

            <div class="dau_vao">
                <label for="matKhau">Mật khẩu</label>
                <input type="password" id="matKhau" name="matKhau" placeholder="Nhập mật khẩu" style="opacity: 0.6;">
                <div class="eye" onclick="togglePassword('matKhau', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
            </div>
            <span class="error" id="matKhauError"> Mật khẩu không được để trống</span>
            
            <div class="dau_vao">
                <label for="nhapLaiMatKhau">Nhập lại mật khẩu</label>
                <input type="password" id="nhapLaiMatKhau" name="nhapLaiMatKhau" placeholder="Nhập lại mật khẩu" style="opacity: 0.6;">
                <div class="eye" onclick="togglePassword('nhapLaiMatKhau', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </div>
            </div>
            <span class="error" id="nhapLaiMatKhauError">Nhập lại mật khẩu sai </span>

            <div class="quyenHan">
                <p>Quyền hạn: </p>
                <input type="radio" name="quyenHan" value="Nhanvien"> Nhân viên
                <input type="radio" name="quyenHan" value="Khachhang"> Khách hàng
            </div>
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