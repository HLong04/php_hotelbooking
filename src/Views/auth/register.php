<?php 
   $title = 'Đăng ký tài khoản';
   ob_start(); 
?>

<form method="POST" action="/register">
    <h2 style="text-align: center; color: #333;">Đăng Ký</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-group">
        <label>Họ và tên:</label>
        <input type="text" name="full_name" required>
    </div>

    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>

    <div class="form-group">
        <label>Số điện thoại:</label>
        <input type="text" name="phone" required>
    </div>

    <div class="form-group">
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>

    <div class="form-group">
        <label>Nhập lại mật khẩu:</label>
        <input type="password" name="password_check" required>
    </div>

    <button type="submit">Đăng Ký</button>

    <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
        Đã có tài khoản? <a href="/login" style="color: #e74c3c;">Đăng nhập</a>
    </p>
</form>

<?php $content = ob_get_clean(); ?>

<?php include(__DIR__ . '/../../../templates/login.php'); ?>