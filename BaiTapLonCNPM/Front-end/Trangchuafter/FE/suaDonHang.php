<?php
// Hiển thị lỗi để dễ dàng gỡ lỗi
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "connect.php";

// Kiểm tra xem ID có hợp lệ không
if (!isset($_GET["id"]) || !filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
    die("ID đơn hàng không hợp lệ.");
}
$id = $_GET["id"];

// 1. Lấy thông tin đơn hàng hiện tại (dùng prepared statement)
$stmt = $conn->prepare("SELECT * FROM donhang WHERE MaDH = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    die("Không tìm thấy đơn hàng có ID là " . htmlspecialchars($id));
}

// 2. Lấy danh sách khách hàng và nhân viên để hiển thị trong dropdown
$customers = $conn->query("SELECT MaKH, HoTen FROM khachhang ORDER BY HoTen");
$employees = $conn->query("SELECT MaNV, HoTen FROM nhanvien ORDER BY HoTen"); // Giả sử bạn có bảng 'nhanvien'

$message = '';

// 3. Xử lý khi người dùng nhấn nút "Cập nhật"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ngayLap = $_POST["NgayLap"];
    $trangThai = $_POST["TrangThai"];
    $maKH = $_POST["MaKH"];
    $maNV = $_POST["MaNV"];

    // Cập nhật đơn hàng (dùng prepared statement để bảo mật)
    $update_stmt = $conn->prepare("UPDATE donhang SET NgayLap = ?, TrangThai = ?, MaKH = ?, MaNV = ? WHERE MaDH = ?");
    $update_stmt->bind_param("ssiii", $ngayLap, $trangThai, $maKH, $maNV, $id);

    if ($update_stmt->execute()) {
        // ===================================================================
        // BẮT ĐẦU: LOGIC TỰ ĐỘNG CẬP NHẬT SỔ QUỸ KHI TRẠNG THÁI THAY ĐỔI
        // ===================================================================
        if ($trangThai == 'Hoàn thành' || $trangThai == 'Đã thanh toán') {
            // Lấy tổng tiền thực tế của đơn hàng
            $queryOrderInfo = $conn->prepare(
                "SELECT kh.HoTen, COALESCE(SUM(ct.SoLuong * ct.DonGia), 0) AS TongTien
                 FROM donhang dh
                 JOIN khachhang kh ON dh.MaKH = kh.MaKH
                 LEFT JOIN chitietdonhang ct ON dh.MaDH = ct.MaDH
                 WHERE dh.MaDH = ?
                 GROUP BY kh.HoTen"
            );
            $queryOrderInfo->bind_param("i", $id);
            $queryOrderInfo->execute();
            $orderInfoResult = $queryOrderInfo->get_result();

            if ($orderInfoResult->num_rows > 0) {
                $orderInfo = $orderInfoResult->fetch_assoc();
                $tongTienDonHang = $orderInfo['TongTien'];
                $tenKhachHang = $orderInfo['HoTen'];

                // Chỉ tạo phiếu thu nếu đơn hàng có giá trị > 0
                if ($tongTienDonHang > 0) {
                    // Kiểm tra để tránh tạo phiếu thu trùng lặp
                    $checkExist = $conn->prepare("SELECT MaPhieu FROM soquy WHERE MaDH = ?");
                    $checkExist->bind_param("i", $id);
                    $checkExist->execute();
                    if ($checkExist->get_result()->num_rows == 0) {
                        // Nếu chưa có, tạo phiếu thu mới
                        $lyDo = "Thu tiền bán hàng cho đơn hàng #" . $id;
                        $sqlPhieuThu = $conn->prepare(
                            "INSERT INTO soquy (NgayGhiNhan, LoaiPhieu, SoTien, LyDo, MaDH, TenDoiTuong, MaNV)
                             VALUES (CURDATE(), 'Thu', ?, ?, ?, ?, ?)"
                        );
                        $sqlPhieuThu->bind_param("dsisi", $tongTienDonHang, $lyDo, $id, $tenKhachHang, $maNV);
                        $sqlPhieuThu->execute();
                        $sqlPhieuThu->close();
                    }
                    $checkExist->close();
                }
            }
            $queryOrderInfo->close();
        }
        // ===================================================================
        // KẾT THÚC: LOGIC TỰ ĐỘNG CẬP NHẬT SỔ QUỸ
        // ===================================================================
        
        header("Location: orders.php?status=updated");
        exit();
    } else {
        $message = "Lỗi khi cập nhật: " . $conn->error;
    }
    $update_stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa đơn hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Inter, Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }
        .container {
            background: #fff;
            padding: 25px 35px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        .container h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: 0.3s;
            box-sizing: border-box;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }
        button[type="submit"], .btn-back {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        button[type="submit"] {
            background: #4CAF50;
            color: #fff;
        }
        button[type="submit"]:hover {
            background: #45a049;
        }
        .btn-back {
            margin-top: 12px;
            background: #6c757d;
            color: #fff;
        }
        .btn-back:hover {
            background: #5a6268;
        }
        .message {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>✏️ Sửa đơn hàng #<?= htmlspecialchars($order["MaDH"]) ?></h2>
    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="NgayLap">Ngày Lập:</label>
            <input type="date" id="NgayLap" name="NgayLap" value="<?= htmlspecialchars($order["NgayLap"]) ?>" required>
        </div>
        <div class="form-group">
            <label for="TrangThai">Trạng Thái:</label>
            <input type="text" id="TrangThai" name="TrangThai" value="<?= htmlspecialchars($order["TrangThai"]) ?>" placeholder="VD: Đang xử lý, Hoàn thành, Đã hủy" required>
        </div>
        <div class="form-group">
            <label for="MaKH">Khách hàng:</label>
            <select id="MaKH" name="MaKH" required>
                <option value="">-- Chọn khách hàng --</option>
                <?php while($row = $customers->fetch_assoc()): ?>
                    <option value="<?= $row['MaKH'] ?>" <?= ($order['MaKH'] == $row['MaKH']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['HoTen']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="MaNV">Nhân viên phụ trách:</label>
            <select id="MaNV" name="MaNV" required>
                <option value="">-- Chọn nhân viên --</option>
                <?php while($row = $employees->fetch_assoc()): ?>
                    <option value="<?= $row['MaNV'] ?>" <?= ($order['MaNV'] == $row['MaNV']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['HoTen']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit">Cập nhật đơn hàng</button>
        <a href="orders.php" class="btn-back">Quay lại danh sách</a>
    </form>
</div>
</body>
</html>