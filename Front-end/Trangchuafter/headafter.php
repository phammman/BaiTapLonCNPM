<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<aside class="sidebar">
    <div class="brand">
    <div class="brand-logo">Q</div>
    <h1>QLYBanHang</h1>
    </div>

    <nav class="nav">
    <div class="nav-section">
        <a class="nav-item <?php echo ($current_page == 'manuadmin.php') ? 'active' : ''; ?>" href="manuadmin.php">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" stroke-width="1.5"/></svg>
        Tổng quan
        </a>
        <a class="nav-item <?php echo ($current_page == 'orders.php') ? 'active' : ''; ?>" href="orders.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 7h18M3 12h18M3 17h18" stroke-width="1.5"/></svg> Đơn hàng</a>
        <a class="nav-item <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>" href="products.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 8h10M7 12h10" stroke-width="1.5"/></svg> Sản phẩm</a>
        <a class="nav-item <?php echo ($current_page == 'inventories.php') ? 'active' : ''; ?>" href="inventories.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9h18M5 9V5h14v4M5 9v10h14V9" stroke-width="1.5"/></svg> Quản lý kho</a>
        <a class="nav-item <?php echo ($current_page == 'employee.php') ? 'active' : ''; ?>" href="employee.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Nhân viên</a>
        <a class="nav-item <?php echo ($current_page == 'customers.php') ? 'active' : ''; ?>" href="customers.php" ><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4" stroke-width="1.5"/><path d="M4 21c1.5-4 6-6 8-6s6.5 2 8 6" stroke-width="1.5"/></svg> Khách hàng</a>
        <!-- <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 12h16M12 4v16" stroke-width="1.5"/></svg> Khuyến mại</a> -->
        <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.5"/><path d="M7 9h6M7 13h10" stroke-width="1.5"/></svg> Sổ quỹ</a>
        <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h10" stroke-width="1.5"/></svg> Báo cáo</a>
        <!-- <a class="nav-item" href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h10" stroke-width="1.5"/></svg> Tài khoản</a> -->
        <a class="nav-item <?php echo ($current_page == 'my_account.php') ? 'active' : ''; ?>" href="my_account.php">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="24" height="24">
            <circle cx="12" cy="7" r="4" stroke-width="1.5"/> 
            <path d="M5.5 21c0-3.5 3-6 6.5-6s6.5 2.5 6.5 6" stroke-width="1.5"/>
        </svg>
        Tài khoản
        </a>
    </div>

    </nav>

    <!-- <div class="sidebar-footer">Cấu hình</div> -->
</aside>