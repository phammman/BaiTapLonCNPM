<?php
// Hiển thị lỗi trong giai đoạn dev
ini_set('display_errors', 1);
error_reporting(E_ALL);

// include connect
require_once __DIR__ . '/connect.php';

// -- Xử lý logic cho Sổ Quỹ --

// 1. Tính toán các số liệu tổng hợp (Ví dụ: trong tháng này)
$thangNay = date('Y-m');
$queryTongThu = "SELECT COALESCE(SUM(SoTien), 0) AS TongThu FROM soquy WHERE LoaiPhieu = 'Thu' AND DATE_FORMAT(NgayGhiNhan, '%Y-%m') = '$thangNay'";
$queryTongChi = "SELECT COALESCE(SUM(SoTien), 0) AS TongChi FROM soquy WHERE LoaiPhieu = 'Chi' AND DATE_FORMAT(NgayGhiNhan, '%Y-%m') = '$thangNay'";

$tongThu = $conn->query($queryTongThu)->fetch_assoc()['TongThu'];
$tongChi = $conn->query($queryTongChi)->fetch_assoc()['TongChi'];
$tonQuy = $tongThu - $tongChi; // Tồn quỹ kỳ này, chưa tính đầu kỳ

// 2. Lấy danh sách phiếu thu/chi
$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : '';
$sql = "SELECT MaPhieu, NgayGhiNhan, TenDoiTuong, LyDo, MaDH, SoTien, LoaiPhieu
        FROM soquy
        WHERE MaPhieu LIKE '%$keyword%'
           OR TenDoiTuong LIKE '%$keyword%'
           OR LyDo LIKE '%$keyword%'
        ORDER BY NgayGhiNhan DESC, MaPhieu DESC";

