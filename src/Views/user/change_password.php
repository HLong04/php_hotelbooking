<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<<<<<<< HEAD
=======

<style>
    :root {
        /* Palette: Cam & Trắng (Clean Business) */
        --primary-color: #ff6b35;       /* Cam chủ đạo */
        --primary-hover: #e85d28;
        --bg-body: #f3f4f6;             /* Nền xám nhạt */
        --card-bg: #ffffff;             /* Nền thẻ trắng */
        
        --text-heading: #111827;        /* Chữ đen đậm */
        --text-body: #4b5563;           /* Chữ nội dung */
        --text-label: #6b7280;          /* Chữ nhãn mờ */
        
        --border-color: #d1d5db;
        --input-focus: #ff6b35;
        --shadow-soft: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        --radius-lg: 20px;
        --radius-md: 10px;
    }

    /* Tổng thể trang */
    .pwd-bg {
        min-height: 85vh;
        background: var(--bg-body);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
    }

    /* Container chính chia 2 cột */
    .pwd-wrapper {
        display: flex;
        width: 100%;
        max-width: 900px;
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        border: 1px solid white;
    }

    /* === CỘT TRÁI: VISUAL === */
    .pwd-sidebar {
        flex: 0 0 35%; /* Chiếm 35% chiều rộng */
        background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
        padding: 50px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-right: 1px solid #f3f4f6;
    }

    .sidebar-icon {
        width: 90px;
        height: 90px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: var(--primary-color);
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.15);
        margin-bottom: 25px;
        border: 4px solid #fff;
    }

    .pwd-sidebar h2 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-heading);
        margin: 0 0 10px;
    }

    .pwd-sidebar p {
        font-size: 14px;
        color: var(--text-label);
        line-height: 1.6;
        margin: 0;
        max-width: 240px;
    }

    /* === CỘT PHẢI: FORM === */
    .pwd-main {
        flex: 1;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Alerts */
    .alert {
        padding: 14px 16px;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-danger {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #ecfdf5;
        color: #10b981;
        border: 1px solid #d1fae5;
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

    .pwd-main input {
        width: 100%;
        padding: 14px 14px 14px 45px;
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-heading);
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        outline: none;
        transition: all 0.2s;
    }

    .pwd-main input:focus {
        border-color: var(--input-focus);
        box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
    }

    .pwd-main input:focus + i {
        color: var(--primary-color);
    }

    .pwd-main input::placeholder {
        color: #9ca3af;
        letter-spacing: 2px; /* Dấu chấm password đẹp hơn */
    }

    /* Actions */
    .pwd-actions {
        display: flex;
        gap: 15px;
        margin-top: 10px;
        padding-top: 25px;
        border-top: 1px solid #f3f4f6;
    }

    .btn-submit {
        flex: 2;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        padding: 14px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.25);
    }

    .btn-back {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 14px;
        background: white;
        color: var(--text-body);
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

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .pwd-wrapper { flex-direction: column; }
        .pwd-sidebar { 
            padding: 30px; 
            border-right: none; 
            border-bottom: 1px solid #f3f4f6;
            flex: none;
        }
        .pwd-main { padding: 30px; }
    }
</style>
>>>>>>> e82787de6dc01637d1bf70fb236eabc569091812

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