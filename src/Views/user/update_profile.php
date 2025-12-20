<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="update-bg">
    <div class="update-wrapper">
        
        <div class="update-sidebar">
            <div class="sidebar-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>
            <h2>Cập nhật hồ sơ</h2>
            <p>Thay đổi thông tin cá nhân và thông tin liên hệ của bạn tại đây.</p>
        </div>

        <div class="update-main">
            
            <?php if (!empty($error)): ?>
                <div class="error-box">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Họ và tên</label>
                    <div class="input-wrapper">
                        <input type="text" name="full_name" 
                               value="<?= htmlspecialchars($user['full_name']) ?>" 
                               placeholder="Nhập họ tên đầy đủ..." required>
                        <i class="fa-solid fa-signature"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email liên hệ</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" 
                               value="<?= htmlspecialchars($user['email']) ?>" 
                               placeholder="example@email.com" required>
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <div class="input-wrapper">
                        <input type="text" name="phone" 
                               value="<?= htmlspecialchars($user['phone']) ?>" 
                               placeholder="Nhập số điện thoại...">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                </div>

                <div class="update-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-check"></i> Lưu thay đổi
                    </button>
                    <a href="/profile/<?= $user['id'] ?>" class="btn-back">
                        Hủy bỏ
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