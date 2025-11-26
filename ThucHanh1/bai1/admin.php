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
];

// Xử lý CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                // Thêm hoa mới
                $newFlower = [
                    'id' => count($flowers) + 1,
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'image' => $_POST['image']
                ];
                $flowers[] = $newFlower;
                break;
                
            case 'edit':
                // Sửa thông tin hoa
                $id = $_POST['id'];
                foreach ($flowers as &$flower) {
                    if ($flower['id'] == $id) {
                        $flower['name'] = $_POST['name'];
                        $flower['description'] = $_POST['description'];
                        $flower['image'] = $_POST['image'];
                        break;
                    }
                }
                break;
                
            case 'delete':
                // Xóa hoa
                $id = $_POST['id'];
                $flowers = array_filter($flowers, function($flower) use ($id) {
                    return $flower['id'] != $id;
                });
                // Reset array keys
                $flowers = array_values($flowers);
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị - Danh sách hoa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Quản trị danh sách hoa</h1>
            <nav>
                <a href="index.php">Chế độ khách</a>
                <a href="admin.php">Chế độ quản trị</a>
            </nav>
        </header>

        <!-- Form thêm hoa mới -->
        <div class="add-form">
            <h2>Thêm hoa mới</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" placeholder="Tên hoa" required>
                <textarea name="description" placeholder="Mô tả" required></textarea>
                <input type="text" name="image" placeholder="Đường dẫn ảnh" required>
                <button type="submit">Thêm</button>
            </form>
        </div>

        <!-- Bảng hiển thị danh sách hoa -->
        <div class="flowers-table">
            <h2>Danh sách hoa</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên hoa</th>
                        <th>Mô tả</th>
                        <th>Ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flowers as $flower): ?>
                    <tr>
                        <td><?php echo $flower['id']; ?></td>
                        <td><?php echo htmlspecialchars($flower['name']); ?></td>
                        <td><?php echo htmlspecialchars($flower['description']); ?></td>
                        <td>
                            <img src="<?php echo $flower['image']; ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>" class="thumbnail" onerror="this.src='images/default.jpg'">
                        </td>
                        <td class="actions">
                            <!-- Form sửa -->
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?php echo $flower['id']; ?>">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($flower['name']); ?>" required>
                                <textarea name="description" required><?php echo htmlspecialchars($flower['description']); ?></textarea>
                                <input type="text" name="image" value="<?php echo $flower['image']; ?>" required>
                                <button type="submit" class="btn-edit">Sửa</button>
                            </form>
                            
                            <!-- Form xóa -->
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $flower['id']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>