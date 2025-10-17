<?php
// Kết nối database
include 'connect.php';

// Truy vấn lấy sản phẩm + tên danh mục
$sql = "SELECT sp.MaSP, sp.TenSP, sp.SoLuongTon, sp.GiaBan, sp.MaSKU, sp.MoTa, sp.GiaVon, dm.TenDM 
        FROM SanPham sp 
        LEFT JOIN DanhMuc dm ON sp.MaDM = dm.MaDM";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin menu</title>
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
    .main { display:grid; gap: 18px; padding: 18px; }

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
  </style>
</head>
<body>
  <div class="app">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand">
        <div class="brand-logo">Q</div>
        <h1>QLYBanHang</h1>
      </div>

      <nav class="nav">
        <div class="nav-section">
          <a class="nav-item" href="manuadmin.php">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" stroke-width="1.5"/></svg>
            Tổng quan
          </a>
          <a class="nav-item" href="orders.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 7h18M3 12h18M3 17h18" stroke-width="1.5"/></svg> Đơn hàng</a>
          <a class="nav-item active" href="products.php" style="color: lightblue;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 8h10M7 12h10" stroke-width="1.5"/></svg> Sản phẩm</a>
          <a class="nav-item" href="inventories.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9h18M5 9V5h14v4M5 9v10h14V9" stroke-width="1.5"/></svg> Quản lý kho</a>
          <a class="nav-item" href="employee.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Nhân viên</a>
          <a class="nav-item" href="customers.php" ><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Khách hàng</a>
          <!-- <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 12h16M12 4v16" stroke-width="1.5"/></svg> Khuyến mại</a> -->
          <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 9h6M7 13h10" stroke-width="1.5"/></svg> Sổ quỹ</a>
          <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h10" stroke-width="1.5"/></svg> Báo cáo</a>
        </div>

      </nav>

      <!-- <div class="sidebar-footer">Cấu hình</div> -->
    </aside>

    <!-- CONTENT -->
    <section class="content">
      <!-- Top bar -->
      <div class="topbar">
        <div class="search">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><circle cx="11" cy="11" r="7" stroke-width="1.6"/><path d="M20 20l-3.5-3.5" stroke-width="1.6"/></svg>
          <input placeholder="Tìm kiếm" />
          
        </div>
        <div class="topbar-actions">
          <button class="icon-btn" title="Thông báo"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5" stroke-width="1.5"/><path d="M10 19a2 2 0 0 0 4 0" stroke-width="1.5"/></svg></button>
          <div class="avatar">cu</div>
        </div>
      </div>

      <!-- Main -->
    <div class="main">
        <!-- Left column -->
        <div class="left">

            <div class="left">
                <div class="card">
                <div class="card-hd">Danh sách sản phẩm</div>
                <div class="card-bd">
                    <!-- Tabs -->
                    <div style="border-bottom:1px solid var(--border); padding-bottom:12px; margin-bottom:12px;">
                    <nav style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                        <button style="background:transparent; border:none; color:var(--primary); font-weight:700; padding:8px 12px; border-bottom:3px solid var(--primary);">Tất cả</button>
                        </div>
                        <div style="display:flex; gap:8px; align-items:center;">
                        <a href="#"><button class="btn primary">Thêm sản phẩm</button></a>
                        </div>
                    </nav>

                    <div style="margin-top:12px; display:flex; gap:12px; align-items:center;">
                        <input placeholder="Tìm kiếm theo mã sản phẩm, tên sản phẩm, barcode" style="flex:1; padding:12px 14px; border:1px solid var(--border); border-radius:10px; background:#fff;" />
                        <!-- <div style="display:flex; gap:8px;">
                        <select style="padding:8px 10px; border:1px solid var(--border); border-radius:8px; background:#fff;"><option>Kênh bán hàng</option></select>
                        <select style="padding:8px 10px; border:1px solid var(--border); border-radius:8px; background:#fff;"><option>Loại sản phẩm</option></select>
                        <select style="padding:8px 10px; border:1px solid var(--border); border-radius:8px; background:#fff;"><option>Tag</option></select>
                        <button class="btn">Bộ lọc khác</button>
                        </div> -->
                    </div>
                    </div>

                    <!-- Table -->
                    <div class="card-bd">

              <!-- Bảng sản phẩm -->
              <div style="overflow:auto;">
              <table style="width:100%; border-collapse:collapse; background:#fff;">
                <thead>
                  <tr style="background:#fafafa; color:var(--muted); text-align:left;">
                    <th style="width:48px; padding:14px; border-bottom:1px solid var(--border);"><input type="checkbox" /></th>
                    <th style="padding:14px; border-bottom:1px solid var(--border);">Sản phẩm</th>
                    <th style="padding:14px; border-bottom:1px solid var(--border); width:120px;">Có thể bán</th>
                    <th style="padding:14px; border-bottom:1px solid var(--border); width:150px;">Loại</th>
                    <th style="padding:14px; border-bottom:1px solid var(--border); width:200px;">Nhãn hiệu</th>
                    <th style="padding:14px; border-bottom:1px solid var(--border); width:160px;">Giá</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($result->num_rows > 0): ?>
                      <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                          <td style="padding:14px; border-bottom:1px solid #f1f5f9;">
                            <input type="checkbox" />
                          </td>
                          <td style="padding:14px; border-bottom:1px solid #f1f5f9;">
                            <div style="display:flex; align-items:center; gap:12px;">
                              <div style="width:48px; height:48px; border-radius:8px; background:#f1f5f9; display:grid; place-items:center; color:var(--muted);">📷</div>
                              <a href="#" style="color:var(--primary); font-weight:500;">
                                <?= htmlspecialchars($row['TenSP']) ?>
                              </a>
                            </div>
                          </td>
                          <td style="padding:14px; border-bottom:1px solid #f1f5f9;"><?= $row['SoLuongTon'] ?></td>
                          <td style="padding:14px; border-bottom:1px solid #f1f5f9;"><?= htmlspecialchars($row['TenDM'] ?? '') ?></td>
                          <td style="padding:14px; border-bottom:1px solid #f1f5f9;"><?= htmlspecialchars($row['MaSKU'] ?? '-') ?></td>
                          <td style="padding:14px; border-bottom:1px solid #f1f5f9;"><?= number_format($row['GiaBan'],0,',','.') ?> đ</td>
                        </tr>
                      <?php endwhile; ?>
                  <?php else: ?>
                        <tr>
                          <td colspan="6" style="text-align:center; padding:14px;">Chưa có sản phẩm nào</td>
                        </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              </div>

            </div>

                    <!-- Footer controls -->
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px;">
                    <div style="color:var(--muted);">Từ 1 đến 1 trên tổng 1</div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="color:var(--muted);">Hiển thị</div>
                        <select style="padding:6px 8px; border:1px solid var(--border); border-radius:6px;"><option>20</option></select>
                    </div>
                    </div>

                    <div style="text-align:center; margin-top:18px; color:var(--muted);">
                    Tìm hiểu thêm về <a href="#">sản phẩm</a>
                    </div>
                </div>
                </div>
            </div>

        </div> 
    </div>
    </section>
  </div>

  <!-- Gợi ý dùng với PHP: đổi tên file thành index.php, nhúng các phần header/sidebar bằng include nếu muốn. Không cần backend để chạy giao diện. -->
</body>
</html>
