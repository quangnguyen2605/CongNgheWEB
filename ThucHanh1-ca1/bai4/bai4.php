
<?php
session_start();

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'thuchanh1_ca1';

// Kết nối PDO (DB vẫn quản lý qua phpMyAdmin)
try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    $dbError = 'Không kết nối được CSDL (PDO): ' . $e->getMessage();
}

$messages = [];

function handleQuizUpload($pdo)
{
    global $messages;
    if (!isset($_FILES['quiz_file']) || $_FILES['quiz_file']['error'] !== UPLOAD_ERR_OK) {
        $messages[] = 'Lỗi upload file quiz.';
        return;
    }

    $tmpName = $_FILES['quiz_file']['tmp_name'];
    $content = file_get_contents($tmpName);
    if ($content === false) {
        $messages[] = 'Không đọc được nội dung file quiz.';
        return;
    }

    $lines = preg_split('/\r\n|\r|\n/', $content);
    $questions = [];
    $currentQuestion = null;

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }

        if (preg_match('/^(.+?)\?$/u', $line, $m)) {
            if ($currentQuestion) {
                $questions[] = $currentQuestion;
            }
            $currentQuestion = [
                'text' => $m[1] . '?',
                'options' => [],
                'answers' => []
            ];
        } elseif (preg_match('/^([A-D])\.\s*(.+)$/u', $line, $m)) {
            if ($currentQuestion) {
                $currentQuestion['options'][$m[1]] = $m[2];
            }
        } elseif (preg_match('/^ANSWER:\s*([A-D, ]+)$/i', $line, $m)) {
            if ($currentQuestion) {
                $ansLetters = preg_split('/\s*,\s*/', strtoupper($m[1]));
                $currentQuestion['answers'] = array_filter($ansLetters, function ($a) {
                    return $a !== '';
                });
                $questions[] = $currentQuestion;
                $currentQuestion = null;
            }
        }
    }

    if ($currentQuestion) {
        $questions[] = $currentQuestion;
    }

    if (empty($questions)) {
        $messages[] = 'Không phân tích được câu hỏi nào từ file quiz.';
        return;
    }

    if (!isset($pdo)) {
        $messages[] = 'Không có kết nối CSDL (PDO) để lưu câu hỏi.';
        return;
    }

    // Tạo bảng nếu chưa có
    $pdo->exec('CREATE TABLE IF NOT EXISTS quiz_questions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question_text TEXT NOT NULL,
        option_a TEXT NULL,
        option_b TEXT NULL,
        option_c TEXT NULL,
        option_d TEXT NULL,
        correct_answers VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

    if (isset($_POST['clear_quiz']) && $_POST['clear_quiz'] === '1') {
        $pdo->exec('TRUNCATE TABLE quiz_questions');
    }

    $stmt = $pdo->prepare('INSERT INTO quiz_questions (question_text, option_a, option_b, option_c, option_d, correct_answers) VALUES (:text, :a, :b, :c, :d, :correct)');

    $inserted = 0;
    foreach ($questions as $q) {
        $opts = $q['options'];
        $a = $opts['A'] ?? null;
        $b = $opts['B'] ?? null;
        $c = $opts['C'] ?? null;
        $d = $opts['D'] ?? null;
        $correct = implode(',', $q['answers']);

        if ($stmt->execute([
            ':text'    => $q['text'],
            ':a'       => $a,
            ':b'       => $b,
            ':c'       => $c,
            ':d'       => $d,
            ':correct' => $correct,
        ])) {
            $inserted++;
        }
    }

    $messages[] = 'Đã lưu ' . $inserted . ' câu hỏi quiz vào bảng quiz_questions.';
}

