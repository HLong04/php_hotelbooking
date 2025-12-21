<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    :root {
        /* Palette: Vàng Gold & Đen (Luxury Style) */
        --primary-color: #cda45e;       /* Vàng Gold chủ đạo */
        --primary-hover: #b08d38;       /* Vàng đậm khi hover */
        --bg-body: #f4f4f4;             /* Nền xám nhạt */
        --card-bg: #ffffff;             /* Nền trắng */
        
        --text-heading: #0c1016;        /* Đen đậm (giống header home) */
        --text-body: #333;              /* Chữ nội dung */
        --text-label: #888;             /* Nhãn mờ */
        
        --border-color: #eee;           /* Viền mờ */
        --input-focus-border: #cda45e;  /* Viền input khi focus */
        --input-focus-shadow: rgba(205, 164, 94, 0.2);
        
        --radius-lg: 8px;               /* Bo góc nhẹ (Luxury) */
        --radius-md: 4px;
        --shadow-card: 0 5px 20px rgba(0,0,0,0.05);
        
        --font-heading: 'Playfair Display', serif;
        --font-body: 'Poppins', sans-serif;
    }

    /* Tổng thể */
    .pwd-bg {
        min-height: 100vh; /* Full màn hình */
        background: var(--bg-body);
        display: flex;
        align-items: center;
        justify-content: center;
        /* Padding top 80px để tránh bị Navbar (fixed) che mất */
        padding: 80px 20px 40px; 
        font-family: var(--font-body);
    }

    /* Container chính */
    .pwd-wrapper {
        display: flex;
        width: 100%;
        max-width: 900px;
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    /* === SIDEBAR (Trái) === */
    .pwd-sidebar {
        flex: 0 0 35%;
        /* Gradient vàng nhạt sang trắng */
        background: linear-gradient(135deg, #fffbf2 0%, #fff 100%);
        padding: 50px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-right: 1px solid var(--border-color);
    }

    .pwd-icon-box {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: var(--primary-color);
        box-shadow: 0 8px 20px rgba(205, 164, 94, 0.2);
        margin-bottom: 25px;
        border: 1px solid var(--border-color);
    }

    .pwd-sidebar h2 {
        font-family: var(--font-heading);
        color: var(--text-heading);
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .pwd-sidebar p {
        color: var(--text-label);
        font-size: 14px;
        line-height: 1.6;
    }

    /* === MAIN CONTENT (Phải) === */
    .pwd-main {
        flex: 1;
        padding: 50px;
    }

    /* Thông báo lỗi/thành công */
    .alert-box {
        padding: 12px 16px;
        border-radius: var(--radius-md);
        font-size: 14px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-error {
        background: #fff5f5;
        border: 1px solid #fed7d7;
        color: #c53030;
    }
    .alert-success {
        background: #f0fff4;
        border: 1px solid #c6f6d5;
        color: #2f855a;
    }

    /* Form Styling */
    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
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

    .input-wrapper input {
        width: 100%;
        padding: 14px 14px 14px 45px;
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-body);
        font-family: var(--font-body);
        font-size: 15px;
        outline: none;
        transition: all 0.2s ease;
    }

    .input-wrapper input:focus {
        border-color: var(--input-focus-border);
        box-shadow: 0 0 0 4px var(--input-focus-shadow);
    }

    .input-wrapper input:focus + i {
        color: var(--primary-color);
    }

    /* Buttons */
    .pwd-actions {
        display: flex;
        gap: 15px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid var(--border-color);
    }

    .btn-submit {
        flex: 2;
        padding: 14px;
        background: var(--primary-color);
        color: white;
        border: 1px solid var(--primary-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(205, 164, 94, 0.4);
    }

    .btn-back {
        flex: 1;
        padding: 14px;
        background: transparent;
        color: var(--text-body);
        text-decoration: none;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-back:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pwd-wrapper {
            flex-direction: column;
        }
        .pwd-sidebar {
            flex: none;
            padding: 40px 20px;
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }
        .pwd-main {
            padding: 30px 20px;
        }
        .pwd-actions {
            flex-direction: column;
        }
    }
</style>

<div class="pwd-bg">
    <div class="pwd-wrapper">
        
        <div class="pwd-sidebar">
            <div class="pwd-icon-box">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h2>Bảo mật</h2>
            <p>Đặt mật khẩu mạnh để bảo vệ tài khoản của bạn an toàn hơn.</p>
        </div>

        <div class="pwd-main">
            
            <?php if (!empty($error)): ?>
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= $success ?></span>
                </div>
            <?php endif; ?>

            <form method="post">
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
                    <label>Xác nhận mật khẩu mới</label>
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