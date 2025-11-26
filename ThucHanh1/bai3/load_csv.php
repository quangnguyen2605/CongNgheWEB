<?php
header('Content-Type: application/json; charset=utf-8');

function readCSVFile($filename) {
    $students = [];
    
    // Kiểm tra file tồn tại
    if (!file_exists($filename)) {
        return ['success' => false, 'error' => 'File không tồn tại'];
    }
    
    // Mở file
    $file = fopen($filename, 'r');
    if (!$file) {
        return ['success' => false, 'error' => 'Không thể mở file'];
    }
    
    // Đọc header
    $header = fgetcsv($file);
    
    // Kiểm tra encoding và chuyển đổi nếu cần
    if (isset($header[0]) && strpos($header[0], '﻿') === 0) {
        $header[0] = substr($header[0], 3); // Remove BOM
    }
    
    // Đọc dữ liệu
    $rowCount = 0;
    while (($row = fgetcsv($file)) !== FALSE) {
        $rowCount++;
        
        // Kiểm tra số lượng cột
        if (count($row) >= 7) {
            $student = [
                'username' => trim($row[0]),
                'password' => trim($row[1]),
                'lastname' => trim($row[2]),
                'firstname' => trim($row[3]),
                'city' => trim($row[4]),
                'email' => trim($row[5]),
                'course1' => trim($row[6])
            ];
            
            // Chỉ thêm những dòng có đủ thông tin cơ bản
            if (!empty($student['username']) && !empty($student['lastname'])) {
                $students[] = $student;
            }
        }
    }
    
    fclose($file);
    
    return [
        'success' => true,
        'students' => $students,
        'total_rows' => $rowCount,
        'loaded_rows' => count($students)
    ];
}

try {
    $result = readCSVFile('65HTTT_Danh_sach_diem_danh.csv');
    
    // Log kết quả (có thể bỏ trong production)
    error_log("CSV Load Result: " . json_encode($result));
    
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Lỗi hệ thống: ' . $e->getMessage()
    ]);
}
?>