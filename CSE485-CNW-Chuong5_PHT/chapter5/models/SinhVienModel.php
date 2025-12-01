<?php
// models/SinhVienModel.php

// Hàm lấy toàn bộ sinh viên
function getAllSinhVien(PDO $pdo)
{
    $sql = "SELECT * FROM sinhvien ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// TODO 2: Viết 1 hàm tên là addSinhVien()
// Hàm này nhận 3 tham số: $pdo, $ten, $email
// Bên trong hàm, thực thi câu lệnh INSERT (dùng Prepared Statement)
function addSinhVien(PDO $pdo, $ten, $email)
{
    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ten, $email]);
}
