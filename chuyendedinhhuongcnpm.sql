-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 17, 2025 lúc 06:28 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `chuyendedinhhuongcnpm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaCTDH` int(11) NOT NULL,
  `MaDH` int(11) DEFAULT NULL,
  `MaSP` int(11) DEFAULT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(15,2) NOT NULL,
  `MaND` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaCTDH`, `MaDH`, `MaSP`, `SoLuong`, `DonGia`, `MaND`) VALUES
(4, 2, 4, 1, 28000000.00, NULL),
(5, 56, 98, 1, 0.00, NULL),
(6, 56, 103, 1, 0.00, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDM` int(11) NOT NULL,
  `TenDM` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `MaND` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDM`, `TenDM`, `MoTa`, `MaND`) VALUES
(1, 'Điện thoại', 'Các dòng điện thoại di động', NULL),
(2, 'Laptop', 'Máy tính xách tay các hãng', NULL),
(3, 'Phụ kiện', 'Phụ kiện điện tử', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` int(11) NOT NULL,
  `NgayLap` date NOT NULL,
  `TrangThai` varchar(50) NOT NULL DEFAULT 'Chờ xử lý',
  `ThanhTien` decimal(15,2) DEFAULT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `TenKH` varchar(100) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `MaND` int(11) DEFAULT NULL,
  `MaSP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDH`, `NgayLap`, `TrangThai`, `ThanhTien`, `MaKH`, `TenKH`, `MaNV`, `MaND`, `MaSP`) VALUES
(1, '2025-09-01', 'Chờ xử lý', 1500000.00, 1, 'Phạm Văn A', 2, 29, NULL),
(2, '2025-09-02', 'Chờ xử lý', 2500000.00, 2, 'Trần Thị B', 2, NULL, NULL),
(31, '2025-10-07', 'Chờ xử lý', 120000.00, 1, 'Nguyễn Văn A', NULL, NULL, NULL),
(32, '2025-10-07', 'Chờ xử lý', 120000.00, 50, 'Nguyễn Văn Mười', NULL, NULL, NULL),
(53, '2025-10-18', 'Chờ xử lý', 178000.00, 52, 'Nguyễn Thị H', 2, 29, NULL),
(54, '2025-10-16', 'Chờ xử lý', 120000.00, 1, 'Nguyễn Văn A', 2, 29, NULL),
(55, '2025-10-16', 'Chờ xử lý', 298000.00, 1, 'Nguyễn Văn A', 2, 29, NULL),
(56, '2025-10-16', 'Chờ xử lý', 0.00, 1, 'Nguyễn Văn A', 1, 29, NULL),
(57, '2025-10-16', 'Chờ xử lý', 298000.00, 52, 'Nguyễn Thị H', 1, 29, NULL),
(58, '2025-10-16', 'Chờ xử lý', 298000.00, 52, 'Nguyễn Thị H', 1, 29, NULL),
(59, '2025-10-17', 'Chờ xử lý', 120000.00, 1, 'Nguyễn Văn A', 2, 29, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGH` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT 1,
  `NgayThem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGH`, `MaKH`, `MaSP`, `SoLuong`, `NgayThem`) VALUES
(2, 54, 109, 3, '2025-10-17 09:15:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen` varchar(150) NOT NULL,
  `DienThoai` varchar(20) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `MaND` int(11) DEFAULT NULL,
  `MatKhau` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `HoTen`, `DienThoai`, `DiaChi`, `Email`, `MaND`, `MatKhau`) VALUES
