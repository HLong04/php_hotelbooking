<?php
ob_start();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="/src/Views/auth/css/csslogin.css">

<div class="login-container">
    <div class="login-card">
        
        <div class="login-visual">
            <div class="visual-icon">
                <i class="fa-solid fa-hotel"></i>
            </div>
            <h2>BookHotel</h2>
            <p>Trải nghiệm dịch vụ đặt phòng đẳng cấp. Đăng nhập để quản lý hành trình của bạn.</p>
        </div>

        <div class="login-form-wrapper">
            
            <h2 class="login-title">Đăng Nhập</h2>

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
                        
                        <input type="password" name="password" id="myPass" placeholder="Nhập mật khẩu" required>
                        
                        <i class="fa-solid fa-eye-slash toggle-password" 
                           onclick="
                               var input = document.getElementById('myPass');
                               if (input.type === 'password') {
                                   input.type = 'text';
                                   this.classList.remove('fa-eye-slash');
                                   this.classList.add('fa-eye');
                               } else {
                                   input.type = 'password';
                                   this.classList.remove('fa-eye');
                                   this.classList.add('fa-eye-slash');
                               }
                           ">
                        </i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Đăng nhập ngay <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>

                <div class="login-footer">
                    <p>Chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
                    <p style="margin-top: 10px;">
                        <a href="/" style="color: #95a5a6; font-weight: normal; font-size: 13px;">
                            <i class="fa-solid fa-arrow-left"></i> Quay về trang chủ
                        </a>
                    </p>
                </div>
            </form>
        </div>

    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/login.php'; 
?>