<div class="topbar">
    <div class="search">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><circle cx="11" cy="11" r="7" stroke-width="1.6"/><path d="M20 20l-3.5-3.5" stroke-width="1.6"/></svg>
    <input placeholder="Tìm kiếm" />
    
    </div>
    <div class="topbar-actions">
    <button class="icon-btn" title="Thông báo"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5" stroke-width="1.5"/><path d="M10 19a2 2 0 0 0 4 0" stroke-width="1.5"/></svg></button>
    <div class="avatar" alt="Avatar" id="avatarBtn"><?php echo substr($_SESSION['TenDangNhap'], 0, 2); ?></div>
    <div class="dropdown" id="avatarDropdown">
        <div onclick="location.href='my_account.php'" class="dropdown-item">Tài khoản của tôi</div>
        <div onclick="window.open('myshop/Trangchu.php', '_blank')" class="dropdown-item">
            Website của tôi
        </div>

        <div onclick="location.href='DangNhap.php'" class="dropdown-item">Đăng xuất</div>
    </div>
    </div>
</div>

<script>
    const avatarBtn = document.getElementById("avatarBtn");
    const avatarDropdown = document.getElementById("avatarDropdown");

    // toggle dropdown khi click avatar
    avatarBtn.addEventListener("click", () => {
    avatarDropdown.style.display = 
        avatarDropdown.style.display === "block" ? "none" : "block";
    });

    // ẩn dropdown khi click ra ngoài
    window.addEventListener("click", (e) => {
    if (!avatarBtn.contains(e.target) && !avatarDropdown.contains(e.target)) {
        avatarDropdown.style.display = "none";
    }
    });
</script>