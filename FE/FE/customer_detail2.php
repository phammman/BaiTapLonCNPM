<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Kết nối thất bại: " . $conn->connect_error); }

// Lấy thông tin khách hàng theo MaKH (ví dụ ?MaKH=1)
$MaKH = isset($_GET['MaKH']) ? intval($_GET['MaKH']) : 1;

$sql_kh = "SELECT * FROM KhachHang WHERE MaKH = $MaKH";
$khachhang = $conn->query($sql_kh)->fetch_assoc();

// Lấy đơn hàng mới nhất
$sql_dh_moi = "SELECT * FROM DonHang WHERE MaKH = $MaKH ORDER BY NgayLap DESC LIMIT 1";
$donhang_moi = $conn->query($sql_dh_moi)->fetch_assoc();

// Lấy tất cả đơn hàng để tính tổng chi tiêu & chi tiêu TB
$sql_dh_all = "SELECT dh.MaDH, dh.NgayLap, dh.TrangThai, SUM(ct.SoLuong * ct.DonGia) AS TongTien
               FROM DonHang dh
               JOIN ChiTietDonHang ct ON dh.MaDH = ct.MaDH
               WHERE dh.MaKH = $MaKH
               GROUP BY dh.MaDH";
$result_all = $conn->query($sql_dh_all);

$tong_chi_tieu = 0;
$so_don = 0;
$donhangs = [];
while($row = $result_all->fetch_assoc()) {
    $donhangs[] = $row;
    $tong_chi_tieu += $row['TongTien'];
    $so_don++;
}
$chi_tieu_tb = $so_don > 0 ? $tong_chi_tieu / $so_don : 0;
?>

<div style="font-family:Arial, sans-serif; max-width:1200px; margin:20px auto;">

  <!-- Hồ sơ khách hàng -->
  <div style="background:#fff; border:1px solid #ddd; border-radius:8px; padding:20px; margin-bottom:20px;">
    <div style="display:flex; align-items:center; gap:15px; margin-bottom:15px;">
      <div style="width:60px; height:60px; border-radius:50%; background:#f28b82; display:flex; align-items:center; justify-content:center; color:#fff; font-size:20px; font-weight:bold;">
        <?php echo strtoupper(substr($khachhang['HoTen'],0,2)); ?>
      </div>
      <div>
        <div style="font-size:18px; font-weight:600; margin-bottom:4px;"><?php echo $khachhang['HoTen']; ?></div>
        <div style="font-size:13px; color:#666;">Khách hàng</div>
      </div>
    </div>

    <div style="display:flex; justify-content:space-between; text-align:center;">
      <div>
        <div style="font-size:13px; color:#666;">Đơn hàng mới nhất</div>
        <?php if ($donhang_moi) { ?>
          <a href="#" style="color:#007bff; font-size:14px; text-decoration:none;">#<?php echo $donhang_moi['MaDH']; ?></a>
        <?php } else { echo "<div style='font-size:14px;'>Chưa có</div>"; } ?>
      </div>
      <div>
        <div style="font-size:13px; color:#666;">Tổng chi tiêu</div>
        <div style="font-size:14px; font-weight:600;"><?php echo number_format($tong_chi_tieu,0,",","."); ?>₫</div>
      </div>
      <div>
        <div style="font-size:13px; color:#666;">Chi tiêu trung bình</div>
        <div style="font-size:14px; font-weight:600;"><?php echo number_format($chi_tieu_tb,0,",","."); ?>₫</div>
      </div>
    </div>
  </div>

  <!-- Đơn hàng gần đây -->
  <div style="background:#fff; border:1px solid #ddd; border-radius:8px; padding:20px; margin-bottom:20px;">
    <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
      <h3 style="margin:0; font-size:16px;">Đơn hàng gần đây</h3>
      <a href="#" style="font-size:14px; color:#007bff; text-decoration:none;">Danh sách đơn hàng</a>
    </div>

    <?php 
    if ($so_don == 0) { echo "<p style='color:#888;'>Chưa có đơn hàng nào</p>"; }
    foreach ($donhangs as $dh) { 
        // Style trạng thái
        if ($dh['TrangThai'] == "Hoàn thành") {
            $bg = "#e6f4ea"; $color = "#137333";
        } elseif ($dh['TrangThai'] == "Chờ xử lý") {
            $bg = "#f2f2f2"; $color = "#555";
        } else {
            $bg = "#fff"; $color = "#000";
        }
    ?>
      <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee;">
        <div>
          <a href="#" style="color:#007bff; font-size:14px; text-decoration:none;">#<?php echo $dh['MaDH']; ?></a>
          <span style="color:#666; font-size:13px; margin-left:8px;"><?php echo $dh['NgayLap']; ?></span>
        </div>
        <div style="text-align:right;">
          <span style="background:<?php echo $bg; ?>; color:<?php echo $color; ?>; padding:3px 8px; border-radius:12px; font-size:12px; margin-right:5px;">
            <?php echo $dh['TrangThai']; ?>
          </span>
          <div style="margin-top:4px; font-size:14px; font-weight:600;"><?php echo number_format($dh['TongTien'],0,",","."); ?>₫</div>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Liên hệ + Địa chỉ -->
  <div style="background:#fff; border:1px solid #ddd; border-radius:8px; padding:20px;">
    <h3 style="margin:0 0 10px 0; font-size:16px;">Liên hệ</h3>
    <p style="margin:5px 0; color:#007bff;"><?php echo $khachhang['Email']; ?></p>
    <p style="margin:5px 0;"><?php echo $khachhang['HoTen']; ?></p>
    <p style="margin:5px 0;"><?php echo $khachhang['DienThoai']; ?></p>
    <h4 style="margin:15px 0 5px 0; font-size:14px;">Địa chỉ</h4>
    <p style="margin:5px 0;"><?php echo $khachhang['DiaChi']; ?></p>

    <!-- Button chỉnh sửa -->
    <button onclick="window.location.href='edit_customer.php?MaKH=<?php echo $khachhang['MaKH']; ?>'" 
            style="margin-top:15px; padding:8px 14px; background:#007bff; color:#fff; border:none; border-radius:5px; cursor:pointer; font-size:14px;">
      Chỉnh sửa
    </button>
  </div>

</div>
