<?php 
require __DIR__ . '/../layouts/header.php';
$webRoot = dirname(dirname($_SERVER['PHP_SELF']));
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><?= htmlspecialchars($lesson['title']) ?></h4>
                    <small class="text-muted">Khóa học: <?= htmlspecialchars($course['title']) ?></small>
                    <div class="mt-2">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: <?= $enrollment['progress'] ?? 0 ?>%"
                                 aria-valuenow="<?= $enrollment['progress'] ?? 0 ?>" 
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">Tiến độ khóa học: <?= number_format($enrollment['progress'] ?? 0, 1) ?>%</small>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Video if available -->
                    <?php if (!empty($lesson['video_url'])): ?>
                        <div class="ratio ratio-16x9 mb-4">
                            <?php
                            $videoUrl = $lesson['video_url'];
                            // Handle different video types
                            if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
                                // YouTube video
                                if (strpos($videoUrl, 'youtu.be') !== false) {
                                    $videoId = explode('youtu.be/', $videoUrl)[1];
                                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                } else {
                                    preg_match('/v=([^&]+)/', $videoUrl, $matches);
                                    $videoId = $matches[1] ?? '';
                                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                }
                            } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
                                // Vimeo video
                                $videoId = explode('vimeo.com/', $videoUrl)[1];
                                $embedUrl = 'https://player.vimeo.com/video/' . $videoId;
                            } elseif (strpos($videoUrl, '.mp4') !== false || strpos($videoUrl, '.webm') !== false || strpos($videoUrl, '.avi') !== false) {
                                // Direct video file
                                $embedUrl = $videoUrl;
                            } else {
                                // Try to embed directly
                                $embedUrl = $videoUrl;
                            }
                            ?>
                            
                            <?php if (strpos($embedUrl, 'youtube') !== false || strpos($embedUrl, 'vimeo') !== false): ?>
                                <iframe src="<?= htmlspecialchars($embedUrl) ?>" 
                                        allowfullscreen 
                                        class="rounded"
                                        title="Video bài học: <?= htmlspecialchars($lesson['title']) ?>">
                                </iframe>
                            <?php else: ?>
                                <video controls class="rounded w-100" style="max-height: 450px;">
                                    <source src="<?= htmlspecialchars($embedUrl) ?>" type="video/mp4">
                                    <source src="<?= htmlspecialchars($embedUrl) ?>" type="video/webm">
                                    Trình duyệt của bạn không hỗ trợ video.
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Lesson content -->
                    <div class="lesson-content mb-4">
                        <?= nl2br(htmlspecialchars($lesson['content'] ?? 'Nội dung đang được cập nhật')) ?>
                    </div>

                    <!-- Materials if available -->
                    <?php if (!empty($materials)): ?>
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Tài liệu học</h6>
                            </div>
                            <div class="card-body">
                                <?php foreach ($materials as $material): ?>
                                    <div class="material-item d-flex align-items-center mb-3 p-3 border rounded">
                                        <div class="me-3">
                                            <?php
                                            $fileType = strtolower($material['file_type'] ?? '');
                                            $icon = 'fa-file';
                                            if (strpos($fileType, 'pdf') !== false) {
                                                $icon = 'fa-file-pdf text-danger';
                                            } elseif (strpos($fileType, 'video') !== false) {
                                                $icon = 'fa-video text-danger';
                                            } elseif (strpos($fileType, 'word') !== false || strpos($fileType, 'document') !== false) {
                                                $icon = 'fa-file-word text-primary';
                                            } elseif (strpos($fileType, 'excel') !== false || strpos($fileType, 'spreadsheet') !== false) {
                                                $icon = 'fa-file-excel text-success';
                                            } elseif (strpos($fileType, 'image') !== false) {
                                                $icon = 'fa-file-image text-info';
                                            } elseif (strpos($fileType, 'powerpoint') !== false) {
                                                $icon = 'fa-file-powerpoint text-warning';
                                            }
                                            ?>
                                            <i class="fas <?= $icon ?> fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?= htmlspecialchars($material['filename']) ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars($material['file_type']) ?></small>
                                        </div>
                                        <div>
                                            <?php if (strpos($fileType, 'video') !== false): ?>
                                                <button class="btn btn-primary btn-sm" onclick="watchVideo(<?= $material['id'] ?>)">
                                                    <i class="fas fa-play"></i> Xem video
                                                </button>
                                            <?php else: ?>
                                                <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                   target="_blank" 
                                                   class="btn btn-outline-primary btn-sm"
                                                   onclick="markMaterialAccessed(<?= $material['id'] ?>)">
                                                    <i class="fas fa-eye"></i> Xem tài liệu
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Complete lesson button -->
                    <?php if (!$isCompleted): ?>
                        <div class="d-flex gap-2 mb-3">
                            <form action="index.php?controller=Student&action=markLessonComplete" method="POST" class="flex-grow-1">
                                <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                <input type="hidden" name="redirect" value="index.php?controller=Student&action=viewLesson&lesson_id=<?= $lesson['id'] ?>">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check-circle"></i> Đánh dấu hoàn thành
                                </button>
                            </form>
                            <?php 
                            $currentIndex = array_search($lesson['id'], array_column($allLessons ?? [], 'id'));
                            $nextLesson = ($allLessons && $currentIndex !== false && $currentIndex < count($allLessons) - 1) ? $allLessons[$currentIndex + 1] : null;
                            ?>
                            <?php if ($nextLesson): ?>
                                <form action="index.php?controller=Student&action=markLessonComplete" method="POST">
                                    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                    <input type="hidden" name="redirect" value="index.php?controller=Student&action=viewLesson&lesson_id=<?= $nextLesson['id'] ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> Hoàn thành & Tiếp theo
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Bạn đã hoàn thành bài học này!
                        </div>
                        <div class="d-flex gap-2">
                            <form action="index.php?controller=Student&action=resetLesson" method="POST" class="flex-grow-1">
                                <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                                <button type="submit" class="btn btn-outline-warning w-100" 
                                        onclick="return confirm('Bạn có chắc muốn làm lại bài học này? Tiến độ sẽ được đặt lại.')">
                                    <i class="fas fa-redo"></i> Làm lại bài học
                                </button>
                            </form>
                            <a href="index.php?controller=Student&action=courseProgress&course_id=<?= $lesson['course_id'] ?>" 
                               class="btn btn-info">
                                <i class="fas fa-chart-line"></i> Xem tiến độ
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-between">
                        <?php 
                        $currentIndex = array_search($lesson['id'], array_column($allLessons, 'id'));
                        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
                        $nextLesson = $currentIndex < count($allLessons) - 1 ? $allLessons[$currentIndex + 1] : null;
                        ?>
                        
                        <?php if ($prevLesson): ?>
                            <a href="index.php?controller=Student&action=viewLesson&lesson_id=<?= $prevLesson['id'] ?>" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Bài trước
                            </a>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>
                        
                        <?php if ($nextLesson): ?>
                            <a href="index.php?controller=Student&action=viewLesson&lesson_id=<?= $nextLesson['id'] ?>" 
                               class="btn btn-primary">
                                Bài tiếp theo <i class="fas fa-arrow-right"></i>
                            </a>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Track material access and auto-complete lesson
