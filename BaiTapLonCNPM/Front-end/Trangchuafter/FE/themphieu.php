<?php
require_once __DIR__ . '/connect.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ngayGhiNhan = $_POST['ngayGhiNhan'];
    $loaiPhieu = $_POST['loaiPhieu'];
    $soTien = $_POST['soTien'];
    $lyDo = $conn->real_escape_string($_POST['lyDo']);
    $tenDoiTuong = $conn->real_escape_string($_POST['tenDoiTuong']);
    $maNV = 1; // Giả sử mã nhân viên đang đăng nhập là 1, bạn cần thay bằng logic lấy mã NV thực tế

    if (!empty($ngayGhiNhan) && !empty($loaiPhieu) && !empty($soTien) && !empty($lyDo)) {
        $sql = "INSERT INTO soquy (NgayGhiNhan, LoaiPhieu, SoTien, LyDo, TenDoiTuong, MaNV)
                VALUES ('$ngayGhiNhan', '$loaiPhieu', '$soTien', '$lyDo', '$tenDoiTuong', '$maNV')";

        if ($conn->query($sql) === TRUE) {
            header("Location: SoQuy.php");
            exit();
        } else {
            $message = "Lỗi: " . $conn->error;
        }
    } else {
        $message = "Vui lòng điền đầy đủ thông tin bắt buộc.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo Phiếu Thu/Chi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: Inter, sans-serif; background-color: #f8fafc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h2 { text-align: center; color: #0f172a; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;
        }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #1373ff; box-shadow: 0 0 0 2px rgba(19, 115, 255, 0.2); }
        .btn { width: 100%; padding: 12px; background: #1373ff; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #0f5dd7; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #64748b; text-decoration: none; }
        .message { color: #dc2626; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>➕ Tạo Phiếu Thu / Chi</h2>
    <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="loaiPhieu">Loại phiếu *</label>
            <select id="loaiPhieu" name="loaiPhieu" required>
                <option value="Thu">Phiếu Thu</option>
                <option value="Chi">Phiếu Chi</option>
            </select>
        </div>
        <div class="form-group">
            <label for="ngayGhiNhan">Ngày ghi nhận *</label>
            <input type="date" id="ngayGhiNhan" name="ngayGhiNhan" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
            <label for="soTien">Số tiền (VNĐ) *</label>
            <input type="number" id="soTien" name="soTien" placeholder="Nhập số tiền" required>
        </div>
        <div class="form-group">
            <label for="lyDo">Lý do *</label>
            <input type="text" id="lyDo" name="lyDo" placeholder="VD: Chi tiền văn phòng phẩm" required>
        </div>
        <div class="form-group">
            <label for="tenDoiTuong">Tên đối tượng</label>
            <input type="text" id="tenDoiTuong" name="tenDoiTuong" placeholder="VD: Khách hàng A, Nhà cung cấp B">
        </div>
        <button type="submit" class="btn">Lưu Phiếu</button>
        <a href="SoQuy.php" class="btn-back">Hủy</a>
    </form>
</div>
</body>
</html>