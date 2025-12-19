<?php
$title = 'Đăng ký tài khoản';
ob_start();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="/src/Views/auth/css/cssregister.css">

<div class="register-container">
    <div class="register-card">
        
        <div class="register-header">
            <div style="font-size: 40px; color: #2c3e50; margin-bottom: 10px;">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2>Tạo Tài Khoản</h2>
            <p>Trở thành thành viên của BookHotel ngay hôm nay</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="/register">
            
            <div class="input-group">
                <label>Họ và tên</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="full_name" placeholder="Ví dụ: Nguyễn Văn A" required>
                </div>
            </div>

            <div class="input-group">
                <label>Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="name@example.com" required>
                </div>
            </div>

            <div class="input-group">
                <label>Số điện thoại</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
                </div>
            </div>

            <div class="input-group">
                <label>Mật khẩu</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Tạo mật khẩu" required>
                </div>
            </div>

            <div class="input-group">
                <label>Xác nhận mật khẩu</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-shield-halved"></i>
                    <input type="password" name="password_check" placeholder="Nhập lại mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                Đăng Ký Ngay
            </button>

            <div class="register-footer">
                <p>Đã có tài khoản? <a href="/login">Đăng nhập ngay</a></p>
                <p style="margin-top: 10px;">
                    <a href="/" style="color: #95a5a6; font-weight: normal; font-size: 13px;">
                        <i class="fa-solid fa-house"></i> Về trang chủ
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include __DIR__ . '/../../../templates/login.php'; 
?>