<?php
    session_start();
    // $masp = $_GET['MaSP'];

    // include('connect.php');

    // $sua_sql = "SELECT * FROM sanpham WHERE MaSP=$masp";

    // $result = mysqli_query($conn , $sua_sql);
    // $row = mysqli_fetch_assoc($result);
    // include('connect.php');
    include __DIR__ . "/../connect.php";

    $madh = isset($_GET['MaDH']) ? (int)$_GET['MaDH'] : 0;

    if ($madh <= 0) {
        die("Mã sản phẩm không hợp lệ");
    }

    $sua_sql = "SELECT * FROM donhang WHERE MaDH = $madh";
    $result = mysqli_query($conn, $sua_sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        die("Không tìm thấy sản phẩm với MaDH = $madh");
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
    .remove-btn:hover{
      background-color: #e1e2e2ff;
    }
  </style>
</head>
<body>
  <form class="app" action="add.php" method="post">
    <input type="hidden" name="MaDH" value="<?php echo $madh; ?>" id="">
    <!-- SIDEBAR -->
    <?php include '../headafter2.php'; ?>

    <!-- CONTENT -->
    <section class="content">
      <!-- Top bar -->
      <?php include '../topbar2.php'; ?>

      <!-- Main -->
    <div class="main">
        <!-- Left column -->
         <section class="content">
            <div class="topbutton">
                <button type="button" onclick="location.href='/Chuyen_de_dinh_huong_CNPM/Front-end/Trangchuafter/orders.php'">&larr;</button>
                <h2>Tạo đơn hàng</h2>
            </div>
            <div class="product-section card">
              <h3>Sản phẩm</h3>
              <div style="position: relative; margin-bottom: 10px;">
                <input type="text" id="searchInput" placeholder="Tìm theo tên, mã SKU... (F3)" 
                      style="flex:1; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; margin-right: 10px; width:100%;">
                <div id="suggestions" 
                    style="position:absolute; top:40px; left:0; background:white; border:1px solid #ddd; border-radius:6px; 
                            max-height:200px; overflow-y:auto; display:none; width:100%; z-index:10;"></div>
              </div>
              
              <div class="runsp" id="selectedProducts" 
              style="border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; text-align: center; background: #f8fafc; margin-bottom: 10px;">
              <div id="selectedProducts" style="margin-top: 20px;"></div>
                <p id="emptyMsg" style="color: #64748b;">Bạn chưa thêm sản phẩm nào</p>
              </div>

              <script>
                const searchInput = document.getElementById("searchInput");
                const suggestions = document.getElementById("suggestions");
                const selectedProducts = document.getElementById("selectedProducts");
                const emptyMsg = document.getElementById("emptyMsg");

                // Tìm kiếm sản phẩm
                searchInput.addEventListener("keyup", function() {
                  let keyword = this.value.trim();
                  if (keyword.length < 1) {
                    suggestions.style.display = "none";
                    return;
                  }

                  fetch("search_product.php?q=" + encodeURIComponent(keyword))
                    .then(response => response.json())
                    .then(data => {
                      suggestions.innerHTML = "";
                      if (data.length > 0) {
                        data.forEach(item => {
                          let div = document.createElement("div");
                          div.textContent = item.TenSP + " (" + item.MaSP + ")";
                          div.style.padding = "8px";
                          div.style.cursor = "pointer";

                          // Khi click chọn sản phẩm
                          div.addEventListener("click", function() {
                            searchInput.value = ""; // xóa ô tìm kiếm
                            suggestions.style.display = "none";
                            addProductCard(item);
                          });

                          suggestions.appendChild(div);
                        });
                        suggestions.style.display = "block";
                      } else {
                        suggestions.innerHTML = "<div style='padding:8px; color:#999;'>Không tìm thấy sản phẩm</div>";
                        suggestions.style.display = "block";
                      }
                    });
                });
                function addProductCard(product) {
                  if (emptyMsg) {
                    emptyMsg.style.display = "none";
                  }

                  let card = document.createElement("div");
                  card.classList.add("product-card");
                  card.style.cssText =
                    "position: relative; border:1px solid #e5e7eb; border-radius:10px; padding:12px; margin-bottom:10px; background:#fff; display:flex; justify-content:space-between; align-items:center";

                  // Giá bán từ DECIMAL
                  let gia = parseFloat(product.GiaBan);

                  card.innerHTML = `
                    <!-- Nút xóa -->
                    <div class="remove-btn" 
                          style="width: 40px; position:absolute; top:2px; right:1px; color:black; cursor:pointer;font-size:40px;">
                      ×
                    </div>

                    <div>
                      <strong>${product.TenSP}</strong><br>
                      Giá: ${gia.toLocaleString("vi-VN")} đ
                    </div>
                    <div>
                      <label style="margin-right: 50px;">Số lượng:</label>
                      <input type="number" value="1" min="1" 
                            data-price="${gia}" 
                            class="soluong-input"
                            style="width:60px; padding:4px; border:1px solid #ddd; border-radius:6px;margin-right:50px">
                    </div>
                  `;

                  selectedProducts.appendChild(card);

                  // Bấm vào nút X sẽ xóa sản phẩm
                  card.querySelector(".remove-btn").addEventListener("click", function () {
                    card.remove();
                    updateTotal();
                  });

                  // Tính lại tổng sau khi thêm sản phẩm
                  updateTotal();
                }

                // Hàm tính tổng tiền
                function updateTotal() {
                  let inputs = document.querySelectorAll(".soluong-input");
                  let tong = 0;
                  inputs.forEach(input => {
                    let sl = Number(input.value);
                    let gia = Number(input.dataset.price);
                    tong += sl * gia;
                  });

                  // Hiển thị
                  document.getElementById("totalAmount").innerText = tong.toLocaleString() + "₫";
                    document.getElementById("tongtien").innerText = tong.toLocaleString() + "₫";
                    document.getElementById("ThanhTienInput").value = tong; // gán giá trị vào input ẩn
                  }

                // Lắng nghe sự kiện thay đổi số lượng
                document.addEventListener("input", function(e) {
                  if (e.target.classList.contains("soluong-input")) {
                    updateTotal();
                  }
                });
                
              </script>
            </div>
            <div class="payment-section card" style="margin-top: 20px; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; background: #fff;">
              <h3 style="margin-bottom: 16px;">Thanh toán</h3>

              <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Tổng tiền hàng</span>
                <span id="totalAmount"></span>
              </div>

              <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Thêm giảm giá</span>
                <span>0₫</span>
              </div>

              <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #94a3b8;">
                <span>Thêm phí giao hàng</span>
                <span>0₫</span>
              </div>

              <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 10px 0;">

              <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 16px;">
                <span>Thành tiền</span>
                <span name="ThanhTien" id="tongtien"><?php echo htmlspecialchars($row['ThanhTien']); ?></span>
                <input type="hidden" name="ThanhTien" id="ThanhTienInput">
              </div>
            </div>

           <!-- <div style="position: relative; margin-bottom: 10px;margin-top: 20px; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; background: #fff;">
            <label for="searchCustomer">Khách hàng</label>
            <input name="TenKH" type="text" id="searchCustomer" placeholder="Tìm khách hàng theo tên, email, số ĐT..."
                  style="flex:1; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; margin-right: 10px; width:100%;">
                  <input type="hidden" name="MaKH" id="customerId">
            <div id="customerSuggestions"
                style="position:absolute; margin-top:5px; left:0; background:white; border:1px solid #ddd; border-radius:6px;max-height:200px; overflow-y:auto; display:none; width:100%; z-index:10;"></div>
          </div> -->
          <div style="position: relative; margin-bottom: 10px;margin-top: 20px; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; background: #fff;">
            <label for="searchCustomer">Khách hàng</label>
            <input name="TenKH" type="text" id="searchCustomer" placeholder="Tìm khách hàng theo tên, email, số ĐT..."
                style="flex:1; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; margin-right: 10px; width:100%;" required <?php echo htmlspecialchars($row['TenKH']); ?>>
            
            <!-- Input ẩn lưu MaKH -->
            <input type="hidden" name="MaKH" id="customerId">

            <div id="customerSuggestions"
                style="position:absolute; margin-top:5px; left:0; background:white; border:1px solid #ddd; border-radius:6px;max-height:200px; overflow-y:auto; display:none; width:100%; z-index:10;">
            </div>
          </div>



          <script>
            // document.getElementById("searchCustomer").value = customer.TenKH; // hiện tên
            // document.getElementById("customerId").value = customer.MaKH;     // gán mã KH để submit

            const searchCustomer = document.getElementById("searchCustomer");
            const customerSuggestions = document.getElementById("customerSuggestions");

            searchCustomer.addEventListener("keyup", function() {
                let keyword = this.value.trim();
                if (keyword.length < 1) {
                    customerSuggestions.style.display = "none";
                    return;
                }

                fetch("search_customer.php?q=" + encodeURIComponent(keyword))
                .then(response => response.json())
                .then(data => {
                    customerSuggestions.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(item => {
                            let div = document.createElement("div");
                            div.textContent = item.HoTen + " - " + item.Email + " (" + item.DienThoai + ")";
                            div.style.padding = "8px";
                            div.style.cursor = "pointer";

                            div.addEventListener("click", function() {
                                searchCustomer.value = item.HoTen; // hiển thị tên
                                document.getElementById("customerId").value = item.MaKH; // gán MaKH vào hidden input
                                customerSuggestions.style.display = "none";
                            });

                            customerSuggestions.appendChild(div);
                        });
                        customerSuggestions.style.display = "block";
                    } else {
                        customerSuggestions.innerHTML = "<div style='padding:8px; color:#999;'>Không tìm thấy khách hàng</div>";
                        customerSuggestions.style.display = "block";
                    }
                });
            });

          </script>


            <div class="extra-info card" style="margin-top: 20px; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; background: #fff;">
              <h3 style="margin-bottom: 30px;">Thông tin bổ sung</h3>

              <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Bán tại chi nhánh</label>
                <select style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px;">
                  <option>Cửa hàng chính</option>
                  <option>Chi nhánh 1</option>
                  <option>Chi nhánh 2</option>
                </select>
              </div>

              <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Nhân viên phụ trách</label>
                <select style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px;">
                  <!-- <input type="hidden" name="MaNV" value="<?php echo $_SESSION['MaNV']; ?>"> -->
                  <option>Chọn nhân viên</option>
                  <option>Nhân viên A</option>
                  <option>Nhân viên B</option>
                </select>
              </div>


              <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Ngày đặt hàng</label>
                <input name="NgayLap" type="date" style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px;" <?php echo htmlspecialchars($row['NgayLap']); ?>>
                <small style="color: #94a3b8;">Giá trị chỉ ghi nhận khi tạo đơn hàng</small>
              </div>

              <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Ngày hẹn giao</label>
                <input type="date" style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px;">
              </div>

              <div style="margin-top: 16px; display: flex; justify-content: flex-end; gap: 8px;">
                <button style="padding: 8px 14px; border: 1px solid #e5e7eb; border-radius: 6px; background: #fff; cursor:pointer;">
                  Lưu nháp
                </button>
                <button type="submit" style="padding: 8px 14px; border-radius: 6px; background: #1373ff; color: white; border: none; cursor:pointer;">
                  Tạo đơn và xác nhận
                </button>
              </div>
            </div>
            </section>
        </div>
    </section>
  </form>

</body>
</html>

