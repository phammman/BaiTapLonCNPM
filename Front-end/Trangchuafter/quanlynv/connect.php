<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $namedatabase = "chuyendedinhhuongcnpm";
    $post = 3306;

    //thêm connect
    $conn = mysqli_connect($servername, $username, $password, $namedatabase, $post);

    //kiểm tra
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Kết nối thành công"
?>