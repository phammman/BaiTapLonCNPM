<?php
include 'connect.php';

$sql = "
    SELECT DATE(dh.NgayLap) AS Ngay,
           SUM(ct.SoLuong * ct.DonGia) / COUNT(DISTINCT dh.MaDH) AS GiaTriTB
    FROM DonHang dh
    JOIN ChiTietDonHang ct ON dh.MaDH = ct.MaDH
    GROUP BY DATE(dh.NgayLap)
    ORDER BY Ngay
";
$result = $conn->query($sql);

$labels = [];
$data = [];
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['Ngay'];
    $data[]   = $row['GiaTriTB'];
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <title>Biểu đồ giá trị đơn hàng trung bình</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="max-width:900px; margin:40px auto; font-family:sans-serif;">

  <h2 style="text-align:center;">📊 Biểu đồ giá trị đơn hàng trung bình theo ngày</h2>
  <canvas id="avgChart" height="120"></canvas>

  <script>
    const labels = <?php echo json_encode($labels); ?>;
    const data = <?php echo json_encode($data); ?>;

    new Chart(document.getElementById('avgChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Giá trị trung bình (VNĐ)',
          data: data,
          borderColor: 'rgba(255, 159, 64, 1)',
          backgroundColor: 'rgba(255, 159, 64, 0.2)',
          tension: 0.3,
          fill: true,
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: value => value.toLocaleString() + ' ₫'
            }
          },
          x: {
            ticks: {
              callback: function(value, index) {
                let date = labels[index];
                return new Date(date).toLocaleDateString('vi-VN');
              }
            }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                let val = context.raw.toLocaleString();
                return " " + val + " ₫";
              }
            }
          }
        }
      }
    });
  </script>
</body>
</html>
