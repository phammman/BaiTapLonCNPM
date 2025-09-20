<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="BangGia.css">
    <link rel="">
    <title>Document</title>
     <style>
        .nav a{
            color:#060C23;
            text-decoration: none;
        }
        .nav a:hover{
            color:#3692e3;
            text-decoration:underline;      
        }
    </style>
</head>
<body>
    <div>
         <div class="banner">
            <div class="nav">
                <a href="TrangchuBefore.php">
                    <img src="img/4.svg">
                </a>
            </div>
            <div class="nav" style="margin-right: 60px;">
                <b>Giải pháp</b>
            </div>
            <div class="nav">
                <a href="BangGia.php">
                    <b>Bảng giá</b>
                </a>
            </div>
            <div class="nav">
                <a href="KhachHang.php">
                    <b>Khách hàng</b>
                </a>
            </div>
            <div class="nav">
                <a href="enterprise.php">
                    <b>Enterprise</b>
                </a>
            </div>
            <div class="nav">
                <a href="sapo.php">
                    <b>Sapo</b>
                </a>
            </div>
            <div class="nav">
                <a href="">
                    <b>Thêm</b>
                </a>
            </div>
            <div class="nav1">
                <button>Đăng nhập</button>
            </div>
            <div class="nav2">
                <button>Đăng ký</button>
            </div>
        </div>
        <div class="tab2">
            <div class="tab21">
                <h1>Bảng giá dịch vụ phần mềm Sapo</h1>
                Lựa chọn giải pháp phù hợp với nhu cầu của bạn và dùng thử miễn phí 7 ngày
            </div>
            <div class="tab22">
                <div class="tab221" onclick="showTab('retail')">
                    <b>
                        Cửa hàng bán lẻ
                    </b>
                </div>
                <div class="tab222" onclick="showTab('restaurant')">
                    <b>
                        Nhà hàng & Dịch vụ
                    </b>
                </div>
                <div class="tab223" onclick="showTab('website')">
                    <b>
                        Website bán hàng
                    </b>
                </div>
            </div>
        </div>
        <div id="tab3" class="tab3">
            <div class="tab31">
                <h2>Giá phần mềm quản lý bán hàng</h2>
                Sapo cung cấp đa dạng các gói dịch vụ phù hợp với các mô hình kinh doanh từ cửa hàng cho đến các kênh online (Facebook, Sàn TMĐT,...)
            </div>
            <div class="tab32">
                <div class="tab321">
                    <h2>Start up</h2>
                    <h1>170.000</h1>
                    <button>Dùng thử miễn phí →</button><br>
                    <b>Lựa chọn 1 trong 3 kênh bán hàng</b>
                    <ul>
                        <li>Bán tại cửa hàng</li>
                        <li>Bán hàng trên Mạng Xã Hội</li>
                        <li>Bán hàng trên sàn TMDT</li>
                        <li>Bán hàng trên Website</li>
                    </ul>
                </div>
                <div class="tab321">
                    <h2>PRO</h2>
                    <h1>249.000</h1>
                    <button>Dùng thử miễn phí →</button><br>
                    <b>Lựa chọn 1 trong 3 kênh bán hàng</b>
                    <ul>
                        <li>Bán tại cửa hàng</li>
                        <li>Bán hàng trên Mạng Xã Hội</li>
                        <li>Bán hàng trên sàn TMDT</li>
                        <li>Bán hàng trên Website</li>
                    </ul>
                </div>
                <div class="tab321">
                    <h2>OMNI</h2>
                    <h1>970.000</h1>
                    <button>Dùng thử miễn phí →</button><br>
                    <b>Lựa chọn 1 trong 3 kênh bán hàng</b>
                    <ul>
                        <li>Bán tại cửa hàng</li>
                        <li>Bán hàng trên Mạng Xã Hội</li>
                        <li>Bán hàng trên sàn TMDT</li>
                        <li>Bán hàng trên Website</li>
                    </ul>
                </div>
                <div class="tab321">
                    <h2>GROWTH</h2>
                    <h1>850.000</h1>
                    <button>Dùng thử miễn phí →</button><br>
                    <b>Lựa chọn 1 trong 3 kênh bán hàng</b>
                    <ul>
                        <li>Bán tại cửa hàng</li>
                        <li>Bán hàng trên Mạng Xã Hội</li>
                        <li>Bán hàng trên sàn TMDT</li>
                        <li>Bán hàng trên Website</li>
                    </ul>

                </div>
            </div>
            <script src="BangGia.js">
            </script>
        </div>
        <div class="tab4">
            <h1>Bạn chưa chọn được gói dịch vụ phù hợp?</h1>
            Hãy đăng ký dùng thử phần mềm để đưa ra lựa chọn<br>
            <button>Dùng thử miễn phí →</button>
        </div>
        <div class="tab5">
            <div class="tab52">
                <h1>Sapo - Tất cả những gì bạn cần để quản lý và kinh doanh</h1>
                Chúc mừng bạn có 7 ngày dùng thử miễn phí. Nhanh tay đăng ký ngay !<br>
            </div>
            <div class="tab51">
                <input type="text" placeholder="Nhập tên cửa hàng/daonh nghiệp của bạn">
                <button>Dùng thử miễn phí →</button>
            </div>
        </div>
        <div class="tab6">
           <div class="tab61">
                <a href="#">Sapo.vn</a><br>
                <a href="#">Về chúng tôi</a><br>
                <a href="#">Sapo là gì?</a><br>
                <a href="#">Blog Sapo</a><br>
                <a href="#">Bảng giá</a><br>
                <a href="#">Tuyển dụng</a><br>
                <a href="#">Profile Sản Phẩm</a><br>
                <a href="#">Sapo Academy</a><br>
            </div>
            <div class="tab61">
                <a href="#">Sản phẩm</a><br>
                <a href="#">Phần mềm quản lý bán hàng</a><br>
                <a href="#">Phần mềm bán hàng online</a><br>
                <a href="#">Thiết kế website</a><br>
                <a href="#">Phần mềm quản lý sàn TMĐT</a><br>
                <a href="#">Phần mềm quản lý bán hàng trên MXH</a><br>
                <a href="#">Phần mềm quản lý nhà hàng và dịch vụ</a><br>
                <a href="#">Phần mềm bán hàng hợp kênh</a><br>
            </div>
            <div class="tab61">
                <a href="#">Thiết kế website</a><br>
                <a href="#">Thiết kế website bán hàng</a><br>
                <a href="#">Thiết kế web thời trang</a><br>
                <a href="#">Thiết kế website bất động sản</a><br>
                <a href="#">Thiết kế web thương mại điện tử</a><br>
                <a href="#">Mẫu website đẹp</a><br>
                <a href="#">Đăng ký tên miền</a><br>
            </div>
            <div class="tab61">
                <a href="#">Giải pháp quản lý</a><br>
                <a href="#">Quản lý siêu thị mini</a><br>
                <a href="#">Quản lý cửa hàng tạp hóa</a><br>
                <a href="#">Quản lý cửa hàng thời trang</a><br>
                <a href="#">Quản lý cửa hàng mỹ phẩm</a><br>
                <a href="#">Quản lý quán cafe</a><br>
                <a href="#">Quản lý quán bida</a><br>
                <a href="#">Quản lý nhà thuốc</a><br>
                <a href="#">Quản lý trà sữa</a><br>
            </div>
            <div class="tab61">
                <a href="#">Thiết bị bán hàng</a><br>
                <a href="#">Máy in hóa đơn</a><br>
                <a href="#">Máy in mã vạch</a><br>
                <a href="#">Máy quét mã vạch</a><br>
            </div>
        </div>
    </div>
</body>
</html>