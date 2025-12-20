<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="profile-bg">
    <div class="profile-wrapper">
        
        <div class="profile-sidebar">
            <div class="sidebar-content">
                <div class="avatar-box">
                    <div class="avatar-circle">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                
                <h2 class="user-name"><?= htmlspecialchars($user['full_name'] ?? 'N/A') ?></h2>
                
                <span class="user-role-badge <?= ($user['role'] ?? 0) == 1 ? 'role-admin' : 'role-user' ?>">
                    <?= ($user['role'] ?? 0) == 1 ? 'Quản trị viên' : 'Thành viên' ?>
                </span>
            </div>
        </div>

        <div class="profile-main">
            <h3 class="section-title">Thông tin liên hệ</h3>

            <div class="info-grid">
                <div class="info-item">
                    <div class="icon-box"><i class="fa-solid fa-envelope"></i></div>
                    <div class="data-box">
                        <label>Email</label>
                        <span><?= htmlspecialchars($user['email'] ?? 'N/A') ?></span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-box"><i class="fa-solid fa-phone"></i></div>
                    <div class="data-box">
                        <label>Số điện thoại</label>
                        <span><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="icon-box"><i class="fa-solid fa-fingerprint"></i></div>
                    <div class="data-box">
                        <label>Ngày tham gia</label>
                        <span><?= htmlspecialchars($user['created_at'] ?? '---') ?></span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-box"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="data-box">
                        <label>Vai trò</label>
                        <span style="color: #047857;"><?= htmlspecialchars($user['role'] == 1 ? 'Quản trị viên' : 'Thành viên') ?></span>
                    </div>
                </div>
            </div>

            <div class="action-row">
                <a href="/profile/update/<?= $user['id'] ?? '' ?>" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Cập nhật thông tin
                </a>
                <a href="/profile/change-password/<?= (int)$user['id'] ?>" class="btn btn-outline">
                    <i class="fa-solid fa-key"></i> Đổi mật khẩu
                </a>
            </div>
        </div>

    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layoutprofile.php';
?>