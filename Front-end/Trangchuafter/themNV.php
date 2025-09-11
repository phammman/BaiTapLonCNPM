<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <?php
    include("connect.php");
    if (isset($_POST["them"])) {
        if (!empty($_POST['HoTen']) &&
        !empty($_POST['ChucVu'])) {
            $HoTen = $_POST['HoTen'];
            $ChucVu = $_POST['ChucVu'];

            $sql = "INSERT INTO `nhanvien`(`HoTen`, `ChucVu`) VALUES ('$HoTen','$ChucVu')";
            $result = mysqli_query($conn, $sql);
            header("Location: quanLyNhanVien.php");
        }
    }
    ?>
    <form action="" method="post">
        <label for="">Họ tên: </label>
            <input type="text" name="HoTen" id="">
        <label for="">Chức vụ: </label>
            <select name="ChucVu" id="loai">
                <option value="Nhân viên bán hàng">Nhân viên bán hàng</option>
                <option value="Nhân viên quản lý kho">Nhân viên quản lý kho</option>
                <option value="Nhân viên pha chế">Nhân viên pha chế</option>
            </select>
        <input type="submit" name="them" value="Thêm nhân viên">

    </form>
</body>
</html>