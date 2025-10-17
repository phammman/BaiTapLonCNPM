<?php
include 'connect.php';

// Lấy số lượng đơn hàng theo ngày (bỏ đơn "Đã hủy")
$sql = "
    SELECT NgayLap AS Ngay, COUNT(*) AS SoLuongDon
    FROM DonHang
    WHERE TrangThai IS NULL OR TrangThai != 'Đã hủy'
    GROUP BY NgayLap
    ORDER BY NgayLap ASC
";
$result = $conn->query($sql);

$labels = [];
$data = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['Ngay'];
        $data[]   = $row['SoLuongDon'];
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8" />
<title>Biểu đồ đơn hàng theo ngày</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f7fb; margin:0; padding:28px; color:#17202a;">
    <div style="max-width:980px; margin:0 auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 6px 18px rgba(23,32,42,0.06);">
        <div style="font-size:20px; font-weight:700; margin-bottom:18px;">
            Biểu đồ số lượng đơn hàng theo ngày
        </div>
        <canvas id="orderChart" style="width:100%; height:400px;"></canvas>
    </div>

<script>
const ctx = document.getElementById('orderChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels, JSON_UNESCAPED_UNICODE); ?>,
        datasets: [{
            label: 'Số lượng đơn',
            data: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>,
            borderColor: '#ff7a59',
            backgroundColor: 'rgba(255,122,89,0.15)',
            fill: true,
            tension: 0.3,
            borderWidth: 2,
            pointRadius: 5,
            pointBackgroundColor: '#ff7a59'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: { font: { size: 14 } }
            }
        },
        scales: {
            x: {
                title: { display: true, text: 'Ngày', font: { size: 14 } }
            },
            y: {
                title: { display: true, text: 'Số đơn', font: { size: 14 } },
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
</body>
</html>
