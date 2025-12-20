<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        /* Palette màu mới: Xanh ngọc & Vàng dịu */
        --primary-color: #16a085;       /* Teal đậm */
        --secondary-color: #1abc9c;     /* Teal sáng */
        --accent-color: #f1c40f;        /* Vàng điểm xuyết */
        --bg-gradient: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d); /* Hoặc dùng nền Deep Ocean bên dưới */
        --ocean-bg: linear-gradient(135deg, #0f2027, #20394b, #2c5364);
        
        --glass-bg: rgba(255, 255, 255, 0.05);
        --text-main: #f8f9fa;
        --text-muted: rgba(255, 255, 255, 0.5);
    }

    .profile-bg {
        min-height: 85vh;
        background: var(--ocean-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        font-family: 'Quicksand', sans-serif;
    }

    .profile-card {
        width: 100%;
        max-width: 480px;
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        padding: 50px 40px;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
        position: relative;
    }

    /* Trang trí góc thẻ */
    .profile-card::after {
        content: "";
        position: absolute;
        top: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background: radial-gradient(circle, rgba(26, 188, 156, 0.2) 0%, transparent 70%);
        border-radius: 50%;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        color: white;
        box-shadow: 0 15px 30px rgba(22, 160, 133, 0.3);
        border: 4px solid rgba(255, 255, 255, 0.05);
    }

    .profile-header h2 {
        color: var(--text-main);
        margin: 0;
        font-weight: 700;
        font-size: 28px;
        letter-spacing: 0.5px;
    }

    .profile-header .line {
        width: 40px;
        height: 3px;
        background: var(--secondary-color);
        margin: 15px auto;
        border-radius: 10px;
    }

    .profile-info-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-row {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
    }

    .info-row:hover {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(26, 188, 156, 0.3);
        transform: scale(1.02);
    }

    .info-icon {
        width: 42px;
        color: var(--secondary-color);
        font-size: 20px;
        margin-right: 20px;
        display: flex;
        justify-content: center;
    }

    .info-text label {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 1.5px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .info-text span {
        color: var(--text-main);
        font-size: 16px;
        font-weight: 500;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .badge-admin { 
        background: rgba(241, 196, 15, 0.15);
        color: #f1c40f;
        border: 1px solid rgba(241, 196, 15, 0.3);
    }
    
    .badge-user { 
        background: rgba(26, 188, 156, 0.15);
        color: #1abc9c;
        border: 1px solid rgba(26, 188, 156, 0.3);
    }

    .btn-update {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        padding: 18px;
        margin-top: 40px;
        background: transparent;
        color: white;
        border: 2px solid var(--secondary-color);
        border-radius: 20px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-update:hover {
        background: var(--secondary-color);
        box-shadow: 0 10px 25px rgba(26, 188, 156, 0.4);
        transform: translateY(-3px);
    }
</style>

<div class="profile-bg">
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar-circle">
                <i class="fa-solid fa-circle-user"></i>
            </div>
            <h2>Hồ sơ cá nhân</h2>
            <div class="line"></div>
        </div>

        <div class="profile-info-list">
            <div class="info-row">
                <div class="info-icon"><i class="fa-solid fa-signature"></i></div>
                <div class="info-text">
                    <label>Họ và Tên</label>
                    <span><?= htmlspecialchars($user['full_name'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                <div class="info-text">
                    <label>Email liên hệ</label>
                    <span><?= htmlspecialchars($user['email'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fa-solid fa-mobile-button"></i></div>
                <div class="info-text">
                    <label>Số điện thoại</label>
                    <span><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="info-text">
                    <label>Loại tài khoản</label>
                    <span class="badge <?= ($user['role'] ?? 0) == 1 ? 'badge-admin' : 'badge-user' ?>">
                        <?= ($user['role'] ?? 0) == 1 ? 'Quản trị viên' : 'Thành viên' ?>
                    </span>
                </div>
            </div>
        </div>

        <a href="/profile/update/<?= $user['id'] ?? '' ?>" class="btn-update">
            <i class="fa-solid fa-user-pen"></i> Chỉnh sửa thông tin
        </a>
        <a href="/profile/change-password/<?= (int)$user['id'] ?>" class="btn-update">
            <i class="fa-solid fa-user-pen"></i> 🔐 Thay đổi mật khẩu
        </a>

        
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layouthome.php';
?>