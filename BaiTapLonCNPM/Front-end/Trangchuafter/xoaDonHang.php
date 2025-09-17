<?php
include "connect.php";
$id = $_GET["id"];
$conn->query("DELETE FROM donhang WHERE MaDH='$id'");
header("Location: xemDonHang.php");
?>
