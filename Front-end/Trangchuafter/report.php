<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'connect.php';

$MaND = $_SESSION['MaND'] ?? null; // lấy mã người dùng hiện tại


$sqlRevenue = "
    SELECT SUM(ct.SoLuong * ct.DonGia) AS DoanhThu
    FROM chitietdonhang ct
    JOIN donhang dh ON ct.MaDH = dh.MaDH
    WHERE dh.MaND = '$MaND'

";
$revenue = $conn->query($sqlRevenue)->fetch_assoc()['DoanhThu'] ?? 0;

$sqlProfit = "
    SELECT SUM((ct.DonGia - sp.GiaVon) * ct.SoLuong) AS LoiNhuan
    FROM chitietdonhang ct
    JOIN donhang dh ON ct.MaDH = dh.MaDH
    JOIN SanPham sp ON ct.MaSP = sp.MaSP
    WHERE dh.MaND = '$MaND'

";
$profit = $conn->query($sqlProfit)->fetch_assoc()['LoiNhuan'] ?? 0;

$sqlOrders = "SELECT COUNT(*) AS SoDH FROM donhang WHERE MaND = '$MaND'";
$orders = $conn->query($sqlOrders)->fetch_assoc()['SoDH'] ?? 0;

$sqlProductsSold = "
    SELECT SUM(ct.SoLuong) AS TongSoLuong
    FROM chitietdonhang ct
    JOIN donhang dh ON ct.MaDH = dh.MaDH
    WHERE dh.MaND = '$MaND'
";

$productsSold = $conn->query($sqlProductsSold)->fetch_assoc()['TongSoLuong'] ?? 0;


// Doanh thu theo ngày
$sql_revenue = "SELECT dh.NgayLap, SUM(ct.SoLuong * ct.DonGia) AS DoanhThu
                FROM donhang dh
                JOIN chitietdonhang ct ON dh.MaDH = ct.MaDH
                WHERE dh.MaND = '$MaND'
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
            FROM donhang dh
            JOIN (
                SELECT MaDH, SUM(SoLuong * DonGia) AS TongTien
                FROM chitietdonhang
                GROUP BY MaDH
            ) tong ON dh.MaDH = tong.MaDH
            WHERE dh.MaND = '$MaND'
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


$sql_avg_all = "
    SELECT AVG(tong.TongTien) AS GiaTriTBChung
    FROM (
        SELECT ct.MaDH, SUM(ct.SoLuong * ct.DonGia) AS TongTien
        FROM chitietdonhang ct
        JOIN donhang dh ON ct.MaDH = dh.MaDH
        WHERE dh.MaND = '$MaND'
        GROUP BY ct.MaDH
    ) tong
";
$result_avg_all = $conn->query($sql_avg_all);
$avg_all = ($result_avg_all && $row = $result_avg_all->fetch_assoc()) ? $row['GiaTriTBChung'] : 0;


$sql_products = "
SELECT
    sp.MaSP,
    sp.TenSP,
    sp.MaSKU,
    sp.GiaBan,
    COALESCE(SUM(ct.SoLuong), 0) AS SoLuongBan,
    COALESCE(SUM(ct.SoLuong * ct.DonGia), 0.00) AS DoanhThu
FROM SanPham sp
JOIN chitietdonhang ct ON sp.MaSP = ct.MaSP
JOIN donhang dh ON dh.MaDH = ct.MaDH
WHERE (dh.TrangThai IS NULL OR dh.TrangThai != 'Đã hủy')
    AND dh.MaND = '$MaND'
GROUP BY sp.MaSP, sp.TenSP, sp.MaSKU, sp.GiaBan
ORDER BY DoanhThu DESC
LIMIT 5
";
$result = $conn->query($sql_products);
$topProducts = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $topProducts[] = $row;
    }
}
function format_vnd($num) {
    return number_format((float)$num, 0, '.', ',') . ' ₫';
}

