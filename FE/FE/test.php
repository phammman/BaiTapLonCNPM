
<div class="main" style="font-family: Arial, sans-serif; width: 80%; margin: 20px auto;">


    <div style="max-width:800px; margin:auto; background:#fff; border-radius:10px; padding:20px;">
    <h2 style="margin-bottom:20px;">Thêm mới khách hàng</h2>
    
    <form action="save_customer.php" method="post">
      <!-- Thông tin cơ bản -->
      <div style="border:1px solid #ddd; border-radius:10px; padding:20px; margin-bottom:20px;">
        <h3 style="margin-bottom:15px;">Thông tin cơ bản</h3>
        <div style="display:flex; gap:10px; margin-bottom:15px;">
          <div style="flex:1;">
            <label>Họ</label>
            <input type="text" name="Ho" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" required>
          </div>
          <div style="flex:1;">
            <label>Tên</label>
            <input type="text" name="Ten" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" required>
          </div>
        </div>
        <div style="display:flex; gap:10px; margin-bottom:15px;">
          <div style="flex:1;">
            <label>Email</label>
            <input type="email" name="Email" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
          </div>
          <div style="flex:1;">
            <label>Số điện thoại</label>
            <input type="text" name="DienThoai" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
          </div>
        </div>
        <div style="display:flex; gap:10px; margin-bottom:15px;">
          <div style="flex:1;">
            <label>Ngày sinh</label>
            <input type="date" name="NgaySinh" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
          </div>
          <div style="flex:1;">
            <label>Giới tính</label><br>
            <input type="radio" name="GioiTinh" value="Nam"> Nam
            <input type="radio" name="GioiTinh" value="Nữ" style="margin-left:10px;"> Nữ
            <input type="radio" name="GioiTinh" value="Khác" style="margin-left:10px;"> Khác
          </div>
        </div>
      </div>

      <!-- Địa chỉ nhận hàng -->
      <div style="border:1px solid #ddd; border-radius:10px; padding:20px;">
        <h3 style="margin-bottom:15px;">Địa chỉ nhận hàng</h3>
        
        <div style="display:flex; gap:10px; margin-bottom:15px;">
          <div style="flex:1;">
            <label>Tỉnh/Thành phố</label>
            <input type="text" name="Tinh" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
            <!-- <select name="Tinh" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
              <option value="">Chọn Tỉnh thành</option>
              <option>Hà Nội</option>
              <option>Hồ Chí Minh</option>
              <option>Đà Nẵng</option>
            </select> -->
          </div>
          <div style="flex:1;">
            <label>Quận/Huyện</label>
            <input type="text" name="Quan" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
            <!-- <select name="Quan" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
              <option value="">Chọn Quận huyện</option>
            </select> -->
          </div>
        </div>
        <div style="display:flex; gap:10px; margin-bottom:15px;">
          <div style="flex:1;">
            <label>Phường/Xã</label>
            <input type="text" name="Phuong" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
            <!-- <select name="Phuong" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
              <option value="">Chọn Phường xã</option>
            </select> -->
          </div>
          <div style="flex:2;">
            <label>Địa chỉ cụ thể</label>
            <input type="text" name="DiaChiCuThe" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;">
          </div>
        </div>
      </div>

      <div style="margin-top:20px; text-align:right;">
        <button type="reset" style="padding:10px 20px; border:1px solid #ccc; border-radius:5px;">Hủy</button>
        <button type="submit" style="background:#007bff; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Lưu khách hàng</button>
      </div>
    </form>
  </div>

    <!-- <div style="text-align:right; margin-top:20px;">
        <button type="submit" formmethod="POST" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px;">Lưu</button>
        <button type="reset" style="padding:10px 20px; border:1px solid #ccc; border-radius:5px;">Hủy</button>
    </div> -->
</div>
