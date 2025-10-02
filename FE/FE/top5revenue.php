<?php
include 'connect.php';

$sql = "
SELECT
    sp.MaSP,
    sp.TenSP,
    sp.MaSKU,
    sp.GiaBan,
    COALESCE(SUM(ct.SoLuong), 0) AS SoLuongBan,
    COALESCE(SUM(ct.SoLuong * ct.DonGia), 0.00) AS DoanhThu
FROM SanPham sp
JOIN ChiTietDonHang ct ON sp.MaSP = ct.MaSP
JOIN DonHang dh ON dh.MaDH = ct.MaDH
WHERE dh.TrangThai IS NULL OR dh.TrangThai != 'Đã hủy'
GROUP BY sp.MaSP, sp.TenSP, sp.MaSKU, sp.GiaBan
ORDER BY DoanhThu DESC
LIMIT 5
";

$result = $conn->query($sql);

$topProducts = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $topProducts[] = $row;
    }
}

function format_vnd($num) {
    return number_format((float)$num, 0, '.', ',') . ' ₫';
}
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8" />
<title>Top 5 sản phẩm bán chạy</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f7fb; margin:0; padding:28px; color:#17202a;">
<div style="max-width:980px; margin:0 auto;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;">
        <div style="font-size:20px; font-weight:700;">
            Top 5 sản phẩm bán chạy 
            
        </div>
        
    </div>

    <div style="background:#fff; border-radius:12px; box-shadow:0 6px 18px rgba(23,32,42,0.06); padding:18px;">
        <?php if (!$topProducts): ?>
            <div style="padding:28px; text-align:center; color:#6b7785;">Chưa có dữ liệu bán hàng để hiển thị.</div>
        <?php else: ?>
            <table style="width:100%; border-collapse:collapse; margin-top:8px; font-size:14px;">
                <thead>
                    <tr>
                        <th style="padding:12px 10px; text-align:center; border-bottom:1px solid #eef2f6; font-weight:700; color:#34495e; font-size:13px; text-transform:uppercase; letter-spacing:0.6px;">#</th>
                        <th style="padding:12px 10px; text-align:left; border-bottom:1px solid #eef2f6; font-weight:700; color:#34495e; font-size:13px; text-transform:uppercase; letter-spacing:0.6px;">Sản phẩm</th>
                        <th style="padding:12px 10px; text-align:center; border-bottom:1px solid #eef2f6; font-weight:700; color:#34495e; font-size:13px; text-transform:uppercase; letter-spacing:0.6px;">Đã bán (SL)</th>

                        <th style="padding:12px 10px; text-align:right; border-bottom:1px solid #eef2f6; font-weight:700; color:#34495e; font-size:13px; text-transform:uppercase; letter-spacing:0.6px;">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($topProducts as $i => $p): ?>
                    <tr>
                        <td style="padding:12px 10px; text-align:center; border-bottom:1px solid #eef2f6; font-weight:700;"><?php echo $i+1; ?></td>
                        <td style="padding:12px 10px; border-bottom:1px solid #eef2f6;">
                            <div style="font-weight:700;"><?php echo htmlspecialchars($p['TenSP']); ?></div>
                            <?php if (!empty($p['MaSKU'])): ?>
                                <div style="font-size:12px; color:#8a97a6; background:#f1f6fa; display:inline-block; padding:4px 8px; border-radius:8px; margin-top:4px;">
                                    SKU: <?php echo htmlspecialchars($p['MaSKU']); ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="padding:12px 10px; text-align:center; border-bottom:1px solid #eef2f6; font-weight:700;"><?php echo number_format((int)$p['SoLuongBan']); ?></td>

                        <td style="padding:12px 10px; text-align:right; border-bottom:1px solid #eef2f6; font-weight:700;"><?php echo format_vnd($p['DoanhThu']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            
        <?php endif; ?>
    </div>
</div>
</body>
</html>
