<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="pwd-bg">
    <div class="pwd-wrapper">
        
        <div class="pwd-sidebar">
            <div class="sidebar-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h2>Bảo mật tài khoản</h2>
            <p>Để bảo vệ tài khoản, vui lòng không chia sẻ mật khẩu của bạn cho bất kỳ ai.</p>
        </div>

        <div class="pwd-main">
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Mật khẩu hiện tại</label>
                    <div class="input-wrapper">
                        <input type="password" name="current_password" required placeholder="••••••••">
                        <i class="fa-solid fa-key"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <div class="input-wrapper">
                        <input type="password" name="new_password" required placeholder="••••••••">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <div class="input-wrapper">
                        <input type="password" name="confirm_password" required placeholder="••••••••">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                </div>

                <div class="pwd-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-rotate"></i> Cập nhật
                    </button>
                    <a href="/profile/<?= (int)$_SESSION['user_id'] ?>" class="btn-back">
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layoutprofile.php';
?>