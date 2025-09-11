<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            font-size: 20px;
            border-collapse: collapse; /* Gộp border */
            margin: 0 40px;
        }
        th,td{
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php
    include("connect.php");
    if (isset($_GET["MaNV"])) {
        $MaNV = $_GET["MaNV"];
    }
    $sql = "SELECT * FROM nhanvien WHERE MaNV = $MaNV";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <table border = 2 align = center>
        <tr>
            <th>Mã NV</th>
            <td><?php echo $row['MaNV'];?></td>
        </tr>
        <tr>
            <th>Họ và tên</th>
            <td><?php echo $row['HoTen'];?></td>
        </tr>
        <tr>
            <th>Chức vụ</th>
            <td><?php echo $row['ChucVu'];?></td>
        </tr>
    </table>
    <a href="quanLyNhanVien.php">Trở lại</a>
</body>
</html>