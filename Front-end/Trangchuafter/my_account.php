<?php
session_start();
include "connect.php"; // phải khởi tạo $conn (mysqli)

// Lấy MaND: ưu tiên GET -> POST -> SESSION
$mand = 0;
if (isset($_GET['MaND'])) {
    $mand = (int)$_GET['MaND'];
} elseif (isset($_POST['MaND'])) {
    $mand = (int)$_POST['MaND'];
} elseif (isset($_SESSION['MaND'])) {
    $mand = (int)$_SESSION['MaND'];
}

if ($mand <= 0) {
    die("Mã người dùng không hợp lệ");
}

// Lấy dữ liệu người dùng (prepared)
$sua_sql = "SELECT * FROM nguoidung WHERE MaND = ?";
$stmt = mysqli_prepare($conn, $sua_sql);
mysqli_stmt_bind_param($stmt, "i", $mand);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Không tìm thấy người dùng với MaND = $mand");
}

// Xử lý form đổi mật khẩu (LUU PLAIN TEXT theo yêu cầu)
$error_current = "";
$error_new = "";
$success_msg = "";
$show_modal = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $current_password = trim($_POST['current_password'] ?? "");
    $new_password = trim($_POST['new_password'] ?? "");
    $confirm_password = trim($_POST['confirm_password'] ?? "");

    // Lấy mật khẩu từ DB (plaintext)
    $dbPass = $row['MatKhau'] ?? '';

    // So sánh plaintext
    if ($current_password === '') {
        $error_current = "Vui lòng nhập mật khẩu hiện tại!";
        $show_modal = true;
    } elseif ($current_password !== $dbPass) {
        $error_current = "Mật khẩu hiện tại không đúng!";
        $show_modal = true;
    } elseif ($new_password !== $confirm_password) {
        $error_new = "Mật khẩu mới không trùng khớp!";
        $show_modal = true;
    } elseif (strlen($new_password) < 8) {
        $error_new = "Mật khẩu mới phải ít nhất 8 ký tự!";
        $show_modal = true;
    } else {
        // Update plaintext vào DB (KHÔNG KHUYẾN KHÍCH ngoài mục demo)
        $upd = mysqli_prepare($conn, "UPDATE nguoidung SET MatKhau = ? WHERE MaND = ?");
        mysqli_stmt_bind_param($upd, "si", $new_password, $mand);
        if (mysqli_stmt_execute($upd)) {
            $success_msg = "Đổi mật khẩu thành công.";
            // Cập nhật lại $row để phản ánh giá trị mới trong trang hiện tại
            $row['MatKhau'] = $new_password;
        } else {
            $error_new = "Lỗi khi cập nhật mật khẩu. Vui lòng thử lại.";
            $show_modal = true;
        }
        mysqli_stmt_close($upd);
    }
}
?>

