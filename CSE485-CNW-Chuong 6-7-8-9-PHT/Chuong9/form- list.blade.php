<form action="{{ route('sinhvien.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 10px;">
            Tên sinh viên: <input type="text" name="ten_sinh_vien" required>
        </div>
        <div style="margin-bottom: 10px;">
            Email: <input type="email" name="email" required>
        </div>

        <button type="submit">Thêm</button>
</form>
