<?php
// index.php (Controller)

// === KẾT NỐI PDO ===
$host = 'localhost';
$dbname = 'cse485_web';   // nếu đây là tên CSDL thật của bạn
$username = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
// === KẾT THÚC KẾT NỐI PDO ===

// Gọi Model
require_once __DIR__ . '/models/SinhVienModel.php';

// TODO 8: Kiểm tra xem có hành động POST (thêm sinh viên) không
if (isset($_POST['ten_sinh_vien']) && isset($_POST['email'])) {

    // TODO 9: Nếu có, lấy $ten và $email từ $_POST
    $ten   = $_POST['ten_sinh_vien'];
    $email = $_POST['email'];

    // TODO 10: Gọi hàm addSinhVien() từ Model
    addSinhVien($pdo, $ten, $email);

    // TODO 11: Chuyển hướng về index.php để "làm mới" trang
    header('Location: index.php');
    exit;
}

// TODO 12: (Luôn luôn) Gọi hàm getAllSinhVien() từ Model
$danh_sach_sv = getAllSinhVien($pdo);

// TODO 13: (Rất quan trọng) Import (include) tệp View ở cuối cùng
include __DIR__ . '/views/sinhvien_view.php';