// --- Số lượng đơn hàng theo ngày ---
$sql_orders = "
    SELECT NgayLap, COUNT(*) AS SoLuong
    FROM donhang
    WHERE MaND = '$MaND'
    GROUP BY NgayLap
    ORDER BY NgayLap ASC
";
$res_orders = $conn->query($sql_orders);

$labels_orders = [];
$data_orders = [];
while ($row = $res_orders->fetch_assoc()) {
    $labels_orders[] = $row['NgayLap'];
    $data_orders[] = $row['SoLuong'];
}
?>

<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin menu</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0b1220;           /* sidebar */
      --bg-2: #0e172a;         /* darker */
      --primary: #1373ff;      /* brand blue */
      --text: #0f172a;         /* main text */
      --muted: #64748b;        /* secondary */
      --border: #e5e7eb;       /* borders */
      --surface: #ffffff;      /* cards */
      --surface-2: #f8fafc;    /* page */
      --chip: #eef2ff;         /* light chip */
    }
    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body {
      margin: 0; font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
      color: var(--text); background: var(--surface-2);
    }
    a { color: inherit; text-decoration: none; }
    .app {
      display: grid; grid-template-columns: 260px 1fr; min-height: 100vh;
    }
    /* Sidebar */
    .sidebar { background: var(--bg); color: #cbd5e1; padding: 18px 14px; display: flex; flex-direction: column; }
    .brand { display:flex; align-items:center; gap:10px; padding: 8px 10px; margin-bottom: 8px; }
    .brand-logo { width:28px; height:28px; border-radius:6px; background: linear-gradient(135deg,#0ea5e9,#3b82f6); display:grid; place-items:center; color:#fff; font-weight:700; }
    .brand h1 { font-size: 18px; color:#fff; margin:0; font-weight:700; letter-spacing:.2px; }
    .nav { margin-top: 8px; }
    .nav-section { margin-top: 14px; }
    .nav-title { font-size: 11px; letter-spacing:.08em; text-transform:uppercase; color:#64748b; padding: 8px 12px; }
    .nav-item { display:flex; align-items:center; gap:12px; padding: 10px 12px; border-radius:10px; color:#cbd5e1; }
    .nav-item:hover { background: #0f1a33; color:#e2e8f0; }
    .nav-item.active { background: #0f1a33; color:#fff; }
    .nav-item svg { width:18px; height:18px; color:#94a3b8; }
    .sidebar-footer { margin-top:auto; padding: 8px 12px; color:#94a3b8; font-size: 12px; }

    /* Header */
    .content { display:flex; flex-direction:column; }
    .topbar { background:#fff; border-bottom:1px solid var(--border); padding: 10px 18px; display:flex; align-items:center; gap:14px; }
    .search { flex:1; display:flex; align-items:center; gap:10px; background:#f1f5f9; border:1px solid #e2e8f0; padding:10px 12px; border-radius:10px; }
    .search input { flex:1; border:none; outline:none; background:transparent; font-size:14px; }
    .topbar-actions { display:flex; align-items:center; gap:12px; }
    .chip { font-size:12px; padding:6px 10px; border-radius:999px; background: var(--chip); color:#3730a3; font-weight:600; }
    .icon-btn { width:36px; height:36px; display:grid; place-items:center; border:1px solid var(--border); background:#fff; border-radius:10px; cursor:pointer; }
    .avatar { width:32px; height:32px; border-radius:50%; background:#22c55e; display:grid; place-items:center; color:#fff; font-weight:700; }

    /* Main layout */
    /* .main { display:grid; grid-template-columns: 1fr 320px; gap: 18px; padding: 18px; } */

    /* Banner */
    .banner { background:#eff6ff; border:1px dashed #bfdbfe; padding:12px 14px; border-radius:10px; display:flex; align-items:center; justify-content:space-between; gap:12px; }
    .banner strong { color:#1d4ed8; }
    .btn { display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; border:1px solid var(--border); background:#fff; cursor:pointer; font-weight:600; }
    .btn.primary { background: var(--primary); color:#fff; border-color: var(--primary); }

    /* Cards */
    .card { background:#fff; border:1px solid var(--border); border-radius:12px; }
    .card .card-hd { padding:14px; border-bottom:1px solid var(--border); font-weight:600; }
    .card .card-bd { padding: 14px; }

    .grid-2 { display:grid; grid-template-columns: 1fr 1fr; gap:14px; }
    .kpis { display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:12px; }
    .kpi { background:#fff; border:1px solid var(--border); border-radius:12px; padding:14px; }
    .kpi .label { color: var(--muted); font-size:12px; }
    .kpi .value { font-size:28px; font-weight:700; margin-top: 4px; }
    .kpi .muted { color: var(--muted); font-size:12px; }

    /* Right column widgets */
    .widget { background:#fff; border:1px solid var(--border); border-radius:12px; padding: 14px; }
    .widget + .widget { margin-top: 14px; }
    .list { list-style:none; padding:0; margin:0; }
    .list li { display:flex; align-items:start; gap:10px; padding:10px 0; border-bottom:1px solid #f1f5f9; }
    .list li:last-child { border-bottom:none; }
    .badge { font-size:11px; padding:4px 8px; border-radius:999px; background:#ecfeff; color:#0891b2; font-weight:600; }

    /* Steps */
    .steps { display:grid; gap:10px; }
    .step { display:flex; gap:12px; align-items:flex-start; padding:10px; border:1px dashed #e5e7eb; border-radius:10px; background:#fafafa; }
    .step .n { width:24px; height:24px; border-radius:999px; display:grid; place-items:center; background:#e2e8f0; font-size:12px; font-weight:700; }
    .step .actions { margin-left:auto; }

    /* Responsive */
    @media (max-width: 1180px) { .kpis { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 980px) {
      .app { grid-template-columns: 1fr; }
      .sidebar { position: sticky; top:0; z-index:4; flex-direction: row; overflow:auto; gap:8px; }
      .nav, .nav-section, .sidebar-footer, .nav-title { display:none; }
      .brand { margin:0; }
      .main { grid-template-columns: 1fr; }
    }
    .avatar-container {
      position: relative;
      display: inline-block;
    }

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
    }

    .dropdown {
      display: none; /* ẩn mặc định */
      position: absolute;
      top: 50px; /* nằm dưới avatar */
      right: 0;
      background-color: white;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      min-width: 200px;
      z-index: 1000;
    }

    .dropdown-item {
      padding: 10px 15px;
      cursor: pointer;
    }

    .dropdown-item:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
  <div class="app">
    <!-- SIDEBAR -->
    <?php include 'headafter.php' ?>

    <!-- CONTENT -->
    <section class="content">
      <!-- Top bar -->
      <?php include 'topbar.php'?>

      <!-- Main -->
      <div class="main">
        <!-- Left column -->
        <div class="left" style="margin:20px; font-family:Arial, sans-serif; background:#f5f5f5;">
          
        <h2 style="margin-bottom:20px;">📊 Dashboard Thống kê</h2>

        <div style="display: flex; gap: 20px; margin: 20px; justify-content: center;">


    <div style="flex:1; background:white; border-radius:8px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <div style="font-size:14px; color:#555; border-bottom:1px dashed #ddd; padding-bottom:5px;">Doanh thu thuần</div>
        <div style="font-size:26px; font-weight:bold; margin:10px 0; color:#111;">
            <?= number_format($revenue,0,',','.') ?>₫
        </div>
    </div>


    <div style="flex:1; background:white; border-radius:8px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <div style="font-size:14px; color:#555; border-bottom:1px dashed #ddd; padding-bottom:5px;">Lợi nhuận gộp</div>
        <div style="font-size:26px; font-weight:bold; margin:10px 0; color:#111;">
            <?= number_format($profit,0,',','.') ?>₫
        </div>
    </div>

    <div style="flex:1; background:white; border-radius:8px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <div style="font-size:14px; color:#555; border-bottom:1px dashed #ddd; padding-bottom:5px;">Đơn hàng</div>
        <div style="font-size:26px; font-weight:bold; margin:10px 0; color:#111;">
            <?= $orders ?>
        </div>
    </div>

    <div style="flex:1; background:white; border-radius:8px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <div style="font-size:14px; color:#555; border-bottom:1px dashed #ddd; padding-bottom:5px;">Số lượng hàng bán</div>
        <div style="font-size:26px; font-weight:bold; margin:10px 0; color:#111;">
            <?= number_format($productsSold,0,',','.') ?>
        </div>
    </div>

</div>

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


        <div style="background:#fff; border:1px solid #ddd; border-radius:8px; padding:15px;">
        <h3 style="font-size:16px; margin-bottom:10px; text-align:center;">Top 5 sản phẩm bán chạy</h3>
        <?php if (!$topProducts): ?>
            <div style="padding:20px; text-align:center; color:#666;">Chưa có dữ liệu bán hàng.</div>
        <?php else: ?>
            <table style="width:100%; border-collapse:collapse; font-size:14px; margin-top:10px;">
                <thead>
                    <tr>
                        <th style="padding:8px; text-align:center; border-bottom:1px solid #eee;">#</th>
                        <th style="padding:8px; text-align:left; border-bottom:1px solid #eee;">Sản phẩm</th>
                        <th style="padding:8px; text-align:center; border-bottom:1px solid #eee;">Đã bán</th>
                        <th style="padding:8px; text-align:right; border-bottom:1px solid #eee;">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($topProducts as $i => $p): ?>
                    <tr>
                        <td style="padding:8px; text-align:center; border-bottom:1px solid #f2f2f2; font-weight:bold;"><?php echo $i+1; ?></td>
                        <td style="padding:8px; border-bottom:1px solid #f2f2f2;">
                            <div style="font-weight:600;"><?php echo htmlspecialchars($p['TenSP']); ?></div>
                            <?php if (!empty($p['MaSKU'])): ?>
                                <div style="font-size:12px; color:#666;">SKU: <?php echo htmlspecialchars($p['MaSKU']); ?></div>
                            <?php endif; ?>
                        </td>
                        <td style="padding:8px; text-align:center; border-bottom:1px solid #f2f2f2;"><?php echo number_format((int)$p['SoLuongBan']); ?></td>
                        <td style="padding:8px; text-align:right; border-bottom:1px solid #f2f2f2;"><?php echo format_vnd($p['DoanhThu']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Số lượng đơn hàng theo ngày -->
    <div style="background:#fff; border:1px solid #ddd; border-radius:8px; padding:15px;">
        <h3 style="font-size:16px; margin-bottom:10px; text-align:center;">Số lượng đơn hàng theo ngày</h3>
        <p style="margin-top:10px; text-align:center; font-weight:bold; color:#06c;">
            <?php echo array_sum($data_orders); ?> đơn
        </p>
        <canvas id="chartOrders"></canvas>
    </div>
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

        



    new Chart(document.getElementById('chartOrders').getContext('2d'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels_orders); ?>,
            datasets: [{
                label: 'Số đơn',
                data: <?php echo json_encode($data_orders); ?>,
                borderColor: 'rgba(0,123,255,1)',
                backgroundColor: 'rgba(0,123,255,0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: { 
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,   // mỗi nấc tăng 1
                        precision: 0   // đảm bảo chỉ số nguyên
                    },
                    title: {
                        display: true,
                        text: 'Số đơn'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Ngày'
                    }
                }
            }
        }
    });


    </script>
            
          
        </div> 
      </div>
    </section>
  </div>

  <!-- Gợi ý dùng với PHP: đổi tên file thành index.php, nhúng các phần header/sidebar bằng include nếu muốn. Không cần backend để chạy giao diện. -->
</body>
</html>