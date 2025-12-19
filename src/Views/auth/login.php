<?php
ob_start();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="/src/Views/auth/css/csslogin.css">

<div class="login-container">
    <div class="login-card">
        
        <div class="login-header">
            <div style="font-size: 40px; color: #e74c3c; margin-bottom: 10px;">
                <i class="fa-solid fa-hotel"></i>
            </div>
            <h2>Đăng Nhập</h2>
            <p>Chào mừng bạn quay trở lại với BookHotel</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login">
            
            <div class="input-group">
                <label>Địa chỉ Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Ví dụ: admin@gmail.com" required>
                </div>
            </div>

            <div class="input-group">
                <label>Mật khẩu</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Đăng nhập ngay
            </button>

            <div class="login-footer">
                <p>Chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
                <p style="margin-top: 10px;">
                    <a href="/" style="color: #7f8c8d; font-weight: normal;">
                        <i class="fa-solid fa-arrow-left"></i> Quay về trang chủ
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/login.php'; 
?>