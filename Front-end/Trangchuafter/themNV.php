
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân viên</title>
    <style>
        html, body { height: 100%; }
        body{background-color: #f8fafc;
        margin: 0; font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
}
        .container {
        display: flex; grid-template-columns: 260px 1fr;min-height: 100vh;
        }
        .sidebar { background-color: #0b1220; color: #cbd5e1; width: 250px; padding: 18px 14px; display: flex; flex-direction: column;}
        .brand { display:flex; align-items:center; gap:10px; padding: 8px 10px; margin-bottom: 8px; }
        .brand-logo { width:28px; height:28px; border-radius:6px; background: linear-gradient(135deg,#0ea5e9,#3b82f6); display:grid; place-items:center; color:#fff; font-weight:700; }
        .brand h1 { font-size: 18px; color:#fff; margin:0; font-weight:700; letter-spacing:.2px; }
        .nav { margin-top: 8px; width: 230px;}
        .nav-section { margin-top: 14px; }
        .nav-section a{color: inherit; text-decoration: none;}
        .nav-item { display:flex; align-items:center;margin: 5px 0; gap:15px; width: 200px; padding: 10px 12px; border-radius:10px; color:#cbd5e1; }
        .nav-item:hover { background: #0f1a33; color:#e2e8f0; }
        .nav-item.active { background: #0f1a33; color:#fff; }
        .nav-item svg { width:18px; height:18px; color:#94a3b8; }

        .creat {
            padding: 20px 25px;
            margin: 100px ;
            margin-left: 100px;
        }
        .title {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .title a{
            font-size: 20px;
            text-decoration: none;
            color: gray;
            padding: 5px 15px;
            margin: 0 5px;
            border-radius: 5px;
            border:1px solid #cecece;
            display: flex; 
            align-items: center;
        }
        .title b{
            font-size: 20px;
            padding-bottom: 2px;
        }
        .title a:hover{
            background-color: #bdbdbd;
        }
        .title h2{
            margin: 0;
            margin-left: 10px;
        }
        .info-basic{
            margin: 10px;
            font-size: 22px;
        }
        .box{
            background-color: #fff;
            font-size: 20px;
            padding: 10px 20px 20px 20px;
            border: 2px solid #dbdbdb;
            border-radius: 10px;
            width: 750px;   
        }
        .dauvao {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px; /* Khoảng cách giữa các ô */
            max-width: 720px; /* Chiều rộng tối đa của lưới */
            margin: auto; /* Canh giữa lưới */
            /* margin: 0; */
        }
        .info {
            display: flex;
            flex-direction: column;
        }
        .info input, 
        .info select{
            border: 1px solid #cecece;
            border-radius: 5px;
            font-size: 16px;
            padding: 5px 10px;
            margin: 10px;
        }
        .gioi_tinh p{
            margin: 0;
        }
        .gioi_tinh input{
            margin: 15px 10px;
            margin-left: 15px;
        }
        .btn{
            margin-top: 25px;
            display: flex;
            justify-self: center;
            align-items: center;
        }
        .btn input{
            border-radius: 5px;
            border: 1px solid #acacac;
            padding: 5px 20px;
            font-size: 20px;
            background-color: rgb(0 136 255);
            margin: 0 5px;
            cursor: pointer;
            color: white;
        }
        .btn:hover{ opacity: 0.8;}
        
    </style>
</head>
<body>
    <?php
    
include("connect.php");

if (isset($_POST["them"])) {
    // Kiểm tra các trường bắt buộc
    if (!empty($_POST['HoTen']) && !empty($_POST['ChucVu']) && 
        !empty($_POST['SoDienThoai']) && !empty($_POST['GioiTinh']) && 
        !empty($_POST['TenDangNhap']) && !empty($_POST['MatKhau'])) {
        
        $HoTen = $_POST['HoTen'];
        $ChucVu = $_POST['ChucVu'];
        $SoDienThoai = $_POST['SoDienThoai'];
        $GioiTinh = $_POST['GioiTinh'];
        $TenDangNhap = $_POST['TenDangNhap'];
        $MatKhau = $_POST['MatKhau']; 

        // Bước 1: Thêm người dùng vào bảng nguoidung
        $sqlUser = "INSERT INTO nguoidung (HoTen, SoDienThoai, GioiTinh, TenDangNhap, MatKhau, QuyenHan) VALUES (?, ?, ?, ?, ?, 'NhanVien')";
        $stmtUser = $conn->prepare($sqlUser);
        $stmtUser->bind_param("sssss", $HoTen, $SoDienThoai,$GioiTinh, $TenDangNhap, $MatKhau);
        
        if ($stmtUser->execute()) {
            $MaND = $stmtUser->insert_id; // Lấy MaND vừa tạo

            // Bước 2: Thêm nhân viên vào bảng nhanvien
            $sqlEmployee = "INSERT INTO nhanvien (HoTen, ChucVu, MaND) VALUES (?, ?, ?)";
            $stmtEmployee = $conn->prepare($sqlEmployee);
            $stmtEmployee->bind_param("ssi", $HoTen, $ChucVu, $MaND);
            if ($stmtEmployee->execute()) {
                header("Location: quanLyNhanVien.php");
                exit;
            } else {
                echo "Error adding employee: " . $conn->error;
            }
            $stmtEmployee->close();
        } else {
            echo "Error adding user: " . $conn->error;
        }
        $stmtUser->close();
    } 
}
?>
    <div class="container">
        <div class="sidebar">
            <div class="brand">
                <div class="brand-logo">Q</div>
                <h1>QLYBanHang</h1>
            </div>
            <div class="nav">
                <div class="nav-section">
                <a class="nav-item active" href="#">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" stroke-width="1.5"/></svg>
                    Tổng quan
                </a>
                <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 7h18M3 12h18M3 17h18" stroke-width="1.5"/></svg> Đơn hàng</a>
                <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 8h10M7 12h10" stroke-width="1.5"/></svg> Sản phẩm</a>
                <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9h18M5 9V5h14v4M5 9v10h14V9" stroke-width="1.5"/></svg> Quản lý kho</a>
                <a class="nav-item" href="quanLyNhanVien.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Nhân viên</a>
                <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Khách hàng</a>
                <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 9h6M7 13h10" stroke-width="1.5"/></svg> Sổ quỹ</a>
                <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h10" stroke-width="1.5"/></svg> Báo cáo</a>
                </div>
            </div>
        </div>
        <div class="creat">
            <div class="title">
                <a href="quanLyNhanVien.php"><b>&larr;</b></a>
                <h2>Thêm mới nhân viên</h2>
            </div>
            <form id="formThemNV" action="" method="post">
                <div class="box">
                    <p class="info-basic">Thông tin cơ bản</p>
                    <div class="dauvao">
                        <div class="info">
                            <label for="">Họ tên: </label>
                            <input type="text" id="HoTen" name = "HoTen" value = "" placeholder="Nhập họ và tên" style="opacity: 0.6;">
                            <span style="font-size: 18px; color: red; padding-left: 20px; display: none;" class="error" id="HoTenError"> Họ và tên không được để trống</span>
                        </div>

                        <div class="info">
                            <label for="">Số điện thoại: </label>
                            <input type="text" id="SoDienThoai" name="SoDienThoai" value="" placeholder="Nhập số điện thoại" style="opacity: 0.6;">
                            <span style="font-size: 18px; color: red; padding-left: 20px; display: none;" class="error" id="SoDienThoaiError"> Số điện thoại không được để trống</span>
                        </div>

                        <div class="info">
                            <label for="">Tên đăng nhập: </label>
                            <input type="text" id="TenDangNhap" name="TenDangNhap" value="" placeholder="Nhập tên đăng nhập" style="opacity: 0.6;">
                            <span style="font-size: 18px; color: red; padding-left: 20px; display: none;" class="error" id="TenDangNhapError"> Tên đăng nhập không được để trống</span>
                        </div>

                        <div class="info">
                            <label for="">Mật khẩu: </label>
                            <input type="password" id="MatKhau" name="MatKhau" value="" placeholder="Nhập mật khẩu" style="opacity: 0.6;">
                            <span style=" font-size: 18px; color: red; padding-left: 20px; display: none;" class="error" id="MatKhauError"> Mật khẩu không được để trống</span>
                        </div>

                        <div class="gioi_tinh">
                            <p>Giới tính:</p>
                            <input type="radio" name="GioiTinh" value="Nam">Nam
                            <input type="radio" name="GioiTinh" value="Nữ">Nữ <br>
                            <span style="font-size: 18px; color: red; padding-left: 20px; display: none;" class="error" id="GioiTinhError"> Giới tính không được để trống</span>
                        </div>

                        <div class="info">
                            <label for="">Chức vụ: </label>                    
                                <select name="ChucVu" >
                                <option value="Nhân viên bán hàng">Nhân viên bán hàng</option>
                                <option value="Nhân viên quản lý kho">Nhân viên quản lý kho</option>
                                <option value="Nhân viên pha chế">Nhân viên pha chế</option>
                            </select>
                        </div>
                    </div>              
                </div>
                <div class="btn">
                    <input type="submit" name="them" value="Thêm ">
                </div>
            </form>        
        </div>
    </div>
    <script>
        var formThemNV = document.getElementById('formThemNV')
        var HoTen = document.getElementById('HoTen');
        var SoDienThoai = document.getElementById('SoDienThoai');
        var TenDangNhap = document.getElementById('TenDangNhap');
        var MatKhau = document.getElementById('MatKhau');

        var HoTenError = document.getElementById('HoTenError');
        var SoDienThoaiError = document.getElementById('SoDienThoaiError');
        var TenDangNhapError = document.getElementById('TenDangNhapError');
        var MatKhauError = document.getElementById('MatKhauError');
        var GioiTinhError = document.getElementById('GioiTinhError');

        formThemNV.addEventListener("submit", function (e) { 
            var check = true;
            if (HoTen.value.trim() === "") { 
                check = false;
                HoTenError.style.display = "block";
            }
            else { 
                HoTenError.style.display = "none";
            }

            if (SoDienThoai.value.trim() === "") { 
                SoDienThoaiError.style.display = "block";
            } else {
                SoDienThoaiError.style.display = "none";
            }

            if (TenDangNhap.value.trim() === "") {
                check = false;
                TenDangNhapError.style.display = "block";
            } else {
                TenDangNhapError.style.display = "none";
            }

            if (MatKhau.value.trim() === "") {
                check = false;
                MatKhauError.style.display = "block";
            } else {
                MatKhauError.style.display = "none";
            }
            var genderSelected = document.querySelector('input[name="GioiTinh"]:checked');
            if (!genderSelected) {
                check = false;
                GioiTinhError.style.display = "block";
            } else {
                GioiTinhError.style.display = "none";
            }
                if (!check) {
                    e.preventDefault();
                }
            })
    </script>
</body>
</html>