<?php
    include("connect.php");
    if (isset($_GET["MaNV"])){
        $MaNV = $_GET["MaNV"];
    }
    $sql = "DELETE FROM nhanvien WHERE MaNV = $MaNV";
    $result = mysqli_query($conn, $sql);
    header("Location: ../employee.php");
?>
<!-- <?php
include("connect.php");

if (isset($_GET["MaNV"])) {
    $MaNV = $_GET["MaNV"];
    
    // Bước 1: Lấy MaND tương ứng với MaNV
    $sqlMaND = "SELECT MaND FROM nhanvien WHERE MaNV = ?";
    $stmtMaND = $conn->prepare($sqlMaND);
    $stmtMaND->bind_param("i", $MaNV);
    $stmtMaND->execute();
    $resultMaND = $stmtMaND->get_result();

    if ($resultMaND && $resultMaND->num_rows > 0) {
        $rowMaND = $resultMaND->fetch_assoc();
        $MaND = $rowMaND['MaND'];

        // Bước 2: Xóa nhân viên
        $sqlDeleteEmployee = "DELETE FROM nhanvien WHERE MaNV = ?";
        $stmtDeleteEmployee = $conn->prepare($sqlDeleteEmployee);
        $stmtDeleteEmployee->bind_param("i", $MaNV);

        if ($stmtDeleteEmployee->execute()) {
            // Bước 3: Xóa người dùng
            $sqlDeleteUser = "DELETE FROM nguoidung WHERE MaND = ?";
            $stmtDeleteUser = $conn->prepare($sqlDeleteUser);
            $stmtDeleteUser->bind_param("i", $MaND);
            if ($stmtDeleteUser->execute()) {
                // Xóa thành công
                header("Location: ../employee.php");
                exit;
            } 
        } 
    } 

}
?> -->