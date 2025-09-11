<?php
include("connect.php");
if (isset($_GET["MaNV"])) {
    $MaNV = $_GET["MaNV"];
}
if (isset($_POST["sua"])) {
    if (!empty($_POST['HoTen']) &&
    !empty($_POST['ChucVu'])){
        $HoTen = $_POST['HoTen'];
        $ChucVu = $_POST['ChucVu'];
    
        $sql = "UPDATE `nhanvien` SET `HoTen`='$HoTen',`ChucVu`='$ChucVu' WHERE MaNV = $MaNV";
        $result = mysqli_query($conn, $sql);
        header("Location: quanLyNhanVien.php");
    }
}
    $sql = "SELECT * FROM nhanvien WHERE MaNV = $MaNV";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
?>
<form action="" method="post" enctype="multipart/form-data">
        <label for="">Họ tên: </label>
            <input type="text" name = "HoTen" value = "<?php echo $row['HoTen']?>"><br>
        <label for="">Chức vụ: </label>
            <select name="ChucVu" id="loai">
                <option value="Nhân viên bán hàng" <?php echo $row['ChucVu'] == 'Nhân viên bán hàng' ? 'selected' : '  ' ?>>Nhân viên bán hàng</option>
                <option value="Nhân viên quản lý kho" <?php echo $row['ChucVu'] == 'Nhân viên quản lý kho' ? 'selected' : ' ' ?>>Nhân viên quản lý kho</option>
                <option value="Nhân viên pha chế" <?php echo $row['ChucVu'] == 'Nhân viên pha chế' ? 'selected' : ' ' ?>>Nhân viên pha chế</option>
            </select>
        <input type="submit" name="sua" value="Sửa">
    </form>