<?php
session_start();
include '../connect.php'; // kết nối CSDL

$MaND = $_SESSION['MaND'] ?? 0;

if ($MaND == 0) {
    echo "❌ Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.";
    exit;
}

// Nhận dữ liệu từ form hoặc AJAX
$MaSP = $_POST['MaSP'] ?? 0;
$SoLuong = $_POST['SoLuong'] ?? 1;

// Kiểm tra sản phẩm tồn tại
$sql_check = "SELECT * FROM sanpham WHERE MaSP = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $MaSP);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows == 0) {
    echo "❌ Sản phẩm không tồn tại!";
    exit;
}

$stmt_check->close();

// Lấy mã giỏ hàng dựa vào người dùng
$sql_cart = "SELECT MaGH FROM giohang WHERE MaKH = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $MaND);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

if ($result_cart->num_rows > 0) {
    // Đã có giỏ hàng -> lấy MaGH
    $row_cart = $result_cart->fetch_assoc();
    $MaGH = $row_cart['MaGH'];
} else {
    // Tạo giỏ hàng mới
    $sql_insert_cart = "INSERT INTO giohang (MaKH, NgayThem) VALUES (?, NOW())";
    $stmt_insert_cart = $conn->prepare($sql_insert_cart);
    $stmt_insert_cart->bind_param("i", $MaND);
    $stmt_insert_cart->execute();
    $MaGH = $stmt_insert_cart->insert_id;
    $stmt_insert_cart->close();
}
$stmt_cart->close();

// Kiểm tra xem sản phẩm đã có trong giỏ chưa
$sql_check_item = "SELECT * FROM chitietgiohang WHERE MaGH = ? AND MaSP = ?";
$stmt_check_item = $conn->prepare($sql_check_item);
$stmt_check_item->bind_param("ii", $MaGH, $MaSP);
$stmt_check_item->execute();
$result_item = $stmt_check_item->get_result();

if ($result_item->num_rows > 0) {
    // Nếu đã có sản phẩm thì cập nhật số lượng
    $sql_update = "UPDATE chitietgiohang SET SoLuong = SoLuong + ?, NgayThem = NOW() 
                   WHERE MaGH = ? AND MaSP = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $SoLuong, $MaGH, $MaSP);
    $stmt_update->execute();
    $stmt_update->close();
} else {
    // Nếu chưa có thì thêm mới
    $sql_insert_item = "INSERT INTO chitietgiohang (MaGH, MaKH, MaSP, SoLuong, NgayThem)
                        VALUES (?, ?, ?, ?, NOW())";
    $stmt_insert_item = $conn->prepare($sql_insert_item);
    $stmt_insert_item->bind_param("iiii", $MaGH, $MaND, $MaSP, $SoLuong);
    $stmt_insert_item->execute();
    $stmt_insert_item->close();
}

echo "✅ Thêm vào giỏ hàng thành công!";
$conn->close();
?>
