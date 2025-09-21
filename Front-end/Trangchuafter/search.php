<?php
include("connect.php");

if (isset($_GET['TenDangNhap'])) {
    $TenDangNhap = $_GET['TenDangNhap'];
    
    $TenDangNhap = mysqli_real_escape_string($conn, $TenDangNhap);
    
    $sql = "SELECT nv.*, nd.SoDienThoai, nd.TenDangNhap, nd.MatKhau 
            FROM nhanvien nv 
            JOIN nguoidung nd ON nv.MaND = nd.MaND 
            WHERE nd.TenDangNhap LIKE '%$TenDangNhap%'";
    
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"/>
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

        .info{width: 98%; margin:0 20px;
        }
        .title{
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #cecece;
        }
        .title h2{margin:20px; font-size: 30px;}
        .title a{
            display: flex;
            align-items: center;
            }
        .title i{margin-right: 5px; font-size: 14px;}
        .info-NV {margin: 30px ; border: 1px solid #cecece; border-radius: 10px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}
        .all{
            margin: 5px; border-bottom: 1px solid #cecece;
        }
        .all-css{
            font-size: 20px; border:none; background: none; padding:8px 16px; color:rgb(0 136 255); border-bottom: 3px solid rgb(0 136 255); cursor: pointer;
        }
        .search-nv {width: 50%; margin: 20px; flex:1; display:flex; align-items:center; gap:10px; background:#f1f5f9; border:1px solid #e2e8f0; padding:10px 12px; border-radius:10px; }
        .search-nv input { flex:1; border:none; outline:none; background:transparent; font-size:14px;}
        table {
            margin: 20px 0;font-size: 18px; width: 100%; border-collapse: collapse; border: none; border-color: #f8fafc;
        }
        th,td{
            text-align: center; padding: 10px;
        }
        tr:nth-child(even) {
            background-color: #ffffff; /* Màu nền cho hàng chẵn */
        }
        tr:nth-child(odd) {
            background-color: #f2f2f2; /* Màu nền cho hàng lẻ */
        }
        a{
            text-decoration: none; color: white; padding: 5px 20px; margin: 5px;
        }
        .name{color: rgb(0 136 255); tex-decoration: none; }
        .them{
            display: inline-block; /* Để có thể căn giữa */
            text-align: center;
            margin: 20px;
            background-color: rgb(0 136 255); border-radius: 10px; color: white;
            
        }
        .them:hover {
            opacity: 0.8; /* Độ mờ khi di chuột vào */
        }
        b{ padding-bottom: 3px;}
        .xem{
            background-color: rgb(8, 209, 95); border-radius: 10px;
        }
        .sua{
            background-color: rgb(247, 243, 15); color: black; border-radius: 10px;
        }
        .xoa{
            border-radius: 10px; color: rgb(238, 71, 71); border: 1px solid rgba(227, 20, 5, 0.72);
        }
        .xoa:hover{
            color: red;
            background-color:rgba(243, 189, 185, 0.72);
        }
        .error-message {
            color: red;
            font-weight: bold; 
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
                    <a class="nav-item" href="quanLyNhanVien.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Nhân viên</a>
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
                    <button class="icon-btn" title="Thông báo"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5" stroke-width="1.5"/><path d="M10 19a2 2 0 0 0 4 0" stroke-width="1.5"/></svg></button>
                    <div class="avatar">cu</div>
                </div>
            </div>
            <div class="title">
                <h2>Danh sách nhân viên</h2>
                <a class = "them" href="themNV.php"><i class="fa-solid fa-plus"></i><b>Thêm nhân viên</b></a>
            </div>
            <div class="info-NV">
                <div class="all">
                    <button class = "all-css"><b>Tất cả</b></button>
                </div>
                <form action="searchNhanVien.php" method="get">
                    <div class="search-nv">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><circle cx="11" cy="11" r="7" stroke-width="1.6"/><path d="M20 20l-3.5-3.5" stroke-width="1.6"/></svg>
                        <input type = "text" placeholder="Tìm kiếm nhân viên" >
                    </div>
                </form>
                <table border = 2  align = "center";>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Chức vụ</th>
                    <th>Trạng Thái</th>
                </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row["MaNV"]; ?></td>
                                <td><a class="name" href="xemNhanVien.php?MaNV=<?php echo $row["MaNV"]; ?>"><?php echo $row["HoTen"]; ?></a></td>
                                <td><?php echo $row["TenDangNhap"]; ?></td>
                                <td><?php echo $row["ChucVu"]; ?></td>
                                <td>
                                    <a class="sua" href="suaNhanVien.php?MaNV=<?php echo $row["MaNV"]; ?>">Cập nhật</a>
                                    <a class="xoa" href="xoaNhanVien.php?MaNV=<?php echo $row["MaNV"]; ?>"><b>Xóa</b></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='error-message'>Không tìm thấy nhân viên nào.</td></tr>";
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
 