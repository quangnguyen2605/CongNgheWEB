# Hệ Thống Khóa Học Online

## Tổng Quan
Hệ thống khóa học online là nền tảng giáo dục trực tuyến cho phép giảng viên tạo và quản lý khóa học, học viên tham gia học tập và theo dõi tiến trình.

## Tính Năng Chính

### Đối Với Giảng Viên
- **Tạo và quản lý khóa học**: Tạo khóa học mới, chỉnh sửa thông tin, quản lý nội dung
- **Quản lý bài học**: Thêm bài học, tài liệu, video cho từng khóa học
- **Theo dõi học viên**: Xem danh sách học viên, theo dõi tiến trình học tập
- **Tương tác với học viên**: Trả lời câu hỏi, đánh giá bài tập

### Đối Với Học Viên
- **Duyệt khóa học**: Tìm kiếm và khám phá các khóa học theo danh mục
- **Đăng ký khóa học**: Thanh toán và tham gia các khóa học
- **Học tập online**: Xem bài giảng, tải tài liệu, xem video
- **Theo dõi tiến trình**: Xem tiến trình học tập, hoàn thành bài kiểm tra

### Đối Với Quản Trị Viên
- **Quản lý người dùng**: Phân quyền, quản lý tài khoản giảng viên và học viên
- **Quản lý khóa học**: Phê duyệt khóa học, quản lý danh mục
- **Thống kê**: Xem báo cáo, thống kê về hệ thống
- **Quản lý nội dung**: Kiểm duyệt nội dung, quản lý tài liệu

## Công Nghệ
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Custom MVC Architecture

## Cấu Trúc
- `controllers/`: Điều khiển logic nghiệp vụ
- `models/`: Mô hình dữ liệu và tương tác database
- `views/`: Giao diện người dùng
- `config/`: Cấu hình hệ thống
- `assets/`: Tài nguyên tĩnh (CSS, JS, hình ảnh)

## Cài Đặt
1. Clone repository
2. Import database từ `sample_data.sql`
3. Cấu hình kết nối database trong `config/Database.php`
4. Truy cập ứng dụng qua trình duyệt