let materialsViewed = new Set();
const totalMaterials = <?= count($materials ?? []) ?>;

function markMaterialAccessed(materialId) {
    materialsViewed.add(materialId);
    checkAutoComplete();
}

function watchVideo(materialId) {
    materialsViewed.add(materialId);
    
    // Find the material and get its video URL
    const materials = <?= json_encode($materials ?? []) ?>;
    const material = materials.find(m => m.id == materialId);
    
    if (material && material.file_path) {
        const videoUrl = material.file_path;
        
        // Create modal for video
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${material.filename}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="ratio ratio-16x9">
                            ${getVideoEmbed(videoUrl)}
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        // Remove modal when hidden
        modal.addEventListener('hidden.bs.modal', () => {
            document.body.removeChild(modal);
        });
    }
    
    checkAutoComplete();
}

function getVideoEmbed(videoUrl) {
    if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
        let videoId = '';
        if (videoUrl.includes('youtu.be')) {
            videoId = videoUrl.split('youtu.be/')[1];
        } else {
            const matches = videoUrl.match(/v=([^&]+)/);
            videoId = matches ? matches[1] : '';
        }
        return `<iframe src="https://www.youtube.com/embed/${videoId}" allowfullscreen></iframe>`;
    } else if (videoUrl.includes('vimeo.com')) {
        const videoId = videoUrl.split('vimeo.com/')[1];
        return `<iframe src="https://player.vimeo.com/video/${videoId}" allowfullscreen></iframe>`;
    } else {
        return `<video controls class="w-100">
            <source src="${videoUrl}" type="video/mp4">
            <source src="${videoUrl}" type="video/webm">
            Trình duyệt không hỗ trợ video.
        </video>`;
    }
}

function checkAutoComplete() {
    // Auto-complete lesson when all materials are viewed
    if (materialsViewed.size >= totalMaterials && totalMaterials > 0) {
        setTimeout(() => {
            if (confirm('Bạn đã xem hết tài liệu. Đánh dấu hoàn thành bài học?')) {
                autoCompleteLesson();
            }
        }, 1000);
    }
}

function autoCompleteLesson() {
    fetch('index.php?controller=Student&action=markLessonComplete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `lesson_id=<?= $lesson['id'] ?>&redirect=index.php?controller=Student&action=viewLesson&lesson_id=<?= $lesson['id'] ?>`
    })
    .then(response => response.text())
    .then(() => {
        // Redirect to next lesson
        <?php 
        $currentIndex = array_search($lesson['id'], array_column($allLessons ?? [], 'id'));
        $nextLesson = ($allLessons && $currentIndex !== false && $currentIndex < count($allLessons) - 1) ? $allLessons[$currentIndex + 1] : null;
        ?>
        <?php if ($nextLesson): ?>
            window.location.href = 'index.php?controller=Student&action=viewLesson&lesson_id=<?= $nextLesson['id'] ?>';
        <?php else: ?>
            location.reload();
        <?php endif; ?>
    })
    .catch(error => console.error('Error:', error));
}

// Track time spent on lesson (optional auto-complete after time)
let timeSpent = 0;
const timeThreshold = 300; // 5 minutes in seconds

setInterval(() => {
    timeSpent++;
    if (timeSpent >= timeThreshold && materialsViewed.size > 0) {
        if (confirm('Bạn đã học bài này đủ lâu. Đánh dấu hoàn thành?')) {
            autoCompleteLesson();
        }
    }
}, 1000);
</script>

<style>
.lesson-content {
    line-height: 1.6;
    font-size: 1.1rem;
    white-space: pre-wrap;
}

.ratio-16x9 {
    max-width: 100%;
}

.card {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
}

.material-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.material-item:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.material-item i {
    transition: transform 0.3s ease;
}

.material-item:hover i {
    transform: scale(1.1);
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
