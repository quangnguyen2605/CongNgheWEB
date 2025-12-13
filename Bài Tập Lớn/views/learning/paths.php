<?php
$pageTitle = 'Lộ trình học tập';
require __DIR__ . '/../layouts/header.php';
?>

<style>
/* Simple text color fixes */
.paths-section * { color: #2d3748 !important; }
.paths-section .path-header * { color: white !important; }
.paths-section .btn-start-path { color: white !important; }
.paths-section .skill-tag { color: #667eea !important; }
.paths-section .course-number { color: white !important; }
.paths-section .path-content * { color: #000000 !important; background: #ffffff !important; }

/* Header text fixes */
.page-title { color: #000000 !important; text-shadow: 0 1px 2px rgba(255,255,255,0.8) !important; }
.page-subtitle { color: #000000 !important; text-shadow: 0 1px 2px rgba(255,255,255,0.8) !important; }
.page-header * { color: #000000 !important; text-shadow: 0 1px 2px rgba(255,255,255,0.8) !important; }

/* Footer fixes */
footer * { color: #ffffff !important; }
footer .container { background: #2d3748 !important; }
footer a { color: #667eea !important; }
footer a:hover { color: #4299e1 !important; }

.paths-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.page-header {
    text-align: center;
    margin-bottom: 60px;
}

.page-title {
    font-size: 3rem;
    font-weight: 700;
    color: #1a202c !important;
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-subtitle {
    font-size: 1.2rem;
    color: #2d3748 !important;
    max-width: 600px;
    margin: 0 auto;
    font-weight: 500;
}

.paths-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    margin-top: 50px;
}

.path-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.path-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.path-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

.path-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.path-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.path-level {
    font-size: 1rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.path-content {
    padding: 30px;
    color: #2d3748 !important;
}

.path-content *,
.path-content p,
.path-content h3,
.path-content span,
.path-content li {
    color: #2d3748 !important;
}

.path-content .skills-title,
.path-content .courses-title {
    color: #1a202c !important;
}

.path-content .course-name {
    color: #2d3748 !important;
}

.path-content .course-duration {
    color: #4a5568 !important;
}

.path-content .path-duration {
    color: #4a5568 !important;
}

.path-description {
    color: #4a5568 !important;
    line-height: 1.6;
    margin-bottom: 25px;
    font-weight: 500;
}

.path-skills {
    margin-bottom: 25px;
}

.skills-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a202c !important;
    margin-bottom: 15px;
}

.skill-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.skill-tag {
    background: #e8f0fe;
    color: #667eea;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.path-courses {
    margin-bottom: 25px;
}

.courses-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a202c !important;
    margin-bottom: 15px;
}

.course-list {
    list-style: none;
    padding: 0;
}

.course-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.course-item:last-child {
    border-bottom: none;
}

.course-number {
    width: 30px;
    height: 30px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 15px;
    font-size: 0.9rem;
}

.course-name {
    flex: 1;
    color: #2d3748 !important;
    font-weight: 600;
}

.course-duration {
    color: #4a5568 !important;
    font-size: 0.9rem;
    font-weight: 500;
}

.path-duration {
    display: flex;
    align-items: center;
    color: #4a5568 !important;
    margin-bottom: 20px;
    font-weight: 500;
}

.path-duration i {
    margin-right: 8px;
    color: #667eea;
}

.path-action {
    text-align: center;
}

.btn-start-path {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-start-path:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    color: white;
}

.filter-section {
    text-align: center;
    margin-bottom: 50px;
}

.filter-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-btn {
    background: white;
    color: #2d3748;
    border: 2px solid #e2e8f0;
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-btn.active,
.filter-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .paths-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .path-header {
        padding: 20px;
    }
    
    .path-content {
        padding: 20px;
    }
}
</style>

<div class="paths-section">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Lộ trình học tập</h1>
            <p class="page-subtitle">
                Khám phá các lộ trình học tập được thiết kế bài bản, giúp bạn đi từ cơ bản đến nâng cao
            </p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterPaths('all')">Tất cả</button>
                <button class="filter-btn" onclick="filterPaths('beginner')">Cơ bản</button>
                <button class="filter-btn" onclick="filterPaths('intermediate')">Trung cấp</button>
                <button class="filter-btn" onclick="filterPaths('advanced')">Nâng cao</button>
            </div>
        </div>

        <!-- Paths Grid -->
        <div class="paths-grid">
            <!-- Frontend Developer Path -->
            <div class="path-card" data-level="beginner">
                <div class="path-header">
                    <div class="path-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h2 class="path-title">Frontend Developer</h2>
                    <div class="path-level">Cơ bản</div>
                </div>
                <div class="path-content">
                    <p class="path-description" style="color: #4a5568 !important; font-weight: 500 !important;">
                        Học cách xây dựng giao diện người dùng đẹp mắt và tương tác với các công nghệ web hiện đại.
                    </p>
                    
                    <div class="path-skills">
                        <h3 class="skills-title" style="color: #1a202c !important; font-weight: 600 !important;">Kỹ năng sẽ học:</h3>
                        <div class="skill-tags">
                            <span class="skill-tag">HTML</span>
                            <span class="skill-tag">CSS</span>
                            <span class="skill-tag">JavaScript</span>
                            <span class="skill-tag">React</span>
                            <span class="skill-tag">Responsive Design</span>
                        </div>
                    </div>

                    <div class="path-courses">
                        <h3 class="courses-title" style="color: #1a202c !important; font-weight: 600 !important;">Khóa học (4 khóa):</h3>
                        <ul class="course-list">
                            <li class="course-item">
                                <span class="course-number">1</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">HTML & CSS cơ bản</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">4 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">2</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">JavaScript fundamentals</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">3</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">React.js từ A-Z</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">8 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">4</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Dự án thực tế</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                        </ul>
                    </div>

                    <div class="path-duration">
                        <i class="fas fa-clock"></i>
                        <span style="color: #4a5568 !important; font-weight: 500 !important;">Tổng thời gian: 24 tuần (6 tháng)</span>
                    </div>

                    <div class="path-action">
                        <a href="#" class="btn-start-path">Bắt đầu học</a>
                    </div>
                </div>
            </div>

            <!-- Backend Developer Path -->
            <div class="path-card" data-level="intermediate">
                <div class="path-header">
                    <div class="path-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h2 class="path-title">Backend Developer</h2>
                    <div class="path-level">Trung cấp</div>
                </div>
                <div class="path-content">
                    <p class="path-description">
                        Xây dựng server-side và API mạnh mẽ với các công nghệ lập trình backend phổ biến.
                    </p>
                    
                    <div class="path-skills">
                        <h3 class="skills-title" style="color: #1a202c !important; font-weight: 600 !important;">Kỹ năng sẽ học:</h3>
                        <div class="skill-tags">
                            <span class="skill-tag">Node.js</span>
                            <span class="skill-tag">Express</span>
                            <span class="skill-tag">MongoDB</span>
                            <span class="skill-tag">REST API</span>
                            <span class="skill-tag">Authentication</span>
                        </div>
                    </div>

                    <div class="path-courses">
                        <h3 class="courses-title" style="color: #1a202c !important; font-weight: 600 !important;">Khóa học (4 khóa):</h3>
                        <ul class="course-list">
                            <li class="course-item">
                                <span class="course-number">1</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Node.js fundamentals</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">2</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Express.js & REST API</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">3</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Database với MongoDB</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">4 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">4</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Authentication & Security</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">4 tuần</span>
                            </li>
                        </ul>
                    </div>

                    <div class="path-duration">
                        <i class="fas fa-clock"></i>
                        <span style="color: #4a5568 !important; font-weight: 500 !important;">Tổng thời gian: 20 tuần (5 tháng)</span>
                    </div>

                    <div class="path-action">
                        <a href="#" class="btn-start-path">Bắt đầu học</a>
                    </div>
                </div>
            </div>

            <!-- Full Stack Developer Path -->
            <div class="path-card" data-level="advanced">
                <div class="path-header">
                    <div class="path-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h2 class="path-title">Full Stack Developer</h2>
                    <div class="path-level">Nâng cao</div>
                </div>
                <div class="path-content">
                    <p class="path-description">
                        Trở thành lập trình viên full-stack với khả năng phát triển cả frontend và backend.
                    </p>
                    
                    <div class="path-skills">
                        <h3 class="skills-title" style="color: #1a202c !important; font-weight: 600 !important;">Kỹ năng sẽ học:</h3>
                        <div class="skill-tags">
                            <span class="skill-tag">React</span>
                            <span class="skill-tag">Node.js</span>
                            <span class="skill-tag">MongoDB</span>
                            <span class="skill-tag">DevOps</span>
                            <span class="skill-tag">Cloud Deployment</span>
                        </div>
                    </div>

                    <div class="path-courses">
                        <h3 class="courses-title" style="color: #1a202c !important; font-weight: 600 !important;">Khóa học (6 khóa):</h3>
                        <ul class="course-list">
                            <li class="course-item">
                                <span class="course-number">1</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Frontend Advanced</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">8 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">2</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Backend Advanced</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">8 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">3</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Database Design</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">4 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">4</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">DevOps & Deployment</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">5</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Testing & QA</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">4 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">6</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Dự án Capstone</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">8 tuần</span>
                            </li>
                        </ul>
                    </div>

                    <div class="path-duration">
                        <i class="fas fa-clock"></i>
                        <span style="color: #4a5568 !important; font-weight: 500 !important;">Tổng thời gian: 38 tuần (9.5 tháng)</span>
                    </div>

                    <div class="path-action">
                        <a href="#" class="btn-start-path">Bắt đầu học</a>
                    </div>
                </div>
            </div>

            <!-- Data Science Path -->
            <div class="path-card" data-level="advanced">
                <div class="path-header">
                    <div class="path-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h2 class="path-title">Data Science</h2>
                    <div class="path-level">Nâng cao</div>
                </div>
                <div class="path-content">
                    <p class="path-description">
                        Phân tích dữ liệu và xây dựng các mô hình machine learning để giải quyết bài toán thực tế.
                    </p>
                    
                    <div class="path-skills">
                        <h3 class="skills-title" style="color: #1a202c !important; font-weight: 600 !important;">Kỹ năng sẽ học:</h3>
                        <div class="skill-tags">
                            <span class="skill-tag">Python</span>
                            <span class="skill-tag">Machine Learning</span>
                            <span class="skill-tag">Data Analysis</span>
                            <span class="skill-tag">Deep Learning</span>
                            <span class="skill-tag">Statistics</span>
                        </div>
                    </div>

                    <div class="path-courses">
                        <h3 class="courses-title" style="color: #1a202c !important; font-weight: 600 !important;">Khóa học (5 khóa):</h3>
                        <ul class="course-list">
                            <li class="course-item">
                                <span class="course-number">1</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Python for Data Science</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">2</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Data Analysis & Visualization</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">3</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Machine Learning</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">8 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">4</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Deep Learning</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">8 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">5</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Dự án thực tế</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                        </ul>
                    </div>

                    <div class="path-duration">
                        <i class="fas fa-clock"></i>
                        <span style="color: #4a5568 !important; font-weight: 500 !important;">Tổng thời gian: 34 tuần (8.5 tháng)</span>
                    </div>

                    <div class="path-action">
                        <a href="#" class="btn-start-path">Bắt đầu học</a>
                    </div>
                </div>
            </div>

            <!-- Mobile Developer Path -->
            <div class="path-card" data-level="intermediate">
                <div class="path-header">
                    <div class="path-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h2 class="path-title">Mobile Developer</h2>
                    <div class="path-level">Trung cấp</div>
                </div>
                <div class="path-content">
                    <p class="path-description">
                        Phát triển ứng dụng di động cho iOS và Android với Flutter và React Native.
                    </p>
                    
                    <div class="path-skills">
                        <h3 class="skills-title" style="color: #1a202c !important; font-weight: 600 !important;">Kỹ năng sẽ học:</h3>
                        <div class="skill-tags">
                            <span class="skill-tag">Flutter</span>
                            <span class="skill-tag">Dart</span>
                            <span class="skill-tag">React Native</span>
                            <span class="skill-tag">Mobile UI/UX</span>
                            <span class="skill-tag">App Deployment</span>
                        </div>
                    </div>

                    <div class="path-courses">
                        <h3 class="courses-title" style="color: #1a202c !important; font-weight: 600 !important;">Khóa học (4 khóa):</h3>
                        <ul class="course-list">
                            <li class="course-item">
                                <span class="course-number">1</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Flutter cơ bản</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">2</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Flutter nâng cao</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">3</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">React Native</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">4</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Dự án ứng dụng</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                        </ul>
                    </div>

                    <div class="path-duration">
                        <i class="fas fa-clock"></i>
                        <span style="color: #4a5568 !important; font-weight: 500 !important;">Tổng thời gian: 24 tuần (6 tháng)</span>
                    </div>

                    <div class="path-action">
                        <a href="#" class="btn-start-path">Bắt đầu học</a>
                    </div>
                </div>
            </div>

            <!-- DevOps Path -->
            <div class="path-card" data-level="advanced">
                <div class="path-header">
                    <div class="path-icon">
                        <i class="fas fa-infinity"></i>
                    </div>
                    <h2 class="path-title">DevOps Engineer</h2>
                    <div class="path-level">Nâng cao</div>
                </div>
                <div class="path-content">
                    <p class="path-description">
                        Tự động hóa quy trình phát triển và triển khai ứng dụng với các công cụ DevOps hiện đại.
                    </p>
                    
                    <div class="path-skills">
                        <h3 class="skills-title" style="color: #1a202c !important; font-weight: 600 !important;">Kỹ năng sẽ học:</h3>
                        <div class="skill-tags">
                            <span class="skill-tag">Docker</span>
                            <span class="skill-tag">Kubernetes</span>
                            <span class="skill-tag">CI/CD</span>
                            <span class="skill-tag">AWS</span>
                            <span class="skill-tag">Monitoring</span>
                        </div>
                    </div>

                    <div class="path-courses">
                        <h3 class="courses-title" style="color: #1a202c !important; font-weight: 600 !important;">Khóa học (4 khóa):</h3>
                        <ul class="course-list">
                            <li class="course-item">
                                <span class="course-number">1</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Linux & Shell Scripting</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">4 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">2</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Docker & Containerization</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">3</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">Kubernetes & Orchestration</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">8 tuần</span>
                            </li>
                            <li class="course-item">
                                <span class="course-number">4</span>
                                <span class="course-name" style="color: #2d3748 !important; font-weight: 600 !important;">CI/CD & Cloud Deployment</span>
                                <span class="course-duration" style="color: #4a5568 !important; font-weight: 500 !important;">6 tuần</span>
                            </li>
                        </ul>
                    </div>

                    <div class="path-duration">
                        <i class="fas fa-clock"></i>
                        <span style="color: #4a5568 !important; font-weight: 500 !important;">Tổng thời gian: 24 tuần (6 tháng)</span>
                    </div>

                    <div class="path-action">
                        <a href="#" class="btn-start-path">Bắt đầu học</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterPaths(level) {
    const paths = document.querySelectorAll('.path-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update active button
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter paths
    paths.forEach(path => {
        if (level === 'all' || path.dataset.level === level) {
            path.style.display = 'block';
            setTimeout(() => {
                path.style.opacity = '1';
                path.style.transform = 'translateY(0)';
            }, 100);
        } else {
            path.style.opacity = '0';
            path.style.transform = 'translateY(20px)';
            setTimeout(() => {
                path.style.display = 'none';
            }, 300);
        }
    });
}

// Force text colors
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.path-content *').forEach(el => {
        el.style.color = '#000000';
        el.style.fontWeight = 'bold';
    });
    
    // Fix header text
    document.querySelectorAll('.page-title, .page-subtitle, .page-header *').forEach(el => {
        el.style.color = '#000000';
        el.style.fontWeight = 'bold';
        el.style.textShadow = '0 1px 2px rgba(255,255,255,0.8)';
    });
});

// Add smooth transitions
document.querySelectorAll('.path-card').forEach(card => {
    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
