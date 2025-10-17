<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật nhân viên</title>
    <style>
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
        
        .update {
            padding: 10px 20px 30px;
            margin: 100px 0 150px 100px;
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
            width: 700px;   
        }
        .dauvao {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px; /* Khoảng cách giữa các ô */
            max-width: 680px; /* Chiều rộng tối đa của lưới */
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
            margin-top: 30px;
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
        .btn:hover{
            opacity: 0.8;
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
            if (!empty($_POST['HoTen']) && !empty($_POST['ChucVu']) && !empty($_POST['SoDienThoai']) && !empty($_POST['TenDangNhap']) && !empty($_POST['MatKhau']) && !empty($_POST['Address'])&& !empty($_POST['Email'])) {
                $HoTen = $_POST['HoTen'];
                $ChucVu = $_POST['ChucVu'];
                $SoDienThoai = $_POST['SoDienThoai'];
                $TenDangNhap = $_POST['TenDangNhap'];
                $MatKhau = $_POST['MatKhau'];
                $Address = $_POST['Address'];
                $Email = $_POST['Email'];
          
                $sqlNguoiDung = "UPDATE nguoidung SET SDT='$SoDienThoai', TenDangNhap='$TenDangNhap', MatKhau='$MatKhau' WHERE MaND = (SELECT MaND FROM nhanvien WHERE MaNV = $MaNV)";
        
                if (mysqli_query($conn, $sqlNguoiDung)) {
                    // Cập nhật thành công vào bảng người dùng
                    // Tiếp tục cập nhật thông tin nhân viên
                    $sqlNhanVien = "UPDATE nhanvien SET HoTen='$HoTen', ChucVu='$ChucVu', Email = '$Email', DiaChi = '$Address' WHERE MaNV = $MaNV";
                    if (mysqli_query($conn, $sqlNhanVien)) {
                        // Cập nhật thành công vào bảng nhân viên
                        header('Location: ../employee.php');
                        exit;
                    } 
                }
            }
        }
        $sql = "SELECT nv.*, nd.SDT,nd.QuyenHan, nd.TenDangNhap, nd.MatKhau FROM nhanvien nv 
                JOIN nguoidung nd ON nv.MaND = nd.MaND 
                WHERE nv.MaNV = $MaNV";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
?>
    <div class="container">
        <div class="sidebar">
            <div class="brand">
                <div class="brand-logo">Q</div>
                <h1>QLYBanHang</h1>
            </div>
            <nav class="nav">
                <div class="nav-section">
                    <a class="nav-item active" href="#">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" stroke-width="1.5"/></svg>
                        Tổng quan
                    </a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 7h18M3 12h18M3 17h18" stroke-width="1.5"/></svg> Đơn hàng</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 8h10M7 12h10" stroke-width="1.5"/></svg> Sản phẩm</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9h18M5 9V5h14v4M5 9v10h14V9" stroke-width="1.5"/></svg> Quản lý kho</a>
                    <a class="nav-item" href="../employee.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Nhân viên</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Khách hàng</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 9h6M7 13h10" stroke-width="1.5"/></svg> Sổ quỹ</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h10" stroke-width="1.5"/></svg> Báo cáo</a>
                </div>
            </nav>
        </div>
        <div class="update">
            <div class="title">
                <a href="../employee.php"><b>&larr;</b></a>
                <h2>Cập nhật thông tin nhân viên mã = <?php echo $row['MaNV']?></h2>
            </div>
            
            <form action="" method="post" enctype="multipart/form-data">
                <div class="box">
                    <div class="dauvao">
                        <div class="info">
                            <label for="">Họ tên: </label>
                            <input type="text" name = "HoTen" value = "<?php echo $row['HoTen']?>">
                        </div>
                        <div class="info">
                            <label for="">Số điện thoại: </label>
                            <input type="nnumber" name="SoDienThoai" value="<?php echo $row['SDT']; ?>">
                        </div>
                        <div class="info">
                            <label for="">Tên đăng nhập: </label>
                            <input type="text" name="TenDangNhap" value="<?php echo $row['TenDangNhap']; ?>">
                        </div>
                        <div class="info">
                            <label for="">Mật khẩu: </label>
                            <input type="password" name="MatKhau" value="<?php echo $row['MatKhau']; ?>">
                        </div>
                        <div class="info">
                            <label for="">Email: </label>
                            <input type="email" name="Email" value="<?php echo $row['Email']; ?>">
                        </div>
                        <div class="info">
                            <label for="">Địa chỉ: </label>
                            <input type="text" name="Address" value="<?php echo $row['DiaChi']; ?>">
                        </div>
                        <div class="info">
                            <label for="">Chức vụ: </label>
                            <select name="ChucVu" id="loai">
                                <option value="Nhân viên bán hàng" <?php echo $row['ChucVu'] == 'Nhân viên bán hàng' ? 'selected' : '  ' ?>>Nhân viên bán hàng</option>
                                <option value="Nhân viên quản lý kho" <?php echo $row['ChucVu'] == 'Nhân viên quản lý kho' ? 'selected' : ' ' ?>>Nhân viên quản lý kho</option>
                                <option value="Nhân viên pha chế" <?php echo $row['ChucVu'] == 'Nhân viên pha chế' ? 'selected' : ' ' ?>>Nhân viên pha chế</option>
                            </select>
                        </div>
                    </div>
                    <div class="btn">
                        <input type="submit" name="sua" value="Cập nhật">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>