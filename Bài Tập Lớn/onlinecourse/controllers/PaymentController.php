<?php
class PaymentController
{
    private function requireLogin()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function checkout()
    {
        $this->requireLogin();
        
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];
        
        if ($courseId === 0) {
            $_SESSION['error'] = 'Khóa học không hợp lệ!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $courseModel = new Course();
        $course = $courseModel->getCourseWithInstructor($courseId);
        
        if (!$course) {
            $_SESSION['error'] = 'Khóa học không tồn tại!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $enrollmentModel = new Enrollment();
        if ($enrollmentModel->isEnrolled($studentId, $courseId)) {
            $_SESSION['error'] = 'Bạn đã đăng ký khóa học này rồi!';
            header('Location: index.php?controller=Student&action=myCourses');
            exit;
        }
        
        $pageTitle = 'Thanh toán khóa học';
        require __DIR__ . '/../views/payment/checkout.php';
    }

    public function processPayment()
    {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $courseId = (int)($_POST['course_id'] ?? 0);
        $studentId = (int)$_SESSION['user_id'];
        $paymentMethod = $_POST['payment_method'] ?? '';
        $amount = (float)($_POST['amount'] ?? 0);
        
        if ($courseId === 0 || empty($paymentMethod) || $amount <= 0) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ!';
            header("Location: index.php?controller=Payment&action=checkout&course_id=$courseId");
            exit;
        }
        
        $paymentModel = new Payment();
        
        // Check for existing pending payment
        $existingPayment = $paymentModel->checkPendingPayment($courseId, $studentId);
        if ($existingPayment) {
            $paymentId = $existingPayment['id'];
        } else {
            $paymentId = $paymentModel->createPaymentOrder($courseId, $studentId, $amount, $paymentMethod);
        }
        
        // Redirect to appropriate payment gateway
        switch ($paymentMethod) {
            case 'zalopay':
                header("Location: index.php?controller=Payment&action=zaloPay&payment_id=$paymentId");
                break;
            case 'mbbank':
                header("Location: index.php?controller=Payment&action=mbbank&payment_id=$paymentId");
                break;
            default:
                $_SESSION['error'] = 'Phương thức thanh toán không được hỗ trợ!';
                header("Location: index.php?controller=Payment&action=checkout&course_id=$courseId");
                break;
        }
        exit;
    }

    public function zaloPay()
    {
        $this->requireLogin();
        $paymentId = isset($_GET['payment_id']) ? (int)$_GET['payment_id'] : 0;
        
        if ($paymentId === 0) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $paymentModel = new Payment();
        $payment = $paymentModel->getPaymentById($paymentId);
        
        if (!$payment || $payment['student_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không tìm thấy thông tin thanh toán!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $pageTitle = 'Thanh toán qua ZaloPay';
        require __DIR__ . '/../views/payment/zalopay.php';
    }

    public function mbbank()
    {
        $this->requireLogin();
        $paymentId = isset($_GET['payment_id']) ? (int)$_GET['payment_id'] : 0;
        
        if ($paymentId === 0) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $paymentModel = new Payment();
        $payment = $paymentModel->getPaymentById($paymentId);
        
        if (!$payment || $payment['student_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không tìm thấy thông tin thanh toán!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $pageTitle = 'Thanh toán qua MB Bank';
        // Pass payment data to view
        include __DIR__ . '/../views/payment/mbbank.php';
    }

    public function banking()
    {
        $this->requireLogin();
        $paymentId = isset($_GET['payment_id']) ? (int)$_GET['payment_id'] : 0;
        
        if ($paymentId === 0) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $paymentModel = new Payment();
        $payment = $paymentModel->getPaymentById($paymentId);
        
        if (!$payment || $payment['student_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không tìm thấy thông tin thanh toán!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $pageTitle = 'Thanh toán qua ngân hàng';
        require __DIR__ . '/../views/payment/banking.php';
    }

    public function paymentSuccess()
    {
        $this->requireLogin();
        $paymentId = isset($_GET['payment_id']) ? (int)$_GET['payment_id'] : 0;
        
        if ($paymentId === 0) {
            $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $paymentModel = new Payment();
        $payment = $paymentModel->getPaymentById($paymentId);
        
        if (!$payment || $payment['student_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không tìm thấy thông tin thanh toán!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        // Update payment status to completed
        $paymentModel->updatePaymentStatus($paymentId, 'completed', 'TXN' . time());
        
        // Enroll student in course
        $enrollmentModel = new Enrollment();
        if (!$enrollmentModel->isEnrolled($payment['student_id'], $payment['course_id'])) {
            $enrollmentModel->enroll($payment['course_id'], $payment['student_id']);
        }
        
        $_SESSION['success'] = 'Thanh toán thành công! Bạn đã được đăng ký khóa học.';
        header('Location: index.php?controller=Student&action=myCourses');
        exit;
    }

    public function paymentFailed()
    {
        $this->requireLogin();
        $paymentId = isset($_GET['payment_id']) ? (int)$_GET['payment_id'] : 0;
        
        if ($paymentId > 0) {
            $paymentModel = new Payment();
            $paymentModel->updatePaymentStatus($paymentId, 'failed');
        }
        
        $_SESSION['error'] = 'Thanh toán thất bại. Vui lòng thử lại.';
        header('Location: index.php?controller=Student&action=browseCourses');
        exit;
    }

    public function paymentHistory()
    {
        $this->requireLogin();
        $studentId = (int)$_SESSION['user_id'];
        
        $paymentModel = new Payment();
        $payments = $paymentModel->getPaymentsByStudent($studentId);
        
        $pageTitle = 'Lịch sử thanh toán';
        require __DIR__ . '/../views/payment/history.php';
    }
}
