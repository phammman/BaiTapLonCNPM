<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        h2{
            margin: 0;
            font-size: 30px;
            padding: 10px;
        }
        table {
            font-size: 20px;
            width: 100%;
            border-collapse: collapse; /* Gộp border */
            margin: 0 40px;
        }
        th,td{
            text-align: center;
            padding: 10px;
        }
        a{
            text-decoration: none;
            color: white;
            padding: 5px 20px;
            margin: 5px;
        }
        .them{
            background-color: #24acf2;
        }
        .xem{
            background-color: rgb(8, 209, 95);
        }
        .sua{
            background-color: rgb(247, 243, 15);
            color: black;
        }
        .xoa{
            background-color: rgba(227, 20, 5, 0.72);
        }
    </style>
</head>
<body>
    <h2>Danh sách nhân viên</h2>

    <table border = 2  align = "center";>
        <tr>
            <th>Mã NV</th>
            <th>Họ tên</th>
            <th>Chức vụ</th>
            <th>
                <a class = "them" href="themNV.php">Thêm nhân viên</a>
            </th>
        </tr>
        <?php
        include("connect.php");
        $sql = "SELECT * FROM nhanvien";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $row["MaNV"];?></td>
                <td><?php echo $row["HoTen"];?></td>
                <td><?php echo $row["ChucVu"];?></td>
                <td>
                    <a class = "xem" href="xemNhanVien.php?MaNV=<?php echo $row["MaNV"];?>">Xem</a>
                    <a class = "sua" href="suaNhanVien.php?MaNV=<?php echo $row["MaNV"];?>">Sửa</a>
                    <a class = "xoa" href="xoaNhanVien.php?MaNV=<?php echo $row["MaNV"];?>">Xóa</a>
                </td>

            </tr>
        <?php  
        }
        ?>
    </table>
</body>
</html>