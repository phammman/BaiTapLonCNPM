<?php
include __DIR__ . "/../connect.php"; // ✅ Đường dẫn chính xác

session_start();
$MaND = $_SESSION['MaND'] ?? 0;

$HoTen = $_POST['HoTen'] ?? '';
$ChucVu = $_POST['ChucVu'] ?? '';
$SDT = $_POST['SDT'] ?? 0;
$Email = $_POST['Email'] ?? '';
$DiaChi = $_POST['DiaChi'] ?? '';

$sql = "INSERT INTO nhanvien (HoTen, ChucVu, SDT, Email, DiaChi, MaND)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdiiss", 
    $HoTen, $ChucVu, $SDT, $Email, $DiaChi, $MaND
);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: ../employee.php");
exit;
?>