(1, 'Nguyễn Văn A', '0901234567', 'Hà Nội', 'vana@example.com', 29, ''),
(2, 'Trần Thị B', '0912345678', 'TP.HCM', 'thib@example.com', NULL, ''),
(33, 'Nguyễn Thị Em', '0403940930', 'Tà Tà', 'E@gmail.com', NULL, ''),
(41, 'Bé Thị To', '4304309', 'Ngã Tư Cầu Diễn', 'Tobe@gmail.com', NULL, ''),
(50, 'Nguyễn Văn Mười', '09434434343', 'Khu 2 , Hoàng Cương, Thanh Ba, Phú Thọ', 'muoinguyen0101@gmail.com', NULL, ''),
(52, 'Nguyễn Thị H', '0493094039', 'Khu 2 , Hoàng Cương, Thanh Ba, Phú Thọ', 'manpham@gamil.com', 29, ''),
(53, 'Nguyễn Thị M', '094039043', NULL, 'Mnguyen@gmail.com', NULL, ''),
(54, 'nguyễn văn B', '093493094', NULL, 'bnguyen@gmail.com', NULL, '123'),
(55, 'cho', '093094039', NULL, 'cho@gmail.com', NULL, '$2y$10$f4GI/3H.U0Onb7DSmAC0Y.UWJjVI9AgzJzEDIRSgdo5yR0PXfpEDC'),
(56, 'meo', '092309203', NULL, 'meo@gmail.com', NULL, '1234'),
(57, 'Nguyễn Thị M', '09403940394', 'dkfjdkjfkdf', 'M@gmail.com', 29, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaND` int(11) NOT NULL,
  `TenDangNhap` varchar(50) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `QuyenHan` enum('Admin','NhanVien','KhachHang') NOT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `MaKH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaND`, `TenDangNhap`, `MatKhau`, `QuyenHan`, `SDT`, `MaNV`, `MaKH`) VALUES
(1, 'admin', '123456', 'Admin', '0901234567', 1, NULL),
(2, 'nhanvien1', '123456', 'NhanVien', '0912345678', 2, NULL),
(3, 'khach1', '123456', 'KhachHang', '0923456789', NULL, 1),
(4, 'khach2', '123456', 'KhachHang', '0934567890', NULL, 2),
(5, 'admin@gmail.com', '123', 'KhachHang', '0945678901', NULL, NULL),
(6, '', '', '', '', NULL, NULL),
(19, 'manpham', '$2y$10$7h7csZdXMhcCaSg1q0j.7.JKpRp4YxR1iUywJ2SC7HdWoBgo0E8Xq', 'Admin', '434344', NULL, NULL),
(20, 'manh', '19072004', 'Admin', '2222222222', NULL, NULL),
(21, 'không tên', '123', '', '43994834', NULL, NULL),
(22, 'hehe', 'hehe987654321', '', '47938948394', NULL, NULL),
(23, 'Nguyễn Văn Mười', '123456789', '', '984039049', NULL, NULL),
(24, 'dannguyen', '123456789', '', '904930943', NULL, NULL),
(25, 'meo', 'meo12345', '', '043948394', NULL, NULL),
(26, 'faker', '$2y$10$yV3UOurGMqUGWuJTSRFtEOKLlOJO9VymoONQMRNokKLnvUF2DB7Pe', '', '09493894', NULL, NULL),
(27, 'baker', '$2y$10$.XAXZaKxh3r/ikDwW/yvZuW5bhHKJ/N93ij9cm2j8dqvy1KHvZyKu', '', '085948954', NULL, NULL),
(28, 'hava', 'hava987654321', 'Admin', '3940394', NULL, NULL),
(29, 'leo', '123456789', 'Admin', '09494893', NULL, NULL),
(30, 'kk', '123', 'Admin', '9439049', NULL, NULL),
(33, 'manh1907', '$2y$10$iCtBi94d6rJfJkn/K5sIYOSeY8.6wW/T6.2KqZoePaFPGCWtNEAx.', 'KhachHang', '04039043', NULL, NULL),
(34, 'beo', '1234', '', '0594059045', NULL, NULL),
(35, 'dan', '123456789', '', '9430490394', NULL, NULL),
(37, 'k', '1234', '', '0943094', NULL, NULL),
(38, 'o', '1234', '', '49309403', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `HoTen` varchar(150) NOT NULL,
  `ChucVu` varchar(100) DEFAULT NULL,
  `MaND` int(11) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `HoTen`, `ChucVu`, `MaND`, `SDT`, `Email`, `DiaChi`) VALUES
(1, 'Lê Văn l', 'Nhân viên bán hàng', 29, NULL, NULL, NULL),
(2, 'Phạm Thị D', 'Nhân viên bán hàng', 29, NULL, NULL, NULL),
(7, 'Nguyễn Văn C', '0', 29, '49094909', '0', 'Khu 2 , Hoàng Cương, Thanh Ba, Phú Thọ'),
(8, 'Nguyễn Văn Tờ', '0', 35, '8493894', '0', 'ủieurrrrrrrrr'),
(9, 'kdjfffd', 'Nhân viên bán hàng', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(150) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `GiaBan` decimal(15,2) NOT NULL,
  `SoLuongTon` int(11) DEFAULT 0,
  `MaDM` int(11) DEFAULT NULL,
  `MaSKU` varchar(50) DEFAULT NULL,
  `MoTa` text DEFAULT NULL,
  `GiaVon` decimal(15,2) DEFAULT NULL,
  `MaND` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `img`, `GiaBan`, `SoLuongTon`, `MaDM`, `MaSKU`, `MoTa`, `GiaVon`, `MaND`) VALUES
(4, 'MacBook Air M2', NULL, 280000.00, 7, 2, 'MBAIRM2', 'MacBook chip M2 mới nhất', 242.00, NULL),
(95, 'Cục sạc iphone 18', NULL, 50000.00, 10, 1, 'sacocn', 'd', 30000.00, NULL),
(96, 'Samsung Galaxy S23', NULL, 18000000.00, 10, 1, 'e', 'r', 23232.00, NULL),
(97, 'máy tính asus Việt Nam', NULL, 15999000.00, 8, 1, 'rrrr', 'chơi gì thì chơi đừng chơi game', 33434.00, NULL),
(98, 'Capypara ', 'uploads/1760610840_R.jfif', 120000.00, 998, 1, 'cc', 'so cute', 50000.00, 29),
(99, 'bánh', NULL, 90000.00, 99, 1, 'kjfkdf', 'kjfkdjkfjdk', 5000.00, NULL),
(100, 'bánh', NULL, 90000.00, 99, 1, 'kjfkdf', 'eeeeeeee', 5000.00, 0),
(102, 'Iphone 3', 'uploads/1760610962_OIP.webp', 900000000.00, 1, 1, 'ip', 'ggggggggg', 50000000.00, 30),
(103, 'Doraemon', 'uploads/1760610833_OIP.webp', 178000.00, 19, 1, 'dr', 'đẹp phết mà cute nữa chứ', 50000.00, 29),
(104, 'bánh mỳ ', 'uploads/1760610952_R.jfif', 30000.00, 10, 1, 'fffff', 'ngonnn', 10000.00, 30),
(107, 'que', 'uploads/1760610580_Screenshot 2025-09-29 154109.png', 19999999.00, 1, 1, 'eeeee', 'eeeeeeeeeeeeee', 39000.00, 29),
(108, 'Iphone 15 pro max', 'uploads/1760632265_5-hinh-anh-iphone-15-pro-max-didongviet.jpg', 34000000.00, 19, 1, 'ip', 'máy mới cực kỳ đẹp và thời trang nhé', 20000000.00, 29),
(109, 'Samsung Galaxy S23', 'uploads/1760632386_4199-6405.webp', 30000000.00, 5, 1, 'sam', 'Máy đẹp, cam nét, xếp Huy rất yêu', 15000000.00, 29),
(110, 'Samsung Galaxy S23', 'uploads/1760688259_4c0df68c-908e-406d-aff9-2ac19f96b0bb.png', 30000000.00, 5, 1, 'sam', 'kkkkkkkkk', 15000000.00, 29);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaCTDH`),
  ADD KEY `MaDH` (`MaDH`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDM`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDH`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGH`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaND`),
  ADD UNIQUE KEY `TenDangNhap` (`TenDangNhap`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaDM` (`MaDM`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `MaCTDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `MaND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`),
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`),
  ADD CONSTRAINT `nguoidung_ibfk_2` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaDM`) REFERENCES `danhmuc` (`MaDM`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
