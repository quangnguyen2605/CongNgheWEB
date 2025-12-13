<?php 
$page_title = "Danh sách khóa học";
require __DIR__ . '/../layouts/header.php'; 
?>

<style>
.course-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #e5e7eb;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}

.text-decoration-none {
    text-decoration: none !important;
    color: inherit !important;
}

.text-decoration-none:hover {
    text-decoration: none !important;
    color: inherit !important;
}

.course-img {
    height: 200px;
    width: 100%;
    object-fit: cover;
    position: relative;
}

.course-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #6366f1;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.course-body {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.course-category {
    font-size: 0.8rem;
    color: #6366f1;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.course-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #1e293b;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-instructor {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.course-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.course-rating {
    display: flex;
    align-items: center;
    gap: 4px;
}

.course-rating .stars {
    color: #ffc107;
    font-size: 0.9rem;
}

.course-rating .rating-count {
    color: #6c757d;
    font-size: 0.9rem;
    margin-left: 4px;
}

.course-price {
    font-weight: 700;
    color: #6366f1;
    font-size: 1.2rem;
}

.course-price .original-price {
    text-decoration: line-through;
    color: #6c757d;
    font-size: 0.9rem;
    margin-right: 8px;
}
</style>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="mb-4"><i class="fas fa-book"></i> Danh sách khóa học</h2>
        
        <!-- Form tìm kiếm và lọc -->
        <form method="GET" action="index.php" class="row g-3 mb-4">
            <input type="hidden" name="controller" value="Course">
            <input type="hidden" name="action" value="index">
            
            <div class="col-md-6">
                <input type="text" class="form-control" name="keyword" 
                       placeholder="Tìm kiếm khóa học..." 
                       value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
            </div>
            
            <div class="col-md-4">
                <select class="form-select" name="category_id">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"
                                <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo $cat['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <?php if(count($courses) > 0): ?>
        <?php foreach($courses as $course): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?php echo $course['id']; ?>" class="text-decoration-none">
                    <div class="course-card">
                        <div class="position-relative">
                            <?php if($course['image']): ?>
                                <img src="<?php echo htmlspecialchars($course['image']); ?>" 
                                     class="course-img" alt="<?php echo $course['title']; ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x200/6366f1/ffffff?text=Khóa+học" 
                                     class="course-img" alt="<?php echo $course['title']; ?>">
                            <?php endif; ?>
                            <span class="course-badge">Phổ biến</span>
                        </div>
                        <div class="course-body">
                            <div class="course-category"><?php echo $course['category_name']; ?></div>
                            <h3 class="course-title"><?php echo $course['title']; ?></h3>
                            <p class="course-instructor">Bởi <?php echo $course['instructor_name']; ?></p>
                            <div class="course-meta">
                                <div class="course-rating">
                                    <span class="stars">
                                        <?php 
                                        $rating = 4.5 + (rand(0, 8) / 10);
                                        for($i = 1; $i <= 5; $i++) {
                                            if($i <= floor($rating)) {
                                                echo '<i class="fas fa-star"></i>';
                                            } elseif($i - 0.5 <= $rating) {
                                                echo '<i class="fas fa-star-half-alt"></i>';
                                            } else {
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                        ?>
                                    </span>
                                    <span class="rating-count"><?php echo $rating; ?></span>
                                    <span class="rating-count">(<?php echo rand(100, 2000); ?>)</span>
                                </div>
                                <div class="course-price">
                                    <?php 
                                    $originalPrice = $course['price'] > 0 ? $course['price'] * 1.5 : 0;
                                    if($originalPrice > 0): ?>
                                        <span class="original-price"><?php echo number_format($originalPrice); ?> VNĐ</span>
                                    <?php endif; ?>
                                    <?php echo number_format($course['price']); ?> VNĐ
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> 
                <?php 
                if (isset($_GET['keyword']) || isset($_GET['category_id'])) {
                    echo 'Không tìm thấy khóa học nào phù hợp với tiêu chí tìm kiếm.';
                } else {
                    echo 'Chưa có khóa học nào được duyệt. Khóa học sẽ hiển thị sau khi được quản trị viên phê duyệt.';
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>