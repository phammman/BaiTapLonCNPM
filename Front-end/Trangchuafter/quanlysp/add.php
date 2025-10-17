<?php
include __DIR__ . "/../connect.php"; // ✅ Đường dẫn chính xác
session_start();

$MaND = $_SESSION['MaND'] ?? 0;

// Nhận dữ liệu từ form
$TenSP = $_POST['TenSP'] ?? '';
$GiaBan = $_POST['GiaBan'] ?? 0;
$SoLuongTon = $_POST['SoLuongTon'] ?? 0;
$MaDM = $_POST['MaDM'] ?? 0;
$MaSKU = $_POST['MaSKU'] ?? '';
$MoTa = $_POST['MoTa'] ?? '';
$GiaVon = $_POST['GiaVon'] ?? 0;
$img = $_FILES['img'] ?? null;

// --- Xử lý upload ảnh ---
$img_path = "";

if (isset($img) && $img["error"] === UPLOAD_ERR_OK) {
    $target_dir = __DIR__ . "/../uploads/";

    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Tạo tên file duy nhất
    $file_name = time() . "_" . basename($img["name"]);
    $target_file = $target_dir . $file_name;

    // Giới hạn định dạng ảnh
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    $ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed_types)) {
        if (move_uploaded_file($img["tmp_name"], $target_file)) {
            // Lưu đường dẫn tương đối (để hiển thị ảnh sau này)
            $img_path = "uploads/" . $file_name;
        } else {
            echo "❌ Lỗi khi tải ảnh lên!";
            exit;
        }
    } else {
        echo "❌ Chỉ chấp nhận các tệp JPG, JPEG, PNG, GIF.";
        exit;
    }
}

// --- Lưu dữ liệu vào cơ sở dữ liệu ---
$sql = "INSERT INTO sanpham (TenSP, GiaBan, SoLuongTon, MaDM, MaSKU, MoTa, GiaVon, MaND, img)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdiissdis",
    $TenSP, $GiaBan, $SoLuongTon, $MaDM,
    $MaSKU, $MoTa, $GiaVon, $MaND, $img_path
);

if ($stmt->execute()) {
    // Chuyển hướng về trang danh sách sản phẩm
    header("Location: ../products.php");
    exit;
} else {
    echo "❌ Lỗi khi thêm sản phẩm: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
