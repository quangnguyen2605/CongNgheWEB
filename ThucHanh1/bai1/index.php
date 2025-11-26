<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>14 loại hoa tuyệt đẹp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè</h1>
            <nav>
                <a href="index.php">Chế độ khách</a>
                <a href="admin.php">Chế độ quản trị</a>
            </nav>
        </header>

        <div class="flowers-grid">
            <?php
            // Mảng lưu trữ thông tin các loài hoa
            $flowers = [
                [
                    'id' => 1,
                    'name' => 'Hoa Hải Đường', 
                    'description' => 'Hoa hải đường ngắn gọn là biểu tượng cho sự giàu sang, phú quý, may mắn và thịnh vượng',
                    'image' => 'images/haiduong.jpg'
                ],
                [
                    'id' => 2,
                    'name' => 'Hoa Tường Vy',
                    'description' => 'Hoa tường vi ngắn gọn là biểu tượng cho sự dịu dàng, thanh cao và kiên cường',
                    'image' => 'images/tuongvy.jpg'
                ],
                [
                    'id' => 3,
                    'name' => 'Hoa Mai',
                    'description' => 'Hoa mai là biểu tượng cho sự may mắn, tài lộc, thịnh vượng và khởi đầu mới, đặc biệt là trong dịp Tết Nguyên Đán ở Việt Nam',
                    'image' => 'images/mai.jpg'
                ],
                [
                    'id' => 4,
                    'name' => 'Hoa Đỗ Quyên',
                    'description' => 'Hoa đỗ quyên tượng trưng cho tình yêu son sắt, thủy chung và sự may mắn, sum vầy trong gia đình',
                    'image' => 'images/doquyen.jpg'
                ],
                // Thêm các loài hoa khác ở đây...
            ];

            // Hiển thị danh sách hoa
            foreach ($flowers as $flower) {
                echo "
                <div class='flower-card'>
                    <div class='flower-image'>
                        <img src='{$flower['image']}' alt='{$flower['name']}' onerror=\"this.src='images/default.jpg'\">
                    </div>
                    <div class='flower-info'>
                        <h3>{$flower['name']}</h3>
                        <p>{$flower['description']}</p>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </div>
</body>
</html>