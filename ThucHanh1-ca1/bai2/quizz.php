<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài thi trắc nghiệm Android</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        header h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .quiz-info {
            background: #f8f9fa;
            padding: 15px 30px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }

        .quiz-content {
            padding: 30px;
        }

        .question {
            background: #f8f9fa;
            border-left: 5px solid #3498db;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }

        .question:hover {
            transform: translateX(5px);
        }

        .question-number {
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.1em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .question-number::before {
            content: "●";
            color: #3498db;
            margin-right: 10px;
            font-size: 1.2em;
        }

        .question-text {
            font-size: 1.1em;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .options {
            margin-left: 20px;
        }

        .option {
            margin: 10px 0;
            padding: 12px 15px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .option:hover {
            border-color: #3498db;
            background: #f1f8ff;
            transform: translateY(-2px);
        }

        .option.selected {
            border-color: #27ae60;
            background: #d5f4e6;
        }

        .multiple-answers {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 0.9em;
            color: #856404;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #submitBtn {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
        }

        #submitBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
        }

        #resetBtn {
            background: #95a5a6;
            color: white;
        }

        #resetBtn:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .result {
            display: none;
            padding: 30px;
            text-align: center;
            background: #f8f9fa;
        }

        .score {
            font-size: 3em;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
        }

        .correct {
            color: #27ae60;
        }

        .incorrect {
            color: #e74c3c;
        }

        .question-result {
            margin: 15px 0;
            padding: 15px;
            border-radius: 8px;
            text-align: left;
        }

        .correct-answer {
            background: #d5f4e6;
            border-left: 5px solid #27ae60;
        }

        .wrong-answer {
            background: #fde8e8;
            border-left: 5px solid #e74c3c;
        }

        .answer-info {
            margin-top: 10px;
            font-size: 0.9em;
            color: #666;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                border-radius: 10px;
            }
            
            header h1 {
                font-size: 1.8em;
            }
            
            .quiz-content {
                padding: 20px;
            }
            
            .controls {
                flex-direction: column;
                gap: 10px;
            }
            
            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📱 Bài Thi Trắc Nghiệm Android</h1>
            <p>Kiểm tra kiến thức lập trình Android của bạn</p>
        </header>

        <div class="quiz-info">
            <span id="questionCount">Tổng số câu: 0</span>
            <span id="timer">⏱️ Thời gian: 00:00</span>
        </div>

        <div class="quiz-content" id="quizContent">
            <!-- Questions will be loaded here by JavaScript -->
        </div>

        <div class="controls">
            <button id="resetBtn" onclick="resetQuiz()">🔄 Làm Lại</button>
            <button id="submitBtn" onclick="submitQuiz()">📤 Nộp Bài</button>
        </div>

        <div class="result" id="resultSection">
            <!-- Results will be shown here -->
        </div>
    </div>

    <script>
        let questions = [];
        let userAnswers = {};
        let startTime;
        let timerInterval;

        // Load questions from PHP
        async function loadQuestions() {
            try {
                const response = await fetch('load_questions.php');
                questions = await response.json();
                displayQuestions();
                startTimer();
            } catch (error) {
                console.error('Error loading questions:', error);
                document.getElementById('quizContent').innerHTML = 
                    '<div style="text-align: center; padding: 40px; color: #e74c3c;">' +
                    '❌ Lỗi khi tải câu hỏi. Vui lòng thử lại sau.</div>';
            }
        }

        function displayQuestions() {
            const quizContent = document.getElementById('quizContent');
            const questionCount = document.getElementById('questionCount');
            
            questionCount.textContent = `Tổng số câu: ${questions.length}`;
            
            quizContent.innerHTML = questions.map((question, index) => {
                const isMultiple = question.correctAnswers.length > 1;
                const optionsHtml = question.options.map((option, optIndex) => {
                    const letter = String.fromCharCode(65 + optIndex);
                    return `
                        <div class="option" onclick="selectOption(${index}, ${optIndex})" 
                             id="option-${index}-${optIndex}">
                            <strong>${letter}.</strong> ${option}
                        </div>
                    `;
                }).join('');

                return `
                    <div class="question" id="question-${index}">
                        <div class="question-number">
                            Câu ${index + 1}
                        </div>
                        <div class="question-text">
                            ${question.text}
                        </div>
                        ${isMultiple ? '<div class="multiple-answers">📝 Chọn nhiều đáp án</div>' : ''}
                        <div class="options">
                            ${optionsHtml}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function selectOption(questionIndex, optionIndex) {
            const question = questions[questionIndex];
            const optionElement = document.getElementById(`option-${questionIndex}-${optionIndex}`);
            
            if (question.correctAnswers.length > 1) {
                // Multiple selection
                if (!userAnswers[questionIndex]) {
                    userAnswers[questionIndex] = [];
                }
                
                const answerIndex = userAnswers[questionIndex].indexOf(optionIndex);
                if (answerIndex === -1) {
                    userAnswers[questionIndex].push(optionIndex);
                    optionElement.classList.add('selected');
                } else {
                    userAnswers[questionIndex].splice(answerIndex, 1);
                    optionElement.classList.remove('selected');
                }
            } else {
                // Single selection
                // Remove selection from other options
                question.options.forEach((_, optIndex) => {
                    const optElement = document.getElementById(`option-${questionIndex}-${optIndex}`);
                    optElement.classList.remove('selected');
                });
                
                userAnswers[questionIndex] = [optionIndex];
                optionElement.classList.add('selected');
            }
        }

        function startTimer() {
            startTime = new Date();
            timerInterval = setInterval(updateTimer, 1000);
        }

        function updateTimer() {
            const now = new Date();
            const diff = Math.floor((now - startTime) / 1000);
            const minutes = Math.floor(diff / 60).toString().padStart(2, '0');
            const seconds = (diff % 60).toString().padStart(2, '0');
            document.getElementById('timer').textContent = `⏱️ Thời gian: ${minutes}:${seconds}`;
        }

        function submitQuiz() {
            clearInterval(timerInterval);
            
            let score = 0;
            const results = [];

            questions.forEach((question, index) => {
                const userAnswer = userAnswers[index] || [];
                const correctAnswers = question.correctAnswers;
                
                // Check if answers are correct (order doesn't matter)
                const isCorrect = userAnswer.length === correctAnswers.length && 
                                userAnswer.every(answer => correctAnswers.includes(answer));
                
                if (isCorrect) {
                    score++;
                }

                results.push({
                    question: question.text,
                    userAnswer: userAnswer.map(opt => String.fromCharCode(65 + opt)).join(', '),
                    correctAnswer: correctAnswers.map(opt => String.fromCharCode(65 + opt)).join(', '),
                    isCorrect: isCorrect,
                    options: question.options
                });
            });

            displayResults(score, results);
        }

        function displayResults(score, results) {
            const percentage = Math.round((score / questions.length) * 100);
            
            document.getElementById('quizContent').style.display = 'none';
            document.getElementById('submitBtn').style.display = 'none';
            document.getElementById('resetBtn').style.display = 'none';
            
            const resultSection = document.getElementById('resultSection');
            resultSection.style.display = 'block';
            
            resultSection.innerHTML = `
                <h2>🎯 Kết Quả Bài Thi</h2>
                <div class="score ${percentage >= 80 ? 'correct' : percentage >= 50 ? '' : 'incorrect'}">
                    ${score}/${questions.length} (${percentage}%)
                </div>
                <div style="margin-bottom: 20px;">
                    ${getResultMessage(percentage)}
                </div>
                <h3>📊 Chi tiết bài làm:</h3>
                ${results.map((result, index) => `
                    <div class="question-result ${result.isCorrect ? 'correct-answer' : 'wrong-answer'}">
                        <strong>Câu ${index + 1}:</strong> ${result.question}<br>
                        <strong>Đáp án của bạn:</strong> ${result.userAnswer || 'Chưa trả lời'}<br>
                        <strong>Đáp án đúng:</strong> ${result.correctAnswer}<br>
                        ${!result.isCorrect ? `<div class="answer-info">${getAnswerExplanation(result.options, result.correctAnswer)}</div>` : ''}
                    </div>
                `).join('')}
                <button onclick="resetQuiz()" style="margin-top: 20px; background: #3498db; color: white;">
                    🔄 Làm Lại Bài Thi
                </button>
            `;
        }

        function getResultMessage(percentage) {
            if (percentage >= 90) return '🎉 Xuất sắc! Kiến thức Android của bạn rất vững chắc!';
            if (percentage >= 80) return '👍 Rất tốt! Bạn có hiểu biết tốt về Android development.';
            if (percentage >= 70) return '💪 Khá tốt! Tiếp tục ôn luyện thêm nhé.';
            if (percentage >= 50) return '📚 Cần cố gắng hơn! Hãy ôn tập lại các kiến thức cơ bản.';
            return '📖 Cần học tập nhiều hơn! Đừng nản chí, hãy tiếp tục cố gắng!';
        }

        function getAnswerExplanation(options, correctAnswer) {
            const correctLetters = correctAnswer.split(', ');
            let explanation = 'Giải thích: ';
            correctLetters.forEach(letter => {
                const index = letter.charCodeAt(0) - 65;
                explanation += `<br>• ${letter}: ${options[index]}`;
            });
            return explanation;
        }

        function resetQuiz() {
            userAnswers = {};
            document.getElementById('quizContent').style.display = 'block';
            document.getElementById('resultSection').style.display = 'none';
            document.getElementById('submitBtn').style.display = 'block';
            document.getElementById('resetBtn').style.display = 'block';
            displayQuestions();
            clearInterval(timerInterval);
            startTimer();
        }

        // Initialize quiz when page loads
        document.addEventListener('DOMContentLoaded', loadQuestions);
    </script>
</body>
</html>