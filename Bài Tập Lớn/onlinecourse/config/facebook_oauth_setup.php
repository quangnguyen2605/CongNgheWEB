<?php
// Hướng dẫn cài đặt Facebook OAuth
echo "<h2>Cài đặt Facebook OAuth</h2>";
echo "<h3>Bước 1: Tạo Facebook App</h3>";
echo "<ol>";
echo "<li>Truy cập: <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a></li>";
echo "<li>Click 'Create App' → 'Business' hoặc 'Other'</li>";
echo "<li>Nhập app name: 'OnlineCourse Login'</li>";
echo "<li>Nhập contact email</li>";
echo "<li>Click 'Create App'</li>";
echo "</ol>";

echo "<h3>Bước 2: Cấu hình Facebook Login</h3>";
echo "<ol>";
echo "<li>Và 'Products' → 'Add Product' → 'Facebook Login'</li>";
echo "<li>Click 'Set Up' → 'Web'</li>";
echo "<li>Nhập Site URL: <code>http://localhost/onlinecourse/onlinecourse/</code></li>";
echo "<li>Click 'Save'</li>";
echo "</ol>";

echo "<h3>Bước 3: Cấu hình OAuth Redirect</h3>";
echo "<ol>";
echo "<li>Va 'Facebook Login' → 'Settings'</li>";
echo "<li>Trong 'Valid OAuth Redirect URIs', thêm: <code>http://localhost/onlinecourse/onlinecourse/index.php?controller=Auth&action=facebookCallback</code></li>";
echo "<li>Click 'Save Changes'</li>";
echo "</ol>";

echo "<h3>Bước 4: Lấy App Credentials</h3>";
echo "<ol>";
echo "<li>Va 'Settings' → 'Basic'</li>";
echo "<li>Copy 'App ID' và 'App Secret'</li>";
echo "<li>Cập nhật trong file config/oauth_config.php:</li>";
echo "</ol>";

echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
echo "const FACEBOOK_APP_ID = 'YOUR_APP_ID_HERE';";
echo "const FACEBOOK_APP_SECRET = 'YOUR_APP_SECRET_HERE';";
echo "</pre>";

echo "<h3>Bước 5: Test</h3>";
echo "<ol>";
echo "<li>Click Facebook login trên trang đăng nhập</li>";
echo "<li>Sẽ chuyển đến trang đăng nhập Facebook thật</li>";
echo "<li>Nhập email và mật khẩu Facebook</li>";
echo "<li>Cho phép ứng dụng truy cập thông tin</li>";
echo "<li>Sẽ chuyển về lại trang của bạn với user data</li>";
echo "</ol>";

echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 5px; margin-top: 20px;'>";
echo "<strong>Lưu ý:</strong> Trong môi trường development, Facebook chỉ cho phép redirect về localhost hoặc https.";
echo "</div>";
?>
