<?php
include __DIR__ . "/../connect.php";

// Lấy dữ liệu từ form
$masp = $_POST['MaSP'] ?? '';
$tensp = $_POST['TenSP'] ?? '';
$giaban = $_POST['GiaBan'] ?? '';
$soluongton = $_POST['SoLuongTon'] ?? '';
$madm = $_POST['MaDM'] ?? '';
$masku = $_POST['MaSKU'] ?? '';
$mota = $_POST['MoTa'] ?? '';
$giavon = $_POST['GiaVon'] ?? '';
$old_img = $_POST['old_img'] ?? ''; // ảnh cũ (nếu có)

// Xử lý upload ảnh mới (nếu có)
$img = $old_img; // mặc định giữ ảnh cũ

if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
    $uploadDir = "../uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES['img']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
        $img = "uploads/" . $fileName; // đường dẫn lưu trong CSDL
    }
}

// Cập nhật vào CSDL
$capnhat_sql = "UPDATE sanpham 
                SET TenSP = ?, GiaBan = ?, SoLuongTon = ?, MaDM = ?, MaSKU = ?, MoTa = ?, GiaVon = ?, img = ?
                WHERE MaSP = ?";

$stmt = $conn->prepare($capnhat_sql);
$stmt->bind_param("sdiissdsi", 
    $tensp, $giaban, $soluongton, $madm, 
    $masku, $mota, $giavon, $img, $masp
);
$stmt->execute();
$stmt->close();

header("Location: ../products.php");
exit;
?>
