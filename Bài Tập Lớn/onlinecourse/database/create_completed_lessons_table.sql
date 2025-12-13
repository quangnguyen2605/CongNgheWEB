-- Tạo bảng completed_lessons để theo dõi bài học đã hoàn thành
CREATE TABLE IF NOT EXISTS completed_lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    lesson_id INT NOT NULL,
    course_id INT NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_student_lesson (student_id, lesson_id),
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Thêm index để tối ưu performance
CREATE INDEX idx_student_course ON completed_lessons(student_id, course_id);
CREATE INDEX idx_completed_at ON completed_lessons(completed_at);
