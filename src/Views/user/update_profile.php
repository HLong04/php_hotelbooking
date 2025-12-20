<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        /* Palette: Cam & Trắng (Business Clean) */
        --primary-color: #ff6b35;       /* Cam chủ đạo */
        --primary-hover: #e85d28;
        --bg-body: #f3f4f6;             /* Nền xám nhạt */
        --card-bg: #ffffff;             /* Nền trắng */
        
        --text-heading: #111827;        /* Chữ đậm */
        --text-body: #4b5563;           /* Chữ thường */
        --text-label: #6b7280;          /* Nhãn mờ */
        
        --border-color: #d1d5db;        /* Viền input */
        --input-focus-border: #ff6b35;  /* Viền khi focus */
        --input-focus-shadow: rgba(255, 107, 53, 0.2);
        
        --radius-lg: 20px;
        --radius-md: 10px;
        --shadow-card: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
    }

    /* Tổng thể */
    .update-bg {
        min-height: 85vh;
        background: var(--bg-body);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
    }

    /* Container chính chia 2 cột */
    .update-wrapper {
        display: flex;
        width: 100%;
        max-width: 900px;
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        border: 1px solid white;
    }

    /* === CỘT TRÁI: VISUAL === */
    .update-sidebar {
        flex: 0 0 35%; /* Chiếm 35% chiều rộng */
        background: linear-gradient(135deg, #fff7ed 0%, #fff 100%);
        padding: 50px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-right: 1px solid #f3f4f6;
    }

    .sidebar-icon {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: var(--primary-color);
        box-shadow: 0 8px 20px rgba(255, 107, 53, 0.15);
        margin-bottom: 25px;
    }

    .update-sidebar h2 {
        color: var(--text-heading);
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 10px;
    }

    .update-sidebar p {
        color: var(--text-label);
        font-size: 14px;
        line-height: 1.6;
        max-width: 250px;
        margin: 0;
    }

    /* === CỘT PHẢI: FORM === */
    .update-main {
        flex: 1; /* Chiếm phần còn lại */
        padding: 50px;
    }

    /* Error Box */
    .error-box {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #ef4444;
        padding: 12px 16px;
        margin-bottom: 25px;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-heading);
        margin-bottom: 8px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-label);
        font-size: 16px;
        transition: 0.3s;
    }

    .update-main input {
        width: 100%;
        padding: 14px 14px 14px 45px; /* Chừa chỗ cho icon */
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-heading);
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        outline: none;
        transition: all 0.2s ease;
    }

    .update-main input::placeholder {
        color: #9ca3af;
    }

    /* Hiệu ứng khi focus vào ô input */
    .update-main input:focus {
        border-color: var(--input-focus-border);
        box-shadow: 0 0 0 4px var(--input-focus-shadow);
    }
    
    .update-main input:focus + i,
    .input-wrapper:focus-within i {
        color: var(--primary-color);
    }

    /* Buttons */
    .update-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid #f3f4f6;
    }

    .btn-save {
        flex: 2;
        padding: 14px;
        background: var(--primary-color);
        color: white;
        border: 1px solid var(--primary-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.25);
    }

    .btn-back {
        flex: 1;
        padding: 14px;
        background: white;
        color: var(--text-body);
        text-align: center;
        text-decoration: none;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #f9fafb;
        color: var(--text-heading);
        border-color: #9ca3af;
    }

    /* Responsive: Mobile chuyển về dọc */
    @media (max-width: 768px) {
        .update-wrapper {
            flex-direction: column;
        }
        .update-sidebar {
            padding: 30px;
            flex: none;
            border-right: none;
            border-bottom: 1px solid #f3f4f6;
        }
        .update-main {
            padding: 30px;
        }
    }
</style>

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
include APPROOT . '/templates/layouthome.php';
?>