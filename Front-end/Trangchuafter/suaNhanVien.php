<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật nhân viên</title>
    <style>
        body { background-color: #f8fafc; margin: 0; font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";}
        .container { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh;}
        .sidebar { background-color: #0b1220; color: #cbd5e1; width: 250px; height:100%; padding: 18px 14px; display: flex; flex-direction: column;}
        .brand { display:flex; align-items:center; gap:10px; padding: 8px 10px; margin-bottom: 8px; }
        .brand-logo { width:28px; height:28px; border-radius:6px; background: linear-gradient(135deg,#0ea5e9,#3b82f6); display:grid; place-items:center; color:#fff; font-weight:700; }
        .brand h1 { font-size: 18px; color:#fff; margin:0; font-weight:700; letter-spacing:.2px; }
        .nav { margin-top: 8px; width: 230px;}
        .nav-section { margin-top: 14px; }
        .nav-section a{color: inherit; text-decoration: none;}
        .nav-title { font-size: 11px; letter-spacing:.08em; text-transform:uppercase; color:#64748b; padding: 8px 12px; }
        .nav-item { display:flex; align-items:center;margin: 5px 0; gap:15px; width: 200px; padding: 10px 12px; border-radius:10px; color:#cbd5e1; }
        .nav-item:hover { background: #0f1a33; color:#e2e8f0; }
        .nav-item.active { background: #0f1a33; color:#fff; }
        
        
        .update {
            border: 2px solid #dbdbdb; border-radius: 5px; padding: 10px 20px 30px; margin: 100px auto; width: 50%; height: 300px;
        }
        .title {
            font-size: 20px; margin:0; border-bottom: 1px solid #979494; margin: 0 0px 20px 0px;
        }
        .main{
            margin: 0 auto;
        }
        .info{
            margin: 10px; font-size: 20px;
        }
        .info input, 
        select{
            border: 1px solid #cecece; border-radius: 3px; width: 50%; font-size: 16px; padding: 5px 10px;
        }
        .btn{
            margin-top: 30px; display: flex; justify-self: center;
        }
        .btn a{
            font-size: 20px;text-decoration: none; color: white; padding: 5px 20px; margin: 0 5px; border-radius: 5px; background-color: #1C8552;
        }
        .btn input{
            border-radius: 5px; border: 1px solid #acacac; padding: 5px 20px; font-size: 20px;background-color: #24ACF2; margin: 0 5px; cursor: pointer;color: white;
        }
    </style>
</head>
<body>
    <?php
        include("connect.php");
        if (isset($_GET["MaNV"])) {
            $MaNV = $_GET["MaNV"];
        }
        if (isset($_POST["sua"])) {
            if (!empty($_POST['HoTen']) && !empty($_POST['ChucVu']) && !empty($_POST['SoDienThoai']) && !empty($_POST['TenDangNhap']) && !empty($_POST['MatKhau'])) {
                $HoTen = $_POST['HoTen'];
                $ChucVu = $_POST['ChucVu'];
                $SoDienThoai = $_POST['SoDienThoai'];
                $TenDangNhap = $_POST['TenDangNhap'];
                $MatKhau = $_POST['MatKhau'];

                $sqlNguoiDung = "UPDATE nguoidung SET SoDienThoai='$SoDienThoai', TenDangNhap='$TenDangNhap', MatKhau='$MatKhau' WHERE MaND = (SELECT MaND FROM nhanvien WHERE MaNV = $MaNV)";
        
                if (mysqli_query($conn, $sqlNguoiDung)) {
                    // Cập nhật thành công vào bảng người dùng
                    // Tiếp tục cập nhật thông tin nhân viên
                    $sqlNhanVien = "UPDATE nhanvien SET HoTen='$HoTen', ChucVu='$ChucVu' WHERE MaNV = $MaNV";
                    if (mysqli_query($conn, $sqlNhanVien)) {
                        // Cập nhật thành công vào bảng nhân viên
                        header('Location: quanLyNhanVien.php');
                        exit;
                    } else {
                        echo "Lỗi cập nhật thông tin nhân viên: " . mysqli_error($conn);
                    }
                } else {
                    echo "Lỗi cập nhật thông tin người dùng: " . mysqli_error($conn);
                }
            }
        }
        $sql = "SELECT nv.*, nd.SoDienThoai, nd.TenDangNhap, nd.MatKhau FROM nhanvien nv JOIN nguoidung nd ON nv.MaND = nd.MaND WHERE nv.MaNV = $MaNV";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
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
                        Tổng quan
                    </a>
                    <a href="" class="nav-item">Đơn hàng</a>
                    <a href="" class="nav-item">Sản phẩm</a>
                    <a href="" class="nav-item">Quản lý kho</a>
                    <a href="quanLyNhanVien.php" class="nav-item">Nhân viên</a>
                    <a href="" class="nav-item">Sổ quỹ</a>
                    <a href="" class="nav-item">Khách hàng</a>
                    <a href="" class="nav-item">Báo cáo</a>
                </div>
            </div>
        </div>
        <div class="update">
            <div class="title">
                <h2>Cập nhật thông tin nhân viên</h2>
            </div>
                <div class="main">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="info">
                            <label for="">Họ tên: </label>
                            <input type="text" name = "HoTen" value = "<?php echo $row['HoTen']?>"><br>
                        </div>
                        <div class="info">
    <label for="">Số điện thoại: </label>
    <input type="text" name="SoDienThoai" value="<?php echo $row['SoDienThoai']; ?>"><br>
</div>

<div class="info">
    <label for="">Tên đăng nhập: </label>
    <input type="text" name="TenDangNhap" value="<?php echo $row['TenDangNhap']; ?>"><br>
</div>

<div class="info">
    <label for="">Mật khẩu: </label>
    <input type="password" name="MatKhau" value="<?php echo $row['MatKhau']; ?>"><br>
</div>
                        <div class="info">
                            <label for="">Chức vụ: </label>
                            <select name="ChucVu" id="loai">
                                <option value="Nhân viên bán hàng" <?php echo $row['ChucVu'] == 'Nhân viên bán hàng' ? 'selected' : '  ' ?>>Nhân viên bán hàng</option>
                                <option value="Nhân viên quản lý kho" <?php echo $row['ChucVu'] == 'Nhân viên quản lý kho' ? 'selected' : ' ' ?>>Nhân viên quản lý kho</option>
                                <option value="Nhân viên pha chế" <?php echo $row['ChucVu'] == 'Nhân viên pha chế' ? 'selected' : ' ' ?>>Nhân viên pha chế</option>
                            </select>
                        </div>
                        <div class="btn">
                            <a href="quanLyNhanVien.php">Trở lại</a>
                            <input type="submit" name="sua" value="Cập nhật">
                        </div>
                    </form>
                </div>
            </div>
    </div>
</body>
</html>