$result = $conn->query($sql);
if ($result === false) {
  die('SQL error: ' . $conn->error);
}
?>
<!doctype html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sổ Quỹ - Quản Lý Bán Hàng</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0b1220;
      --primary: #1373ff;
      --text: #0f172a;
      --muted: #64748b;
      --border: #e5e7eb;
      --surface: #ffffff;
      --surface-2: #f8fafc;
    }
    html, body { height: 100%; }
    body {
      margin: 0;
      font-family: Inter, system-ui, sans-serif;
      color: var(--text);
      background: var(--surface-2);
    }
    a { color: inherit; text-decoration: none; }
    .app { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
    .sidebar { background: var(--bg); color: #cbd5e1; padding: 18px 14px; display: flex; flex-direction: column; }
    .brand { display: flex; align-items: center; gap: 10px; padding: 8px 10px; margin-bottom: 8px; }
    .brand-logo { width: 28px; height: 28px; border-radius: 6px; background: linear-gradient(135deg, #0ea5e9, #3b82f6); display: grid; place-items: center; color: #fff; font-weight: 700; }
    .brand h1 { font-size: 18px; color: #fff; margin: 0; font-weight: 700; }
    .nav-item { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 10px; color: #cbd5e1; }
    .nav-item:hover { background: #0f1a33; color: #e2e8f0; }
    .nav-item.active { background: #0f1a33; color: #fff; }
    .nav-item svg { width: 18px; height: 18px; }

    .content { padding: 20px; background: var(--surface-2); }
    .card { background: var(--surface); border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .summary { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 12px; font-size: 14px; }
    .summary span { font-weight: 500; }
    .summary .green { color: #16a34a; }
    .summary .red { color: #dc2626; }
    .btn-group { margin-top: 12px; display: flex; gap: 10px; }
    .btn { background: var(--primary); border: none; color: #fff; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; transition: 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .btn:hover { background: #0f5dd7; }
    .btn.secondary { background: #f1f5f9; color: #334155; }
    .btn.secondary:hover { background: #e2e8f0; }
    .filters { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
    .filters input { border: 1px solid var(--border); border-radius: 8px; padding: 10px 12px; font-size: 14px; background: #fff; flex: 1; }
    table { width: 100%; border-collapse: collapse; background: var(--surface); border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid var(--border); font-size: 14px; }
    th { background: #f9fafb; font-weight: 600; color: #374151; }
    .money-thu { color: #16a34a; font-weight: 600; }
    .money-chi { color: #dc2626; font-weight: 600; }
    .action-links a { margin-right: 10px; font-weight: 600; }
  </style>
</head>

<body>
  <div class="app">
    <aside class="sidebar">
      <div class="brand">
        <div class="brand-logo">Q</div>
        <h1>QLYBanHang</h1>
      </div>
      <nav class="nav">
        <div class="nav-section">
          <a class="nav-item active" href="manuadmin.php">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" stroke-width="1.5" />
            </svg>
            Tổng quan
          </a>
          <a class="nav-item" href="orders.php" style="color: lightblue;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M3 7h18M3 12h18M3 17h18" stroke-width="1.5" />
            </svg> Đơn hàng</a>
          <a class="nav-item" href="products.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <rect x="3" y="4" width="18" height="14" rx="2" stroke-width="1.5" />
              <path d="M7 8h10M7 12h10" stroke-width="1.5" />
            </svg> Sản phẩm</a>
          <a class="nav-item" href="inventories.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M3 9h18M5 9V5h14v4M5 9v10h14V9" stroke-width="1.5" />
            </svg> Quản lý kho</a>
          <a class="nav-item" href="employee.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="12" cy="8" r="4" stroke-width="1.5" />
              <path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5" />
            </svg> Nhân viên</a>
          <a class="nav-item" href="customers.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="12" cy="8" r="4" stroke-width="1.5" />
              <path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5" />
            </svg> Khách hàng</a>
          <!-- <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 12h16M12 4v16" stroke-width="1.5"/></svg> Khuyến mại</a> -->
          <a class="nav-item" href="SoQuy.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.5" />
              <path d="M7 9h6M7 13h10" stroke-width="1.5" />
            </svg> Sổ quỹ</a>
          <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M4 6h16M4 12h16M4 18h10" stroke-width="1.5" />
            </svg> Báo cáo</a>
        </div>

      </nav>
    </aside>
    <main class="content">
      <div class="card">
        <h3>Báo cáo quỹ trong tháng</h3>
        <div class="summary">
          <span class="green">Tổng thu: <b><?= number_format($tongThu, 0, ',', '.') ?>đ</b></span>
          <span class="red">Tổng chi: <b><?= number_format($tongChi, 0, ',', '.') ?>đ</b></span>
          <span>Tồn quỹ: <b><?= number_format($tonQuy, 0, ',', '.') ?>đ</b></span>
        </div>
        <div class="btn-group">
          <a href="themPhieu.php" class="btn">➕ Tạo Phiếu Mới</a>
        </div>
      </div>

      <div class="card">
        <h3>Danh sách phiếu thu chi</h3>
        <form method="get" class="filters">
            <input type="text" name="keyword" placeholder="Tìm theo mã phiếu, lý do, tên đối tượng..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" class="btn secondary">Tìm kiếm</button>
        </form>

        <table>
          <thead>
            <tr>
              <th>Mã phiếu</th>
              <th>Ngày ghi nhận</th>
              <th>Loại phiếu</th>
              <th>Tên đối tượng</th>
              <th>Lý do</th>
              <th>Mã gốc</th>
              <th>Số tiền</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td>#<?= htmlspecialchars($row['MaPhieu']) ?></td>
                  <td><?= date("d/m/Y", strtotime($row['NgayGhiNhan'])) ?></td>
                  <td>
                    <span class="<?= $row['LoaiPhieu'] == 'Thu' ? 'money-thu' : 'money-chi' ?>">
                        <?= $row['LoaiPhieu'] == 'Thu' ? 'Phiếu Thu' : 'Phiếu Chi' ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($row['TenDoiTuong']) ?></td>
                  <td><?= htmlspecialchars($row['LyDo']) ?></td>
                  <td><?= $row['MaDH'] ? '<a href="suaDonHang.php?id='.$row['MaDH'].'">#DH' . htmlspecialchars($row['MaDH']) . '</a>' : '' ?></td>
                  <td class="<?= $row['LoaiPhieu'] == 'Thu' ? 'money-thu' : 'money-chi' ?>">
                    <?= ($row['LoaiPhieu'] == 'Thu' ? '+' : '-') . number_format($row['SoTien'], 0, ',', '.') ?>đ
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">Chưa có phiếu thu chi nào.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>