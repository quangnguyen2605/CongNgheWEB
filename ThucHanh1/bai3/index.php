<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách điểm danh - 65HTTT</title>
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
            max-width: 1200px;
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

        .header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .controls {
            background: #f8f9fa;
            padding: 20px 30px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-box {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            min-width: 250px;
        }

        .search-box button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .search-box button:hover {
            background: #2980b9;
        }

        .stats {
            display: flex;
            gap: 20px;
            font-weight: bold;
        }

        .stat-item {
            background: white;
            padding: 8px 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        thead {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: background 0.3s ease;
        }

        tbody tr:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        tbody tr:nth-child(even):hover {
            background: #e9ecef;
        }

        td {
            padding: 12px 15px;
            font-size: 14px;
        }

        .student-id {
            font-weight: bold;
            color: #2c3e50;
        }

        .name {
            color: #2c3e50;
            font-weight: 500;
        }

        .class {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .email {
            color: #666;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #27ae60;
            color: white;
        }

        .btn-edit:hover {
            background: #219a52;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            gap: 10px;
        }

        .pagination button {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination button:hover {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        .pagination button.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        .export-btn {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .export-btn:hover {
            background: #219a52;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .container {
                border-radius: 10px;
            }
            
            header h1 {
                font-size: 1.8em;
            }
            
            .header-info {
                flex-direction: column;
                text-align: center;
            }
            
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                width: 100%;
            }
            
            .search-box input {
                min-width: auto;
                flex: 1;
            }
            
            .stats {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            th, td {
                padding: 8px 10px;
                font-size: 12px;
            }
            
            .table-container {
                padding: 10px;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Danh sách điểm danh lớp 65HTTT</h1>
            <div class="header-info">
                <div class="info-card">
                    <strong>Môn học:</strong> CSE485 - Công nghệ Web
                </div>
                <div class="info-card">
                    <strong>Mã lớp:</strong> CSE485.202401
                </div>
                <div class="info-card">
                    <strong>Nguồn dữ liệu:</strong> File CSV
                </div>
            </div>
        </header>

        <div class="controls">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên, mã SV, email...">
                <button onclick="searchStudents()">🔍 Tìm kiếm</button>
                <button onclick="clearSearch()">🔄 Xóa</button>
            </div>
            
            <div class="stats">
                <div class="stat-item" id="totalStudents">Tổng: 0 SV</div>
                <div class="stat-item" id="classInfo">Lớp: 65HTTT</div>
            </div>

            <button class="export-btn" onclick="exportToExcel()">📥 Xuất Excel</button>
        </div>

        <div class="table-container">
            <table id="studentsTable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sinh viên</th>
                        <th>Họ và tên</th>
                        <th>Lớp</th>
                        <th>Email</th>
                        <th>Môn học</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="studentsBody">
                    <!-- Dữ liệu sẽ được tải ở đây -->
                </tbody>
            </table>
            
            <div class="no-data" id="noData" style="display: none;">
                Không có dữ liệu để hiển thị
            </div>
        </div>

        <div class="pagination" id="pagination">
            <!-- Phân trang sẽ được tạo ở đây -->
        </div>
    </div>

    <script>
        let allStudents = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        let filteredStudents = [];

        // Load dữ liệu từ PHP
        async function loadStudents() {
            try {
                const response = await fetch('load_csv.php');
                const data = await response.json();
                
                if (data.success) {
                    allStudents = data.students;
                    filteredStudents = [...allStudents];
                    updateStats();
                    displayStudents();
                } else {
                    showError('Lỗi khi tải dữ liệu: ' + data.error);
                }
            } catch (error) {
                showError('Lỗi kết nối: ' + error.message);
            }
        }

        // Hiển thị danh sách sinh viên
        function displayStudents() {
            const tbody = document.getElementById('studentsBody');
            const noData = document.getElementById('noData');
            
            if (filteredStudents.length === 0) {
                tbody.innerHTML = '';
                noData.style.display = 'block';
                return;
            }
            
            noData.style.display = 'none';
            
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const currentStudents = filteredStudents.slice(startIndex, endIndex);
            
            tbody.innerHTML = currentStudents.map((student, index) => {
                const actualIndex = startIndex + index + 1;
                return `
                    <tr>
                        <td>${actualIndex}</td>
                        <td class="student-id">${student.username}</td>
                        <td class="name">${student.lastname} ${student.firstname}</td>
                        <td><span class="class">${student.city}</span></td>
                        <td class="email">${student.email}</td>
                        <td>${student.course1}</td>
                        <td class="actions">
                            <button class="btn btn-edit" onclick="editStudent('${student.username}')">Sửa</button>
                            <button class="btn btn-delete" onclick="deleteStudent('${student.username}')">Xóa</button>
                        </td>
                    </tr>
                `;
            }).join('');
            
            createPagination();
        }

        // Tạo phân trang
        function createPagination() {
            const totalPages = Math.ceil(filteredStudents.length / itemsPerPage);
            const pagination = document.getElementById('pagination');
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }
            
            let paginationHTML = '';
            
            // Nút Previous
            if (currentPage > 1) {
                paginationHTML += `<button onclick="changePage(${currentPage - 1})">‹ Prev</button>`;
            }
            
            // Các trang
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    paginationHTML += `<button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    paginationHTML += `<span>...</span>`;
                }
            }
            
            // Nút Next
            if (currentPage < totalPages) {
                paginationHTML += `<button onclick="changePage(${currentPage + 1})">Next ›</button>`;
            }
            
            pagination.innerHTML = paginationHTML;
        }

        // Chuyển trang
        function changePage(page) {
            currentPage = page;
            displayStudents();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Tìm kiếm sinh viên
        function searchStudents() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            
            if (searchTerm === '') {
                filteredStudents = [...allStudents];
            } else {
                filteredStudents = allStudents.filter(student => 
                    student.username.toLowerCase().includes(searchTerm) ||
                    student.lastname.toLowerCase().includes(searchTerm) ||
                    student.firstname.toLowerCase().includes(searchTerm) ||
                    student.email.toLowerCase().includes(searchTerm) ||
                    student.city.toLowerCase().includes(searchTerm)
                );
            }
            
            currentPage = 1;
            updateStats();
            displayStudents();
        }

        // Xóa tìm kiếm
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            filteredStudents = [...allStudents];
            currentPage = 1;
            updateStats();
            displayStudents();
        }

        // Cập nhật thống kê
        function updateStats() {
            document.getElementById('totalStudents').textContent = `Tổng: ${filteredStudents.length} SV`;
            
            // Thống kê lớp
            const classCount = {};
            filteredStudents.forEach(student => {
                classCount[student.city] = (classCount[student.city] || 0) + 1;
            });
            
            const classInfo = Object.entries(classCount)
                .map(([className, count]) => `${className}: ${count}`)
                .join(' | ');
                
            document.getElementById('classInfo').textContent = classInfo || 'Lớp: Không có dữ liệu';
        }

        // Xuất file Excel
        function exportToExcel() {
            // Tạo nội dung CSV
            let csvContent = "Mã SV,Họ,Tên,Lớp,Email,Môn học\n";
            
            filteredStudents.forEach(student => {
                csvContent += `"${student.username}","${student.lastname}","${student.firstname}","${student.city}","${student.email}","${student.course1}"\n`;
            });
            
            // Tạo blob và download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', 'danh_sach_diem_danh_65HTTT.csv');
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Các hàm thao tác (giả lập)
        function editStudent(studentId) {
            alert(`Chức năng sửa sinh viên: ${studentId}\n(Tính năng này cần kết nối CSDL)`);
        }

        function deleteStudent(studentId) {
            if (confirm(`Bạn có chắc muốn xóa sinh viên ${studentId}?`)) {
                alert(`Đã xóa sinh viên: ${studentId}\n(Tính năng này cần kết nối CSDL)`);
            }
        }

        function showError(message) {
            const tbody = document.getElementById('studentsBody');
            tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: #e74c3c; padding: 20px;">${message}</td></tr>`;
        }

        // Khởi tạo khi trang load
        document.addEventListener('DOMContentLoaded', loadStudents);
        
        // Tìm kiếm khi nhấn Enter
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchStudents();
            }
        });
    </script>
</body>
</html>