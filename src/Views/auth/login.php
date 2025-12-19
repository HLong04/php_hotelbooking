<?php
ob_start();
?>

<form method="POST" action="/login">
    <h2 style="text-align: center;">Đăng Nhập</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>

    <div class="form-group">
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>

    <button type="submit">Đăng nhập</button>
</form>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . '/../../../templates/login.php';?>