<?php
header('Content-Type: application/json; charset=utf-8');

function parseQuizFile($filename) {
    $questions = [];
    $currentQuestion = null;
    
    $content = file_get_contents($filename);
    $lines = explode("\n", $content);
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        if (empty($line)) {
            continue;
        }
        
        // Check if line is a question
        if (preg_match('/^(.+)\?$/', $line, $matches)) {
            if ($currentQuestion) {
                $questions[] = $currentQuestion;
            }
            $currentQuestion = [
                'text' => $matches[1],
                'options' => [],
                'correctAnswers' => []
            ];
        }
        // Check if line is an option (A., B., C., D.)
        elseif (preg_match('/^([A-D])\.\s*(.+)$/', $line, $matches)) {
            if ($currentQuestion) {
                $currentQuestion['options'][] = $matches[2];
            }
        }
        // Check if line is an answer
        elseif (preg_match('/^ANSWER:\s*([A-D, ]+)$/', $line, $matches)) {
            if ($currentQuestion) {
                $answers = preg_split('/\s*,\s*/', $matches[1]);
                foreach ($answers as $answer) {
                    $currentQuestion['correctAnswers'][] = ord(trim($answer)) - 65; // Convert A->0, B->1, etc.
                }
                // Add the completed question
                $questions[] = $currentQuestion;
                $currentQuestion = null;
            }
        }
        // Handle multiple choice indicator
        elseif (preg_match('/^\(Chọn (\d+) đáp án\)$/', $line)) {
            // This line indicates multiple answers, but we'll handle it via ANSWER line
            continue;
        }
        // Handle phát biểu nào type questions
        elseif (strpos($line, 'phát biểu nào') !== false || strpos($line, 'thành phần nào') !== false) {
            if ($currentQuestion) {
                $questions[] = $currentQuestion;
            }
            $currentQuestion = [
                'text' => $line,
                'options' => [],
                'correctAnswers' => []
            ];
        }
    }
    
    // Add the last question if exists
    if ($currentQuestion) {
        $questions[] = $currentQuestion;
    }
    
    return $questions;
}

try {
    $questions = parseQuizFile('Quiz.txt');
    
    // Validate that all questions have options and answers
    $validQuestions = [];
    foreach ($questions as $question) {
        if (!empty($question['options']) && !empty($question['correctAnswers'])) {
            $validQuestions[] = $question;
        }
    }
    
    echo json_encode($validQuestions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Không thể đọc file câu hỏi: ' . $e->getMessage()]);
}
?>