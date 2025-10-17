<?php
session_start();
include(__DIR__ . "/../connect.php");

if (!isset($_SESSION['MaND'])) {
    die("Bạn chưa đăng nhập!");
}

$MaND = $_SESSION['MaND'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaKH = $_POST["MaKH"] ?? null;
    $MaNV = $_POST["MaNV"] ?? null;
    $TenKH = $_POST["TenKH"] ?? '';
    $NgayLap = $_POST["NgayLap"] ?? date("Y-m-d");
    $ThanhTien = $_POST["ThanhTien"] ?? 0;
    $TrangThai = $_POST["TrangThai"] ?? "Chờ xử lý";

    // ✅ Kiểm tra mã khách hàng
    $checkKH = $conn->prepare("SELECT MaKH FROM khachhang WHERE MaKH = ?");
    $checkKH->bind_param("i", $MaKH);
    $checkKH->execute();
    $checkKH->store_result();
    if ($checkKH->num_rows === 0) {
        echo "<script>
                alert('Khách hàng không tồn tại. Vui lòng chọn lại!');
                window.history.back();
              </script>";
        exit();
    }
    $checkKH->close();

    // ✅ Kiểm tra mã nhân viên
    $checkNV = $conn->prepare("SELECT MaNV FROM nhanvien WHERE MaNV = ?");
    $checkNV->bind_param("i", $MaNV);
    $checkNV->execute();
    $checkNV->store_result();
    if ($checkNV->num_rows === 0) {
        echo "<script>
                alert('Nhân viên không tồn tại. Vui lòng chọn lại!');
                window.history.back();
              </script>";
        exit();
    }
    $checkNV->close();

    // ✅ Thêm đơn hàng
    $sql = "INSERT INTO donhang (MaKH, MaNV, NgayLap, ThanhTien, TrangThai, MaND, TenKH)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }

    $stmt->bind_param("iisdsss", $MaKH, $MaNV, $NgayLap, $ThanhTien, $TrangThai, $MaND, $TenKH);

    if ($stmt->execute()) {
        $MaDH = $stmt->insert_id; // ✅ Lấy mã đơn hàng vừa thêm

        // ✅ Thêm chi tiết đơn hàng (nếu có sản phẩm)
        if (!empty($_POST["MaSP"]) && !empty($_POST["soluong"])) {
            $MaSPs = $_POST["MaSP"];
            $soluongs = $_POST["soluong"];

            $sql_ct = "INSERT INTO chitietdonhang (MaDH, MaSP, SoLuong) VALUES (?, ?, ?)";
            $stmt_ct = $conn->prepare($sql_ct);

            if ($stmt_ct) {
                for ($i = 0; $i < count($MaSPs); $i++) {
                    $MaSP = (int)$MaSPs[$i];
                    $SoLuong = (int)$soluongs[$i];
                    $stmt_ct->bind_param("iii", $MaDH, $MaSP, $SoLuong);
                    $stmt_ct->execute();
                }
                $stmt_ct->close();
            }
        }

        echo "<script>
                alert('Thêm đơn hàng thành công!');
                window.location.href = '/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/orders.php';
              </script>";
    } else {
        echo "<script>
                alert('Lỗi khi thêm đơn hàng!');
                window.history.back();
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
