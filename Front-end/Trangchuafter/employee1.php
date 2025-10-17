<?php
session_start();
// Kết nối database
$servername = "localhost";
$username = "root"; // thay bằng user MySQL của bạn
$password = "";     // mật khẩu (nếu có)
$dbname = "chuyendedinhhuongcnpm"; // thay bằng tên database của bạn
$MaND = $_SESSION['MaND'];


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn danh sách nhân viên + tài khoản
$sql = "SELECT nv.MaNV, nv.HoTen, nv.ChucVu, nd.TenDangNhap, nd.QuyenHan
        FROM NhanVien nv
        LEFT JOIN NguoiDung nd ON nv.MaNV = nd.MaNV
        WHERE nv.MaND = '$MaND'";


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
    /* * { box-sizing: border-box; } */
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
    <?php include 'headafter.php'; ?>

    <!-- CONTENT -->
    <section class="content">
      <!-- Top bar -->
      <?php include 'topbar.php'; ?>

      <!-- Main -->
    <div class="main">
        <!-- Left column -->
        <div class="left">

            <div class="left">
                <div class="card">
                <div class="card-hd">Danh sách nhân viên</div>
                <div class="card-bd">
                    <!-- Tabs -->
                    <div style="border-bottom:1px solid var(--border); padding-bottom:12px; margin-bottom:12px;">
                    <nav style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                        <button style="background:transparent; border:none; color:var(--primary); font-weight:700; padding:8px 12px; border-bottom:3px solid var(--primary);">Tất cả</button>
                        </div>
                        <div style="display:flex; gap:8px; align-items:center;">
                        <a href="quanlynv/add_nv.php"><button class="btn primary">Thêm nhân viên</button></a>
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
                    <div style="overflow:auto;">
            <table style="width:100%; border-collapse:collapse; background:#fff;">
              <thead>
                <tr style="background:#fafafa; color:var(--muted); text-align:left;">
                  <th style="width:48px; padding:14px; border-bottom:1px solid var(--border);"><input type="checkbox" /></th>
                  <th style="padding:14px; border-bottom:1px solid var(--border); width:160px;">Họ tên</th>
                  <th style="padding:14px; border-bottom:1px solid var(--border); width:150px;">Tên đăng nhập</th>
                  <th style="padding:14px; border-bottom:1px solid var(--border); width:120px;">Chức vụ</th>
                  <th style="padding:14px; border-bottom:1px solid var(--border); width:120px;">Quyền hạn</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result->num_rows > 0): ?>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                      <td style="padding:14px; border-bottom:1px solid #f1f5f9;">
                        <input type="checkbox" />
                      </td>
                      <td style="padding:14px; border-bottom:1px solid #f1f5f9; color:var(--primary); font-weight:500;">
                        <?= htmlspecialchars($row['HoTen']) ?>
                      </td>
                      <td style="padding:14px; border-bottom:1px solid #f1f5f9;">
                        <?= htmlspecialchars($row['TenDangNhap'] ?? '-') ?>
                      </td>
                      <td style="padding:14px; border-bottom:1px solid #f1f5f9;">
                        <?= htmlspecialchars($row['ChucVu'] ?? '-') ?>
                      </td>
                      <td style="padding:14px; border-bottom:1px solid #f1f5f9;">
                        <?= htmlspecialchars($row['QuyenHan'] ?? '-') ?>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" style="text-align:center; padding:14px;">Chưa có nhân viên nào</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
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