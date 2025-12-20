<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<<<<<<< HEAD
=======

<style>
    :root {
        /* Palette màu: Cam & Trắng (Clean Business Style) */
        --primary-color: #ff6b35;       /* Cam chủ đạo */
        --primary-hover: #e85d28;
        --bg-body: #f3f4f6;             /* Nền tổng thể xám nhạt */
        --card-bg: #ffffff;             /* Nền thẻ trắng */
        
        --text-heading: #111827;        /* Đen đậm cho tiêu đề */
        --text-body: #4b5563;           /* Xám cho nội dung */
        --text-label: #9ca3af;          /* Xám nhạt cho nhãn */
        
        --border-color: #e5e7eb;
        --radius-lg: 20px;
        --radius-md: 12px;
        --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    /* Cấu trúc trang */
    .profile-bg {
        min-height: 85vh;
        background: var(--bg-body);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        font-family: 'Inter', sans-serif;
    }

    /* Container chính dạng Flexbox nằm ngang */
    .profile-wrapper {
        display: flex;
        gap: 30px;
        width: 100%;
        max-width: 1000px; /* Mở rộng chiều ngang */
        align-items: flex-start; /* Căn trên cùng */
    }

    /* === CỘT TRÁI: NHẬN DIỆN === */
    .profile-sidebar {
        flex: 0 0 320px; /* Cố định chiều rộng cột trái */
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        padding: 40px 30px;
        text-align: center;
        box-shadow: var(--shadow-card);
        border: 1px solid white;
        position: relative;
        overflow: hidden;
    }

    /* Decor nhẹ cho cột trái */
    .profile-sidebar::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: linear-gradient(180deg, #fff7ed 0%, rgba(255,255,255,0) 100%);
        z-index: 0;
    }

    .sidebar-content {
        position: relative;
        z-index: 1;
    }

    .avatar-box {
        position: relative;
        margin: 0 auto 20px;
        width: 120px;
        height: 120px;
    }

    .avatar-circle {
        width: 100%;
        height: 100%;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: var(--primary-color);
        box-shadow: 0 10px 25px rgba(255, 107, 53, 0.15);
        border: 4px solid white;
    }

    .user-name {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 8px;
    }

    .user-role-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin { background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
    .role-user { background: #ecfdf5; color: #047857; border: 1px solid #d1fae5; }

    /* === CỘT PHẢI: THÔNG TIN CHI TIẾT === */
    .profile-main {
        flex: 1; /* Chiếm phần còn lại */
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-card);
        border: 1px solid white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title::before {
        content: "";
        width: 4px;
        height: 24px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    /* Grid layout cho các ô thông tin */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Chia 2 cột */
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-item {
        background: #f9fafb;
        padding: 20px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .info-item:hover {
        border-color: var(--primary-color);
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .icon-box {
        width: 45px;
        height: 45px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 18px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .data-box label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-label);
        margin-bottom: 4px;
    }

    .data-box span {
        display: block;
        font-size: 15px;
        font-weight: 600;
        color: var(--text-heading);
        word-break: break-all; /* Ngắt dòng nếu email quá dài */
    }

    /* Khu vực nút bấm nằm ngang */
    .action-row {
        display: flex;
        gap: 15px;
        margin-top: auto;
        border-top: 1px solid var(--border-color);
        padding-top: 25px;
    }

    .btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: 0.2s;
        cursor: pointer;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        border: 1px solid var(--primary-color);
    }
    .btn-primary:hover { background: var(--primary-hover); transform: translateY(-2px); }

    .btn-outline {
        background: white;
        color: var(--text-body);
        border: 1px solid var(--border-color);
    }
    .btn-outline:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: #fff7ed;
    }

    /* Responsive cho Mobile: Chuyển về dọc */
    @media (max-width: 768px) {
        .profile-wrapper {
            flex-direction: column;
            gap: 20px;
        }
        .profile-sidebar {
            width: 100%;
            flex: none;
        }
        .info-grid {
            grid-template-columns: 1fr; /* Về 1 cột trên mobile */
        }
        .action-row {
            flex-direction: column;
        }
    }
</style>
>>>>>>> e82787de6dc01637d1bf70fb236eabc569091812

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