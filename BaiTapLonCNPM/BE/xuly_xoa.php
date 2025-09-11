<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaKH = $_POST['MaKH'];

    $sql = "DELETE FROM KhachHang WHERE MaKH=$MaKH";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
