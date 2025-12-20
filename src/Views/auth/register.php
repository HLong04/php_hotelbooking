<?php
$title = 'Đăng ký tài khoản';
ob_start();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="/src/Views/auth/css/cssregister.css">

<div class="register-container">
    <div class="register-card">
        
        <div class="register-visual">
            <div class="visual-icon">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2>Tạo Tài Khoản</h2>
            <p>Trở thành thành viên của BookHotel ngay hôm nay để nhận nhiều ưu đãi.</p>
        </div>

        <div class="register-form-wrapper">
            
            <h2 class="register-title">Thông tin đăng ký</h2>

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
                        
                        <input type="password" name="password" id="pass1" placeholder="Tạo mật khẩu" required>
                        
                        <i class="fa-solid fa-eye-slash toggle-password" 
                           onclick="
                               var input = document.getElementById('pass1');
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

                <div class="input-group">
                    <label>Xác nhận mật khẩu</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-shield-halved"></i>
                        
                        <input type="password" name="password_check" id="pass2" placeholder="Nhập lại mật khẩu" required>
                        
                        <i class="fa-solid fa-eye-slash toggle-password" 
                           onclick="
                               var input = document.getElementById('pass2');
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

                <button type="submit" class="btn-register">
                    Đăng Ký Ngay
                </button>

                <div class="register-footer">
                    <p>Đã có tài khoản? <a href="/login">Đăng nhập ngay</a></p>
                    <p style="margin-top: 10px;">
                        <a href="/" style="color: #95a5a6; font-weight: normal; font-size: 13px;">
                            <i class="fa-solid fa-arrow-left"></i> Về trang chủ
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
// Lưu ý: Đường dẫn include này giữ nguyên theo code cũ của bạn
include __DIR__ . '/../../../templates/login.php'; 
?>