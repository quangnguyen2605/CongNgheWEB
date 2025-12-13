<?php
// File này để tạo QR code cho MB Bank
require_once __DIR__ . '/../config/Database.php';

// Dữ liệu QR cho MB Bank
$qrData = '000201010212113009950008760000000010011620700018VIETQR0003017000189704360006NGUYEN VAN QUANG0052612200502048402';

// Tạo QR code bằng API
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);

// Lưu ảnh QR code
$imageContent = file_get_contents($qrUrl);
if ($imageContent) {
    file_put_contents(__DIR__ . '/../assets/images/mbbank-qr-new.png', $imageContent);
    echo "Đã tạo QR code MB Bank mới thành công!";
} else {
    echo "Không thể tạo QR code. Vui lòng thử lại.";
}

// Tạo QR code cho ZaloPay
$zaloPayData = 'ZALOPAY_' . time();
$zaloUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($zaloPayData);

$imageContent = file_get_contents($zaloUrl);
if ($imageContent) {
    file_put_contents(__DIR__ . '/../assets/images/zalopay-qr-new.png', $imageContent);
    echo "Đã tạo QR code ZaloPay mới thành công!";
} else {
    echo "Không thể tạo QR code ZaloPay. Vui lòng thử lại.";
}
?>
