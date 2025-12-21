<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    :root {
        /* Palette: Vàng Gold & Trắng (Luxury Style) */
        --primary-color: #cda45e;       /* Vàng Gold chủ đạo */
        --primary-hover: #b08d38;       /* Vàng đậm khi hover */
        --bg-body: #f4f4f4;             /* Nền xám nhạt đồng bộ Home */
        --card-bg: #ffffff;             /* Nền trắng */
        
        --text-heading: #0c1016;        /* Đen đậm (giống màu nền menu) */
        --text-body: #333333;           /* Chữ nội dung */
        --text-label: #888888;          /* Nhãn mờ */
        
        --border-color: #eee;           /* Viền mờ */
        --input-focus-border: #cda45e;  /* Viền input khi chọn */
        --input-focus-shadow: rgba(205, 164, 94, 0.2);
        
        --radius-lg: 8px;               /* Bo góc nhẹ hơn cho sang trọng */
        --radius-md: 4px;
        --shadow-card: 0 5px 20px rgba(0,0,0,0.05);
        
        --font-heading: 'Playfair Display', serif;
        --font-body: 'Poppins', sans-serif;
    }

    /* Tổng thể - ĐÃ CHỈNH SỬA ĐỂ CĂN GIỮA DỌC */
    .update-bg {
        min-height: 100vh; /* Thay đổi từ 85vh lên 100vh để full màn hình */
        background: var(--bg-body);
        display: flex;
        align-items: center;     /* Căn giữa theo chiều dọc */
        justify-content: center; /* Căn giữa theo chiều ngang */
        
        /* Giữ padding top để tránh menu cố định (fixed header) che mất nội dung */
        padding: 80px 20px 40px; 
        
        font-family: var(--font-body);
        box-sizing: border-box; /* Đảm bảo padding không làm vỡ layout */
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
        border: 1px solid var(--border-color);
    }

    /* === CỘT TRÁI: VISUAL === */
    .update-sidebar {
        flex: 0 0 35%; /* Chiếm 35% chiều rộng */
        /* Gradient nhẹ màu vàng nhạt */
        background: linear-gradient(135deg, #fffbf2 0%, #fff 100%);
        padding: 50px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-right: 1px solid var(--border-color);
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
        box-shadow: 0 8px 20px rgba(205, 164, 94, 0.2);
        margin-bottom: 25px;
        border: 1px solid var(--border-color);
    }

    .update-sidebar h2 {
        font-family: var(--font-heading);
        color: var(--text-heading);
        font-size: 26px;
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
        background: #fff5f5;
        border: 1px solid #fed7d7;
        color: #c53030;
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

    .update-main input {
        width: 100%;
        padding: 14px 14px 14px 45px; /* Chừa chỗ cho icon */
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-body);
        font-family: var(--font-body);
        font-size: 15px;
        outline: none;
        transition: all 0.2s ease;
    }

    .update-main input::placeholder {
        color: #ccc;
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
        border-top: 1px solid var(--border-color);
    }

    .btn-save {
        flex: 2;
        padding: 14px;
        background: var(--primary-color);
        color: white;
        border: 1px solid var(--primary-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-save:hover {
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
        text-align: center;
        text-decoration: none;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        text-transform: uppercase;
    }

    .btn-back:hover {
        background: #fff;
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Responsive: Mobile chuyển về dọc */
    @media (max-width: 768px) {
        .update-wrapper {
            flex-direction: column;
        }
        .update-sidebar {
            padding: 40px 30px;
            flex: none;
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }
        .update-main {
            padding: 30px;
        }
        .update-actions {
            flex-direction: column;
        }
        .btn-save, .btn-back {
            width: 100%;
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
// Đảm bảo layoutprofile.php load đúng các file cần thiết
include APPROOT . '/templates/layoutprofile.php';
?>