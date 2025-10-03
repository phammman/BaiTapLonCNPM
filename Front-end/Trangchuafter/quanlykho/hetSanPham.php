<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm hết hàng</title>
    <style>
        :root {
        --bg: #0b1220;           
        --bg-2: #0e172a;         
        --primary: #1373ff;      
        --text: #0f172a;         
        --muted: #64748b;        
        --border: #e5e7eb;       
        --surface: #ffffff;      
        --surface-2: #f8fafc;    
        --chip: #eef2ff;         
        }
        html, body { height: 100%; }
            /* * { box-sizing: border-box; } */

        body {
        margin: 0; font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
        color: var(--text); background: var(--surface-2);
        }
        a { color: inherit; text-decoration: none; }
        .container {
        display: grid; grid-template-columns: 260px 1fr; min-height: 100vh;
        }
        .sidebar { background: var(--bg); color: #cbd5e1; width: 250px; height:100%; padding: 18px 14px; display: flex; flex-direction: column;}
        .brand { display:flex; align-items:center; gap:10px; padding: 8px 10px; margin-bottom: 8px; }
        .brand-logo { width:28px; height:28px; border-radius:6px; background: linear-gradient(135deg,#0ea5e9,#3b82f6); display:grid; place-items:center; color:#fff; font-weight:700; }
        .brand h1 { font-size: 18px; color:#fff; margin:0; font-weight:700; letter-spacing:.2px; }
        .nav { margin-top: 8px; width: 230px;}
        .nav-section { margin-top: 14px; }
        .nav-title { font-size: 11px; letter-spacing:.08em; text-transform:uppercase; color:#64748b; padding: 8px 12px; }
        .nav-item { display:flex; align-items:center; gap:12px; width: 200px; padding: 10px 12px; border-radius:10px; color:#cbd5e1; }
        .nav-item:hover { background: #0f1a33; color:#e2e8f0; }
        .nav-item.active { background: #0f1a33; color:#fff; }
        .nav-item svg { width:18px; height:18px; color:#94a3b8; }
        
        .content { display:flex; flex-direction:column; }
        .topbar { background:#fff; border-bottom:1px solid var(--border); padding: 10px 18px; display:flex; align-items:center; gap:14px; margin-top: 20px;}
        .search { flex:1; display:flex; align-items:center; gap:10px; background:#f1f5f9; border:1px solid #e2e8f0; padding:10px 12px; border-radius:10px; }
        .search input { flex:1; border:none; outline:none; background:transparent; font-size:14px; }
        .topbar-actions { display:flex; align-items:center; gap:12px; }
        .chip { font-size:12px; padding:6px 10px; border-radius:999px; background: var(--chip); color:#3730a3; font-weight:600; }
        .icon-btn { width:36px; height:36px; display:grid; place-items:center; border:1px solid var(--border); background:#fff; border-radius:10px; cursor:pointer; }
        .avatar { width:32px; height:32px; border-radius:50%; background:#22c55e; display:grid; place-items:center; color:#fff; font-weight:700; }


        .info{
            margin: 0 20px; 
        }
        .title{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .title h2{
            margin:20px; font-size: 26px;
        }
        .info-kho {
            margin: 0 40px; border: 1px solid #cecece; border-radius: 10px; box-shadow: 0 0 3px rgba(0, 0, 0, 0.3); background-color: white; 
        }
        
        .info-title{
            margin: 5px ; border-bottom: 1px solid #cecece; padding: 8px 0;
        }
        .hethang{
            font-size: 18px; border:none; background: none; padding:8px 16px; color:rgb(0 136 255); border-bottom: 3px solid rgb(0 136 255); cursor: pointer; 
        } 
        .conhang{
            font-size: 18px; border:none; background: none; padding:8px 16px; color: gray; cursor: pointer; margin:0 10px;
        }
        .conhang:hover{
            border-bottom: 3px solid gray; color: black;
        } 
        .all{
            font-size: 18px; border:none; background: none; padding:8px 16px; color:gray; cursor: pointer;
        } 
        .all:hover{
            border-bottom: 3px solid gray; color: black;
        }
        .table-container {
            margin: 20px 0;
            width: 100%; 
            overflow-x: auto; 
        }
        table {
            width: 120%; 
            border-collapse: collapse;
            border: none;
            background: transparent;
            margin-bottom: 10px;
        }
        th, td {
            border: none; 
            padding: 8px; 
            text-align: center; 
            background: transparent;
        }
        tr:nth-child(even) {
            background-color: #ffffff; /* Màu nền cho hàng chẵn */
        }
        tr:nth-child(odd) {
            background-color: #f2f2f2; /* Màu nền cho hàng lẻ */
        }
        .name{color: rgb(0 136 255); tex-decoration: none; }
        .name:hover{
            text-decoration: underline; text-decoration-color: rgb(0 136 255);
        }
        .info-footer{
            display: flex; justify-content: space-between; align-items: center; padding: 0 20px; margin-bottom: 20px;
        }
        .pagination {
            display: flex;
            justify-content: center;
        }
        .pagination a {
            font-size: 18px;
            float: left;
            padding: 0;
            text-decoration: none;
        }
        .page-link {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 25px; 
            height: 25px; 
            border-radius: 50%; 
            background-color: rgb(0 136 255); 
            color: rgb(0 136 255); 
            text-decoration: none; 
            font-weight: bold; 
            color: white;
            margin: 0 10px;
        }
        .gray-link{
            color: gray;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="sidebar">
            <div class="brand">
                <div class="brand-logo">Q</div>
                <h1>QLYBanHang</h1>
            </div>
            <nav class="nav">
                <div class="nav-section">
                    <a class="nav-item active" href="#">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" stroke-width="1.5"/></svg>
                        Tổng quan
                    </a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 7h18M3 12h18M3 17h18" stroke-width="1.5"/></svg> Đơn hàng</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 8h10M7 12h10" stroke-width="1.5"/></svg> Sản phẩm</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9h18M5 9V5h14v4M5 9v10h14V9" stroke-width="1.5"/></svg> Quản lý kho</a>
                    <a class="nav-item" href="./quanLyNhanVien.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Nhân viên</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Khách hàng</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 9h6M7 13h10" stroke-width="1.5"/></svg> Sổ quỹ</a>
                    <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h10" stroke-width="1.5"/></svg> Báo cáo</a>
                </div>
            </nav>
        </div>
        <div class="info">
            <div class="topbar">
                <div class="search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><circle cx="11" cy="11" r="7" stroke-width="1.6"/><path d="M20 20l-3.5-3.5" stroke-width="1.6"/></svg>
                    <input placeholder="Tìm kiếm" />
                </div>
                
                <div class="topbar-actions">
                    <button class="icon-btn" title="Thông báo">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5" stroke-width="1.5"/><path d="M10 19a2 2 0 0 0 4 0" stroke-width="1.5"/></svg>
                </button>
                <a href="../login/DangXuat.php" style="
                    background:#ef4444;
                    color:#fff;
                    padding:8px 14px;
                    border-radius:8px;
                    font-weight:600;
                    text-decoration:none;
                    transition:0.3s;
                " onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                            Đăng xuất
                </a>
                    <div class="avatar">cu</div>
                </div>
            </div>
            <div class="title">
                <h2>Quản lý kho</h2>
            </div>
            <div class="info-kho">
                <div class="info-title">
                    <a class = "all" href = "quanLyKho.php">Tất cả</a>
                    <a class = "conhang" href="conSanPham.php">Còn hàng</a>
                    <a class = "hethang" href="hetSanPham.php">Hết hàng</a>
                </div>
                <div class="table-container">
                    <?php
                        include("connect.php");
                        $itemsPerPage = 10; 
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
                        $currentPage = max(1, $currentPage); 

                        $sqlCount = "SELECT COUNT(*) AS total FROM sanpham";
                        $resultCount = mysqli_query($conn, $sqlCount);
                        $totalProduct = mysqli_fetch_assoc($resultCount)['total'];

                        $totalPages = ceil($totalProduct / $itemsPerPage); 
                        $offset = ($currentPage - 1) * $itemsPerPage;
                        $sql = "SELECT * FROM sanpham WHERE SoLuongTon = 0 LIMIT $offset, $itemsPerPage";
                        $result = mysqli_query($conn, $sql);
                    ?>
                    <table>
                        <tr>
                            <th><input type="checkbox" name="" id=""></th>
                            <th style ="width: 300px; text-align: left;">Sản phẩm</th>
                            <th>SKU</th>
                            <th>Barcode</th>
                            <th>Đơn vị tính</th>
                            <th>Tồn kho</th>
                            <th>Giá bán</th>
                            <th>Giá vốn</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_array($result)){ ?>
                        <tr>
                            <th><input type="checkbox" name="" id=""></th>
                            <td style = "text-align: left;"><a class="name" href=""><?php echo $row["TenSP"]; ?></a></td>
                            <td><?php echo $row["MaSKU"]; ?></td>
                            <td><?php echo $row["MaBarcode"]; ?></td>
                            <td ><?php echo $row["DVTinh"]; ?></td>
                            <td><?php echo $row['SoLuongTon']?></td>
                            <td><?php echo $row["GiaBan"]; ?></td>
                            <td><?php echo $row["GiaVon"]; ?></td>
                        </tr>
                        <?php } ?>
                        
                    </table>
                </div>
                <div class="info-footer">
                    <div class="total-employ">
                        <?php
                            $start = ($currentPage - 1) * $itemsPerPage + 1; 
                            $end = min($start + $itemsPerPage - 1, $totalProduct); 
                            
                            if ($totalProduct > 0) {
                                echo "Từ $start đến $end trên tổng $totalProduct";
                            }
                        ?>  
                    </div>
                    <div class="pagination">
                        <a href="?page=<?php echo max(1, $currentPage - 1); ?>" class="gray-link"><</a>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="page-link <?php if ($i == $currentPage) echo 'active'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        <a href="?page=<?php echo min($totalPages, $currentPage + 1); ?>" class="gray-link">></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>