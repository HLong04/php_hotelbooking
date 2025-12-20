<?php 
ob_start(); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #16a085;
        --secondary-color: #1abc9c;
        --error-color: #e74c3c;
        --ocean-bg: linear-gradient(135deg, #0f2027, #20394b, #2c5364);
        --glass-bg: rgba(255, 255, 255, 0.05);
        --input-bg: rgba(255, 255, 255, 0.07);
        --text-main: #f8f9fa;
        --text-muted: rgba(255, 255, 255, 0.5);
    }

    .update-bg {
        min-height: 85vh;
        background: var(--ocean-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        font-family: 'Quicksand', sans-serif;
    }

    .update-card {
        width: 100%;
        max-width: 500px;
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        padding: 50px 40px;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    }

    .update-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .update-header i {
        font-size: 40px;
        color: var(--secondary-color);
        margin-bottom: 15px;
    }

    .update-header h2 {
        color: var(--text-main);
        margin: 0;
        font-weight: 700;
        font-size: 28px;
    }

    .form-group {
        margin-bottom: 22px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        color: var(--secondary-color);
        letter-spacing: 1.5px;
        font-weight: 700;
        margin-bottom: 8px;
        margin-left: 5px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrapper i {
        position: absolute;
        left: 15px;
        color: var(--text-muted);
        font-size: 16px;
    }

    .update-card input {
        width: 100%;
        padding: 14px 15px 14px 45px;
        background: var(--input-bg);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        color: white;
        font-family: 'Quicksand', sans-serif;
        font-size: 15px;
        outline: none;
        transition: all 0.3s ease;
    }

    .update-card input:focus {
        background: rgba(255, 255, 255, 0.12);
        border-color: var(--secondary-color);
        box-shadow: 0 0 15px rgba(26, 188, 156, 0.2);
    }

    /* Error Box đồng bộ */
    .error-box {
        background: rgba(231, 76, 60, 0.15);
        border: 1px solid rgba(231, 76, 60, 0.3);
        color: #ff7675;
        padding: 12px 15px;
        margin-bottom: 25px;
        border-radius: 12px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .update-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 35px;
    }

    .btn-save {
        width: 100%;
        padding: 16px;
        background: var(--secondary-color);
        color: white;
        border: none;
        border-radius: 18px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(26, 188, 156, 0.3);
    }

    .btn-save:hover {
        background: #16a085;
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(26, 188, 156, 0.4);
    }

    .btn-back {
        width: 100%;
        padding: 14px;
        background: transparent;
        color: var(--text-muted);
        text-align: center;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 18px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-back:hover {
        color: white;
        background: rgba(255, 255, 255, 0.05);
        border-color: white;
    }
</style>

<div class="update-bg">
    <div class="update-card">
        <div class="update-header">
            <i class="fa-solid fa-user-gear"></i>
            <h2>Cập nhật hồ sơ</h2>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-box">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Họ và tên</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-signature"></i>
                    <input type="text" name="full_name" 
                           value="<?= htmlspecialchars($user['full_name']) ?>" 
                           placeholder="Nhập họ tên của bạn..." required>
                </div>
            </div>

            <div class="form-group">
                <label>Email liên hệ</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-at"></i>
                    <input type="email" name="email" 
                           value="<?= htmlspecialchars($user['email']) ?>" 
                           placeholder="example@gmail.com" required>
                </div>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-mobile-button"></i>
                    <input type="text" name="phone" 
                           value="<?= htmlspecialchars($user['phone']) ?>" 
                           placeholder="Nhập số điện thoại...">
                </div>
            </div>

            <div class="update-actions">
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                </button>
                <a href="/profile/<?= $user['id'] ?>" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại hồ sơ
                </a>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layouthome.php';
?>