function handleStudentUpload($pdo)
{
    global $messages;
    if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
        $messages[] = 'Lỗi upload file CSV.';
        return;
    }

    $tmpName = $_FILES['csv_file']['tmp_name'];
    $file = fopen($tmpName, 'r');
    if (!$file) {
        $messages[] = 'Không mở được file CSV.';
        return;
    }

    $header = fgetcsv($file);
    if ($header && isset($header[0]) && strpos($header[0], "﻿") === 0) {
        $header[0] = substr($header[0], 3);
    }

    if (!isset($pdo)) {
        fclose($file);
        $messages[] = 'Không có kết nối CSDL (PDO) để lưu sinh viên.';
        return;
    }

    // Tạo bảng nếu chưa có
    $pdo->exec('CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        lastname VARCHAR(100) NOT NULL,
        firstname VARCHAR(100) NOT NULL,
        city VARCHAR(100) NULL,
        email VARCHAR(150) NULL,
        course1 VARCHAR(150) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

    if (isset($_POST['clear_students']) && $_POST['clear_students'] === '1') {
        $pdo->exec('TRUNCATE TABLE students');
    }

    $stmt = $pdo->prepare('INSERT INTO students (username, password, lastname, firstname, city, email, course1) VALUES (:username, :password, :lastname, :firstname, :city, :email, :course1)');

    $inserted = 0;
    while (($row = fgetcsv($file)) !== false) {
        if (count($row) < 7) {
            continue;
        }
        $username = trim($row[0]);
        $password = trim($row[1]);
        $lastname = trim($row[2]);
        $firstname = trim($row[3]);
        $city = trim($row[4]);
        $email = trim($row[5]);
        $course1 = trim($row[6]);

        if ($username === '' || $lastname === '') {
            continue;
        }

        if ($stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':lastname' => $lastname,
            ':firstname'=> $firstname,
            ':city'     => $city,
            ':email'    => $email,
            ':course1'  => $course1,
        ])) {
            $inserted++;
        }
    }

    fclose($file);
    $messages[] = 'Đã lưu ' . $inserted . ' dòng sinh viên vào bảng students.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'upload_quiz') {
        handleQuizUpload($pdo);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'upload_students') {
        handleStudentUpload($pdo);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 4 - Upload dữ liệu cho Bài 2 và 3</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: #fff;
            padding: 25px 30px;
        }
        header h1 { font-size: 1.8rem; margin-bottom: 5px; }
        header p { opacity: 0.9; }
        .content { padding: 25px 30px 30px; }
        .upload-card {
            border: 1px solid #e1e5ee;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f8f9fa;
        }
        .upload-card h2 { font-size: 1.1rem; margin-bottom: 5px; }
        .upload-card p { font-size: 0.9rem; margin-bottom: 15px; color: #555; }
        .form-row { margin-bottom: 10px; }
        .form-row label { display: block; margin-bottom: 5px; font-weight: 500; }
        input[type="file"] {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ddd;
            width: 100%;
            background: #fff;
        }
        .checkbox-row { margin: 10px 0; font-size: 0.9rem; }
        button {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            background: #3498db;
            color: #fff;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        button:hover { background: #2980b9; transform: translateY(-1px); }
        .messages { margin-bottom: 20px; }
        .message {
            padding: 8px 12px;
            margin-bottom: 5px;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        .message.error { background: #fdecea; color: #b71c1c; }
        .message.success { background: #e8f5e9; color: #1b5e20; }
        .db-error { background: #fff3cd; color: #856404; padding: 10px 12px; border-radius: 6px; margin-bottom: 15px; }
        .layout { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Bài 4: Lưu trữ dữ liệu động vào CSDL</h1>
        <p>Upload file mẫu của Bài 2 (Quiz.txt) và Bài 3 (CSV điểm danh) rồi lưu vào MySQL.</p>
    </header>
    <div class="content">
        <?php if (isset($dbError)): ?>
            <div class="db-error"><?php echo htmlspecialchars($dbError); ?></div>
        <?php endif; ?>

        <?php if (!empty($messages)): ?>
            <div class="messages">
                <?php foreach ($messages as $m): ?>
                    <div class="message <?php echo (strpos($m, 'Lỗi') === 0 || strpos($m, 'Không') === 0) ? 'error' : 'success'; ?>">
                        <?php echo htmlspecialchars($m); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="layout">
            <div class="upload-card">
                <h2>Bài 2 - Upload file Quiz.txt</h2>
                <p>File TXT với cấu trúc giống Bài 2 (câu hỏi, A/B/C/D, dòng "ANSWER:").</p>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_quiz">
                    <div class="form-row">
                        <label for="quiz_file">Chọn file TXT:</label>
                        <input type="file" name="quiz_file" id="quiz_file" accept=".txt" required>
                    </div>
                    <div class="checkbox-row">
                        <label>
                            <input type="checkbox" name="clear_quiz" value="1"> Xóa toàn bộ dữ liệu cũ trong bảng quiz_questions trước khi lưu
                        </label>
                    </div>
                    <button type="submit">Upload và lưu quiz vào CSDL</button>
                </form>
            </div>

            <div class="upload-card">
                <h2>Bài 3 - Upload file CSV điểm danh</h2>
                <p>File CSV danh sách sinh viên giống Bài 3 (username,password,lastname,...).</p>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_students">
                    <div class="form-row">
                        <label for="csv_file">Chọn file CSV:</label>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                    </div>
                    <div class="checkbox-row">
                        <label>
                            <input type="checkbox" name="clear_students" value="1"> Xóa toàn bộ dữ liệu cũ trong bảng students trước khi lưu
                        </label>
                    </div>
                    <button type="submit">Upload và lưu danh sách vào CSDL</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>