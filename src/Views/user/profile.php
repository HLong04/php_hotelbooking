<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    /* =========================================
       SỬ DỤNG BIẾN TỪ STYLE.CSS CỦA HOME
       ========================================= */
    :root {
        --primary: #cda45e;       /* Vàng Gold chủ đạo */
        --primary-hover: #b08d38; /* Vàng đậm hover */
        --bg-dark-heading: #0c1016; /* Màu đen đậm của heading home */
        --bg-body-profile: #f4f4f4; /* Nền xám nhạt giống home */
        --card-bg: #ffffff;             
        --text-heading-color: #2c3e50;  
        --text-body-color: #333;          
        --text-muted: #888;          
        
        --border-color: #eee;     /* Viền mờ giống card home */
        --radius-md: 8px;         /* Bo góc 8px giống card home */
        --shadow-card: 0 5px 20px rgba(0,0,0,0.05); /* Bóng mờ giống card home */
        
        --font-heading: 'Playfair Display', serif; /* Font tiêu đề sang trọng */
        --font-body: 'Poppins', sans-serif;        /* Font nội dung hiện đại */
    }

    .profile-bg {
        min-height: 100vh; 
        
        background: var(--bg-body-profile);
        display: flex;
        align-items: center;  
        justify-content: center; 
        padding: 80px 20px 40px 20px; 
        font-family: var(--font-body);
        box-sizing: border-box;
    }

    /* Container chính */
    .profile-wrapper {
        display: flex;
        gap: 30px;
        width: 100%;
        max-width: 1100px; /* Rộng hơn một chút cho thoáng */
        align-items: flex-start;
    }

    /* --- DÙNG CHUNG STYLE CHO CÁC BOX (Giống Room Card ở Home) --- */
    .profile-box-style {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    .profile-box-style:hover {
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }

    .profile-sidebar {
        flex: 0 0 320px;
        padding: 40px 30px;
        text-align: center;
        background: var(--card-bg);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border-color);
    }

    .avatar-box {
        position: relative;
        margin: 0 auto 25px;
        width: 130px;
        height: 130px;
    }

    .avatar-circle {
        width: 100%;
        height: 100%;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
        color: white;
        box-shadow: 0 10px 25px rgba(205, 164, 94, 0.3);
        border: 4px solid #fff;
    }

    .user-name {
        font-family: var(--font-heading); 
        font-size: 26px;
        font-weight: 700;
        color: var(--bg-dark-heading);
        margin-bottom: 15px;
    }

    .user-role-badge {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .role-admin { background: var(--bg-dark-heading); color: var(--primary); border: 1px solid var(--bg-dark-heading); }
    .role-user { background: #f4f4f4; color: #555; border: 1px solid #ddd; }
    .profile-main {
        flex: 1;
        padding: 40px;
        background: var(--card-bg);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
    }

    .section-title-profile {
        font-family: var(--font-heading); 
        font-size: 24px;
        font-weight: 700;
        color: var(--bg-dark-heading);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .section-title-profile::after {
        content: "";
        flex: 1;
        height: 2px;
        background: var(--border-color);
        
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 40px;
    }

    .info-item {
        background: #fff;
        padding: 25px 20px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        display: flex;
        align-items: flex-start; 
        gap: 20px;
    }
    
    .info-item:hover {
        border-color: var(--primary);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .icon-box-profile {
        width: 50px;
        height: 50px;
        background: rgba(205, 164, 94, 0.1);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary); 
        font-size: 20px;
        flex-shrink: 0;
    }

    .data-box label {
        display: block;
        font-family: var(--font-body);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
        letter-spacing: 1px;
    }

    .data-box span {
        display: block;
        font-family: var(--font-body);
        font-size: 16px;
        font-weight: 500;
        color: var(--text-body-color);
        word-break: break-all;
    }
    .action-row {
        display: flex;
        gap: 20px;
        margin-top: auto;
        border-top: 1px solid var(--border-color);
        padding-top: 30px;
    }

    .btn-profile {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: var(--font-body);
    }

    .btn-primary-profile {
        background: var(--primary);
        color: white;
        border: 1px solid var(--primary);
    }
    .btn-primary-profile:hover {
        background: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(205, 164, 94, 0.4);
    }


    .btn-outline-profile {
        background: transparent;
        color: var(--text-body-color);
        border: 1px solid var(--border-color);
    }
    .btn-outline-profile:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: white;
    }

    .role-text-highlight {
        font-weight: 700 !important;
        color: var(--primary) !important;
    }

    @media (max-width: 768px) {
        .profile-bg {
            padding: 40px 15px;
        }
        .profile-wrapper {
            flex-direction: column;
            gap: 25px;
        }
        .profile-sidebar {
            width: 100%;
            flex: none;
        }
        .info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        .info-item {
             padding: 20px 15px;
        }
        .action-row {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>

<div class="profile-bg">
    <div class="profile-wrapper">
        
        <div class="profile-sidebar profile-box-style">
            <div class="sidebar-content">
                <div class="avatar-box">
                    <div class="avatar-circle">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                
                <h2 class="user-name"><?= htmlspecialchars($user['full_name'] ?? 'N/A') ?></h2>
                
                <span class="user-role-badge <?= ($user['role'] ?? 0) == 1 ? 'role-admin' : 'role-user' ?>">
                    <?= ($user['role'] ?? 0) == 1 ? 'ADMINISTRATOR' : 'MEMBER' ?>
                </span>
            </div>
        </div>

        <div class="profile-main profile-box-style">
            <h3 class="section-title-profile">Thông tin cá nhân</h3>

            <div class="info-grid">
                <div class="info-item">
                    <div class="icon-box-profile"><i class="fa-solid fa-envelope"></i></div>
                    <div class="data-box">
                        <label>Email</label>
                        <span><?= htmlspecialchars($user['email'] ?? 'N/A') ?></span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-box-profile"><i class="fa-solid fa-phone"></i></div>
                    <div class="data-box">
                        <label>Số điện thoại</label>
                        <span><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="icon-box-profile"><i class="fa-solid fa-calendar-days"></i></div>
                    <div class="data-box">
                        <label>Ngày tham gia</label>
                        <span><?= htmlspecialchars($user['created_at'] ?? '---') ?></span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-box-profile"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="data-box">
                        <label>Vai trò hệ thống</label>
                        <span class="role-text-highlight"><?= htmlspecialchars($user['role'] == 1 ? 'Quản trị viên (Admin)' : 'Thành viên thân thiết') ?></span>
                    </div>
                </div>
            </div>

            <div class="action-row">
                <a href="/profile/update/<?= $user['id'] ?? '' ?>" class="btn-profile btn-primary-profile">
                    <i class="fa-solid fa-pen-to-square"></i> Cập nhật thông tin
                </a>
                <a href="/profile/change-password/<?= (int)$user['id'] ?>" class="btn-profile btn-outline-profile">
                    <i class="fa-solid fa-key"></i> Đổi mật khẩu
                </a>
            </div>
        </div>

    </div>
</div>

<?php 
$content = ob_get_clean(); 
// Đảm bảo layoutprofile.php cũng load các file css chung như style.css của home
include APPROOT . '/templates/layoutprofile.php';
?>