<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin menu</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0b1220; --bg-2: #0e172a; --primary: #1373ff; --text: #0f172a;
      --muted: #64748b; --border: #e5e7eb; --surface: #ffffff; --surface-2: #f8fafc; --chip: #eef2ff;
    }
    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body { margin: 0; font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial; color: var(--text); background: var(--surface-2); }
    a { color: inherit; text-decoration: none; }
    .app { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
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
    .content { display:flex; flex-direction:column; }
    .topbar { background:#fff; border-bottom:1px solid var(--border); padding: 10px 18px; display:flex; align-items:center; gap:14px; }
    .search { flex:1; display:flex; align-items:center; gap:10px; background:#f1f5f9; border:1px solid #e2e8f0; padding:10px 12px; border-radius:10px; }
    .search input { flex:1; border:none; outline:none; background:transparent; font-size:14px; }
    .topbar-actions { display:flex; align-items:center; gap:12px; }
    .chip { font-size:12px; padding:6px 10px; border-radius:999px; background: var(--chip); color:#3730a3; font-weight:600; }
    .icon-btn { width:36px; height:36px; display:grid; place-items:center; border:1px solid var(--border); background:#fff; border-radius:10px; cursor:pointer; }
    .avatar { width:32px; height:32px; border-radius:50%; background:#22c55e; display:grid; place-items:center; color:#fff; font-weight:700; }
    .main { display:grid; grid-template-columns: 1fr 320px; gap: 18px; padding: 18px; }
    .banner { background:#eff6ff; border:1px dashed #bfdbfe; padding:12px 14px; border-radius:10px; display:flex; align-items:center; justify-content:space-between; gap:12px; }
    .banner strong { color:#1d4ed8; }
    .btn { display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; border:1px solid var(--border); background:#fff; cursor:pointer; font-weight:600; }
    .btn.primary { background: var(--primary); color:#fff; border-color: var(--primary); }
    .card { background:#fff; border:1px solid var(--border); border-radius:12px; }
    .card .card-hd { padding:14px; border-bottom:1px solid var(--border); font-weight:600; }
    .card .card-bd { padding: 14px; }
    .grid-2 { display:grid; grid-template-columns: 1fr 1fr; gap:14px; }
    .kpis { display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:12px; }
    .kpi { background:#fff; border:1px solid var(--border); border-radius:12px; padding:14px; }
    .kpi .label { color: var(--muted); font-size:12px; }
    .kpi .value { font-size:28px; font-weight:700; margin-top: 4px; }
    .kpi .muted { color: var(--muted); font-size:12px; }
    .widget { background:#fff; border:1px solid var(--border); border-radius:12px; padding: 14px; }
    .widget + .widget { margin-top: 14px; }
    .list { list-style:none; padding:0; margin:0; }
    .list li { display:flex; align-items:start; gap:10px; padding:10px 0; border-bottom:1px solid #f1f5f9; }
    .list li:last-child { border-bottom:none; }
    .badge { font-size:11px; padding:4px 8px; border-radius:999px; background:#ecfeff; color:#0891b2; font-weight:600; }
    .steps { display:grid; gap:10px; }
    .step { display:flex; gap:12px; align-items:flex-start; padding:10px; border:1px dashed #e5e7eb; border-radius:10px; background:#fafafa; }
    .step .n { width:24px; height:24px; border-radius:999px; display:grid; place-items:center; background:#e2e8f0; font-size:12px; font-weight:700; }
    .step .actions { margin-left:auto; }
    @media (max-width: 1180px) { .kpis { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 980px) {
      .app { grid-template-columns: 1fr; }
      .sidebar { position: sticky; top:0; z-index:4; flex-direction: row; overflow:auto; gap:8px; }
      .nav, .nav-section, .sidebar-footer, .nav-title { display:none; }
      .brand { margin:0; }
      .main { grid-template-columns: 1fr; }
    }
    .avatar-container { position: relative; display: inline-block; }
    .avatar { width: 40px; height: 40px; border-radius: 50%; cursor: pointer; }
    .dropdown { display: none; position: absolute; top: 50px; right: 0; background-color: white; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-width: 200px; z-index: 1000; }
    .dropdown-item { padding: 10px 15px; cursor: pointer; }
    .dropdown-item:hover { background-color: #f1f1f1; }

    /* Modal specific */
    .modal { display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; }
    .modal-box { background:#fff; padding:20px; border-radius:10px; width:400px; max-width:90%; }
    .text-error { color: #dc2626; font-size:13px; margin-top:6px; }
    .text-success { color: #16a34a; font-size:13px; margin-top:6px; }
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
        <div class="card" style="grid-column: 1 / -1;">
          <div class="card-hd">Thông tin tài khoản</div>
          <div class="card-bd">
            <form class="grid-2" style="gap: 20px;" method="post" action="">
              <input type="hidden" name="MaND" value="<?php echo htmlspecialchars($mand); ?>" id="">
              
              <!-- Họ và tên -->
              <div>
                <label for="fullname">Họ và tên<span style="color:red">*</span></label>
                <input type="text" id="fullname" name="fullname" class="form-control" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;"
                       value="<?php echo htmlspecialchars($row['HoTen'] ?? ''); ?>">
              </div>

              <!-- Số điện thoại -->
              <div>
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="SDT"  readonly value="<?php echo htmlspecialchars($row['SDT']); ?>"
                      style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;background:#f9fafb;">
              </div>

              <!-- Email -->
              <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                      style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;"
                      value="<?php echo htmlspecialchars($row['Email'] ?? ''); ?>">
              </div>

              <!-- Ngày sinh -->
              <div>
                <label for="dob">Ngày sinh</label>
                <input type="date" id="dob" name="dob"
                      style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;"
                      value="<?php echo htmlspecialchars($row['NgaySinh'] ?? ''); ?>">
              </div>

              <!-- Giới tính -->
              <div>
                <label for="gender">Giới tính</label>
                <select id="gender" name="gender" 
                        style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;">
                  <option value="other" <?php if(($row['GioiTinh'] ?? '') === 'other') echo 'selected'; ?>>Khác</option>
                  <option value="male" <?php if(($row['GioiTinh'] ?? '') === 'male') echo 'selected'; ?>>Nam</option>
                  <option value="female" <?php if(($row['GioiTinh'] ?? '') === 'female') echo 'selected'; ?>>Nữ</option>
                </select>
              </div>

              <!-- Khu vực -->
              <div>
                <label for="region">Khu vực</label>
                <select id="region" name="region" 
                        style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;">
                  <option value="">Chọn Tỉnh thành - Quận huyện</option>
                  <option value="hanoi" <?php if(($row['KhuVuc'] ?? '') === 'hanoi') echo 'selected'; ?>>Hà Nội</option>
                  <option value="hcm" <?php if(($row['KhuVuc'] ?? '') === 'hcm') echo 'selected'; ?>>Hồ Chí Minh</option>
                </select>
              </div>

              <!-- Phường/Xã -->
              <div>
                <label for="ward">Phường/Xã</label>
                <select id="ward" name="ward" 
                        style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;">
                  <option value="">Chọn Phường xã</option>
                </select>
              </div>

              <!-- Địa chỉ -->
              <div>
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" name="address"
                      style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;"
                      value="<?php echo htmlspecialchars($row['DiaChi'] ?? ''); ?>">
              </div>
            </form>

            <!-- Link đổi mật khẩu -->
            <div style="margin-top:15px;">
              <a href="#" id="openModal" style="color:#2563eb;font-weight:500;">Đổi mật khẩu</a>
            </div>
          </div>
        </div>

        <!-- Modal đổi mật khẩu -->
        <div class="modal" id="passwordModal">
          <div class="modal-box">
            <h3 style="margin-top:0;margin-bottom:10px;">Đổi mật khẩu</h3>

            <!-- Hiển thị lỗi/thành công -->
            <?php if ($error_current): ?>
              <div class="text-error"><?php echo htmlspecialchars($error_current); ?></div>
            <?php endif; ?>
            <?php if ($error_new): ?>
              <div class="text-error"><?php echo htmlspecialchars($error_new); ?></div>
            <?php endif; ?>
            <?php if ($success_msg): ?>
              <div class="text-success"><?php echo htmlspecialchars($success_msg); ?></div>
            <?php endif; ?>

            <form method="post" action="">
              <input type="hidden" name="action" value="change_password">
              <input type="hidden" name="MaND" value="<?php echo htmlspecialchars($mand); ?>">

              <label>Mật khẩu hiện tại</label>
              <input type="password" name="current_password" placeholder="Nhập mật khẩu hiện tại" id="password_current"
                    style="width:100%;padding:10px;margin:6px 0;border:1px solid #ddd;border-radius:8px;">

              <label>Mật khẩu mới</label>
              <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" id="password_new"
                    style="width:100%;padding:10px;margin:6px 0;border:1px solid #ddd;border-radius:8px;">

              <label>Nhập lại mật khẩu mới</label>
              <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" id="password_news"
                    style="width:100%;padding:10px;margin:6px 0;border:1px solid #ddd;border-radius:8px;">

              <p style="font-size:12px;color:red;">
                Mật khẩu cần thỏa mãn: ít nhất 8 ký tự, gồm số, chữ và ký tự đặc biệt.
              </p>

              <div style="text-align:right;margin-top:10px;">
                <button type="button" id="closeModal" 
                        style="padding:8px 14px;border:none;border-radius:6px;background:#e5e7eb;cursor:pointer;margin-right:5px;">
                  Hủy
                </button>
                <button type="submit" 
                        style="padding:8px 14px;border:none;border-radius:6px;background:#1373ff;color:#fff;cursor:pointer;">
                  Lưu
                </button>
              </div>
            </form>
          </div>
        </div>

        <script>
          const modal = document.getElementById("passwordModal");
          document.getElementById("openModal").onclick = (e) => {
            e.preventDefault();
            modal.style.display = "flex";
          };
          document.getElementById("closeModal").onclick = () => modal.style.display = "none";
          window.onclick = (e) => { if (e.target == modal) modal.style.display = "none"; };

          // Nếu server set $show_modal hoặc $success_msg thì mở modal ngay
        </script>

        <!-- Mở modal nếu server báo lỗi hoặc có message thành công -->
        <?php if ($show_modal || $success_msg): ?>
          <script>document.getElementById('passwordModal').style.display = 'flex';</script>
          <?php if ($success_msg): // nếu thành công, tự đóng modal sau 1.5s (tuỳ chọn) ?>
            <script>
              setTimeout(() => {
                document.getElementById('passwordModal').style.display = 'none';
              }, 1500);
            </script>
          <?php endif; ?>
        <?php endif; ?>

      </div>

    </section>
  </div>

  <!-- Gợi ý: file này lưu plaintext password (demo). Nếu muốn an toàn: dùng password_hash + password_verify -->
</body>
</html>
