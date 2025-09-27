<?php
include 'db_connect.php';

// Doanh thu theo ngày
$sql_revenue = "SELECT dh.NgayLap, SUM(ct.SoLuong * ct.DonGia) AS DoanhThu
                FROM DonHang dh
                JOIN ChiTietDonHang ct ON dh.MaDH = ct.MaDH
                GROUP BY dh.NgayLap
                ORDER BY dh.NgayLap ASC";
$result_revenue = $conn->query($sql_revenue);

$labels_rev = [];
$data_rev   = [];
$total_revenue = 0;
while ($row = $result_revenue->fetch_assoc()) {
    $labels_rev[] = $row['NgayLap'];
    $data_rev[]   = $row['DoanhThu'];
    $total_revenue += $row['DoanhThu'];
}

// Giá trị đơn hàng trung bình theo ngày
$sql_avg = "SELECT dh.NgayLap, AVG(tong.TongTien) AS GiaTriTB
            FROM DonHang dh
            JOIN (
                SELECT MaDH, SUM(SoLuong * DonGia) AS TongTien
                FROM ChiTietDonHang
                GROUP BY MaDH
            ) tong ON dh.MaDH = tong.MaDH
            GROUP BY dh.NgayLap
            ORDER BY dh.NgayLap ASC";
$result_avg = $conn->query($sql_avg);

$labels_avg = [];
$data_avg   = [];
while ($row = $result_avg->fetch_assoc()) {
    $labels_avg[] = $row['NgayLap'];
    $data_avg[]   = $row['GiaTriTB'];
}

// Tính giá trị trung bình chung của tất cả đơn hàng
$sql_avg_all = "SELECT AVG(tong.TongTien) AS GiaTriTBChung
                FROM (
                    SELECT MaDH, SUM(SoLuong * DonGia) AS TongTien
                    FROM ChiTietDonHang
                    GROUP BY MaDH
                ) tong";
$result_avg_all = $conn->query($sql_avg_all);
$row_avg_all = $result_avg_all->fetch_assoc();
$avg_all = $row_avg_all['GiaTriTBChung'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="margin:20px; font-family:Arial, sans-serif; background:#f5f5f5;">
    <h2 style="margin-bottom:20px;">📊 Dashboard Thống kê</h2>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <!-- Doanh thu theo ngày -->
        <div style="background:#fff; border:1px solid #ddd; border-radius:8px; padding:15px;">
            <h3 style="font-size:16px; margin-bottom:10px; text-align:center;">Doanh thu theo ngày</h3>
             <p style="margin-top:10px; text-align:center; font-weight:bold; color:#2c7;">
                <?php echo number_format($total_revenue, 0, ',', '.'); ?> VND
            </p>
            <canvas id="chartRevenue"></canvas>
            <!-- <p style="margin-top:10px; text-align:center; font-weight:bold; color:#2c7;">Tổng doanh thu: 
                <?php echo number_format($total_revenue, 0, ',', '.'); ?> VND
            </p> -->
        </div>

        <!-- Giá trị đơn hàng trung bình -->
        <div style="background:#fff; border:1px solid #ddd; border-radius:8px; padding:15px;">
            <h3 style="font-size:16px; margin-bottom:10px; text-align:center;">Giá trị đơn hàng trung bình</h3>
            <p style="margin-top:10px; text-align:center; font-weight:bold; color:#c33;">
                <?php echo number_format($avg_all, 0, ',', '.'); ?> VND
            </p>
            <canvas id="chartAvgOrder"></canvas>
            <!-- <p style="margin-top:10px; text-align:center; font-weight:bold; color:#c33;">Giá trị TB chung: 
                <?php echo number_format($avg_all, 0, ',', '.'); ?> VND
            </p> -->
        </div>


        <!-- <div style="background:#fff; border:1px dashed #ccc; border-radius:8px; padding:15px; display:flex; align-items:center; justify-content:center; color:#aaa;">
            Biểu đồ khác
        </div>


        <div style="background:#fff; border:1px dashed #ccc; border-radius:8px; padding:15px; display:flex; align-items:center; justify-content:center; color:#aaa;">
            Biểu đồ khác
        </div> -->
    </div>

    <script>
        // Doanh thu
        new Chart(document.getElementById('chartRevenue').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_rev); ?>,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: <?php echo json_encode($data_rev); ?>,
                    borderColor: 'rgba(54,162,235,1)',
                    backgroundColor: 'rgba(54,162,235,0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: { responsive: true }
        });

        // Giá trị đơn hàng trung bình
        new Chart(document.getElementById('chartAvgOrder').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels_avg); ?>,
                datasets: [{
                    label: 'Giá trị TB (VND)',
                    data: <?php echo json_encode($data_avg); ?>,
                    borderColor: 'rgba(255,99,132,1)',
                    backgroundColor: 'rgba(255,99,132,0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>
