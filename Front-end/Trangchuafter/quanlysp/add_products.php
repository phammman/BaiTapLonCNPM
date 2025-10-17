<?php
session_start();
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
    /* :root {
      --bg: #0b1220;
      --primary: #1373ff;
      --border: #e5e7eb;
      --surface: #ffffff;
      --surface-2: #f8fafc;
    }
    body {
      margin: 0;
      font-family: Inter, sans-serif;
      background: var(--surface-2);
      color: #0f172a;
    }
    .app {
      display: grid;
      grid-template-columns: 260px 1fr;
      min-height: 100vh;
    } */
    /* Sidebar */
    /* .sidebar {
      background: var(--bg);
      color: #cbd5e1;
      padding: 18px 14px;
      display: flex;
      flex-direction: column;
    }
    .brand {
      display:flex;
      align-items:center;
      gap:10px;
      padding: 8px 10px;
      margin-bottom: 8px;
    }
    .brand-logo {
      width:28px;
      height:28px;
      border-radius:6px;
      background: linear-gradient(135deg,#0ea5e9,#3b82f6);
      display:grid;
      place-items:center;
      color:#fff;
      font-weight:700;
    }
    .brand h1 { color:#fff; font-size:18px; margin:0; }
    .nav a {
      display:flex;
      align-items:center;
      gap:12px;
      padding:10px 12px;
      border-radius:10px;
      color:#cbd5e1;
    }
    .card button{
      background-color: #1373ff;
    }
    .nav a:hover, .nav a.active { background:#0f1a33; color:#fff; } */

    /* Main Content */
    .content2 { padding: 20px; }
    h2 { margin-top:0; font-size:20px; }
    .form-grid {
      display:grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }
    .card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
    }
    .card h3 { margin-top:0; }
    label { font-weight:500; display:block; margin-top:10px; margin-bottom:4px; }
    input, textarea, select {
      width: 95%;
      padding: 8px;
      border: 1px solid var(--border);
      border-radius: 6px;
      font-size: 14px;
    }
    textarea { min-height: 80px; }
    .btn button {
      padding: 10px 16px;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight:600;
      cursor:pointer;
      margin-top: 10px;
    }
    .btn:hover { opacity: 0.9; }
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
    .search { flex:1; display:flex; align-items:center; gap:10px; background:#f1f5f9; border:1px solid #e2e8f0; padding:3px 12px; border-radius:10px; }
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
    .card-bd{ display:flex;justify-content: center;}
    .card-info{background-color: #fff;margin-right:2%;width:70%;border-radius: 5%;}
    .card-channel{background-color: #fff;width:28%;border-radius: 5%;}

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
    .topbutton{
        display:flex;    
    }
    .topbutton h2{
        margin-left: 20px;
        font-size: 24px;
       }
    .topbutton button{
        background-color: transparent;
        border-radius: 5px;
        border: 3px solid #e2e8f0;
        font-size: 20px;
        cursor: pointer;
        height:80%;
        width:5%
    }
    .topbutton button:hover{
        background-color: #e1e2e2ff;
        border: 3px solid #e1e2e2ff;
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
    display: none;
    position: absolute;
    top: 50px;
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
  <form class="app" action="add.php" method="post" enctype="multipart/form-data">
    <!-- SIDEBAR -->
    <?php include('../headafter2.php')?>

    <!-- CONTENT -->
    <section class="content">
      <!-- Top bar -->
      <?php include('../topbar2.php')?>

      <!-- Main -->
    <div class="main">
        <!-- Left column -->
         <section class="content2">
            <div class="topbutton">
                <button onclick="location.href='/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/products.php'">&larr;</button>
                <h2>Thêm sản phẩm</h2>
            </div>
            <div class="form-grid">
                <!-- Left column -->
                <div>
                <div class="card">
                    <h3>Thông tin sản phẩm</h3>
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" id="name" placeholder="Nhập tên sản phẩm" name="TenSP" required>

                    <label for="sku">Mã SKU</label>
                    <input type="text" id="sku" placeholder="Nhập mã SKU" name="MaSKU" required>

                    <label for="barcode">Số lượng sản phẩm</label>
                    <input type="text" id="barcode" placeholder="Nhập số lượng sản phẩm" name="SoLuongTon" required>

                    <label for="unit">Đơn vị tính</label>
                    <input type="text" id="unit" placeholder="Nhập đơn vị tính" name="DonViTinh">

                    <label for="description">Mô tả</label>
                    <textarea id="description" placeholder="Nhập mô tả sản phẩm" name="MoTa"></textarea>
                </div>

                <div class="card">
                    <h3>Thông tin giá</h3>
                    <label>Giá bán</label>
                    <input type="number" placeholder="Nhập giá bán" name="GiaBan">
                    <label>Giá so sánh</label>
                    <input type="number" placeholder="Nhập giá so sánh sản phẩm" name="GiaSoSanh">
                    <label>Giá vốn</label>
                    <input type="number" placeholder="Nhập giá vốn sản phẩm" name="GiaVon">
                </div>

                <button type="submit" class="btn" style="background-color: #1373ff; color: white;">Thêm sản phẩm</button>
                </div>

                <!-- Right column -->
                <div>
                <div class="card">
                    <h3>Ảnh sản phẩm</h3>
                    <input type="file" name="img">
                </div>

                <div class="card">
                    <h3>Danh mục & Thuộc tính</h3>
                    <label>Danh mục</label>
                    <select name="MaDM">
                      <option value="1">Danh mục 1</option>
                      <option value="2">Danh mục 2</option>
                    </select>
                    <label>Nhãn hiệu</label>
                    <select name="NhaHieu">
                      <option value="1">Nhãn hiệu 1</option>
                      <option value="2">Nhãn hiệu 2</option>
                    </select>
                    <label>Loại sản phẩm</label>
                    <select name="LoaiSP">
                      <option value="1">Loại 1</option>
                      <option value="2">Loại 2</option>
                    </select>
                </div>
                </div>
            </div>
            </section>
        </div>
    </section>
  </form>

</body>
</html>