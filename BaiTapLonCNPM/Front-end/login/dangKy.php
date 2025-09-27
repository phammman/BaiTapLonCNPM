<?php
include "../Trangchuafter/FE/connect.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangKy"])) {
    $tenDangNhap = trim($_POST["tenDangNhap"]);
    $matKhau = password_hash(trim($_POST["matKhau"]), PASSWORD_DEFAULT); 
    $hoVaTen = trim($_POST["hoVaTen"]);
    $quyenHan = $_POST["quyenHan"];

    // Kiểm tra trùng tên đăng nhập
    $checkUser = $conn->prepare("SELECT * FROM nguoidung WHERE TenDangNhap = ?");
    $checkUser->bind_param("s", $tenDangNhap);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại!'); window.history.back();</script>";
        exit;
    }

    // Thêm vào bảng nguoidung
    $stmt = $conn->prepare("INSERT INTO nguoidung (TenDangNhap, MatKhau, QuyenHan, HoVaTen, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $tenDangNhap, $matKhau, $quyenHan, $hoVaTen);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        if ($quyenHan == "Khachhang") {
            $soDienThoai = $_POST["soDienThoai"];
            $diaChi = $_POST["diaChi"];
            $email = $_POST["email"];

            $stmt2 = $conn->prepare("INSERT INTO khachhang (HoTen, DienThoai, DiaChi, Email) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("ssss", $hoVaTen, $soDienThoai, $diaChi, $email);
            $stmt2->execute();
        } else if ($quyenHan == "Nhanvien") {
            $chucVu = $_POST["chucVu"];

            $stmt3 = $conn->prepare("INSERT INTO nhanvien (HoTen, ChucVu) VALUES (?, ?)");
            $stmt3->bind_param("ss", $hoVaTen, $chucVu);
            $stmt3->execute();
        }

        echo "<script>alert('Đăng ký thành công!'); window.location='dangNhap.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi đăng ký'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="DangKy.css">
<title>Đăng ký</title>
</head>
<body>
<div class="box">
    <?php if(isset($errors['general'])): ?>
        <div class="error"><?php echo $errors['general']; ?></div>
    <?php endif; ?>
    <form method="POST" action="dangKy.php">
    <h2>Đăng ký tài khoản</h2>

    <div class="dau_vao">
        <label for="tenDangNhap">Tên đăng nhập</label>
        <input type="text" id="tenDangNhap" name="tenDangNhap" required>
    </div>

    <div class="dau_vao">
        <label for="matKhau">Mật khẩu</label>
        <input type="password" id="matKhau" name="matKhau" required>
    </div>

    <div class="dau_vao">
        <label for="hoVaTen">Họ và tên</label>
        <input type="text" id="hoVaTen" name="hoVaTen" required>
    </div>

    <div class="dau_vao">
        <label for="quyenHan">Quyền hạn</label>
        <select name="quyenHan" id="quyenHan" onchange="toggleFields()">
            <option value="Khachhang">Khách hàng</option>
            <option value="Nhanvien">Nhân viên</option>
        </select>
    </div>

    <!-- Thông tin khách hàng -->
    <div id="khachhangFields">
        <div class="dau_vao">
            <label for="soDienThoai">Số điện thoại</label>
            <input type="text" id="soDienThoai" name="soDienThoai">
        </div>
        <div class="dau_vao">
            <label for="diaChi">Địa chỉ</label>
            <input type="text" id="diaChi" name="diaChi">
        </div>
        <div class="dau_vao">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
    </div>

    <!-- Thông tin nhân viên -->
    <div id="nhanvienFields" style="display:none;">
        <div class="dau_vao">
            <label for="chucVu">Chức vụ</label>
            <input type="text" id="chucVu" name="chucVu">
        </div>
    </div>

    <button type="submit" name="dangKy">Đăng ký</button>
</form>

<script>
function toggleFields() {
    var quyen = document.getElementById("quyenHan").value;
    document.getElementById("khachhangFields").style.display = (quyen === "Khachhang") ? "block" : "none";
    document.getElementById("nhanvienFields").style.display = (quyen === "Nhanvien") ? "block" : "none";
}
</script>

</div>
</body>
</html>
