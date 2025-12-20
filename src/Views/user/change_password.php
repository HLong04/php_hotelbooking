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
        --success-color: #2ecc71;
        --ocean-bg: linear-gradient(135deg, #0f2027, #20394b, #2c5364);
        --glass-bg: rgba(255, 255, 255, 0.05);
        --input-bg: rgba(255, 255, 255, 0.07);
        --text-main: #f8f9fa;
        --text-muted: rgba(255, 255, 255, 0.5);
    }

    .pwd-bg {
        min-height: 85vh;
        background: var(--ocean-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        font-family: 'Quicksand', sans-serif;
    }

    .pwd-card {
        width: 100%;
        max-width: 450px;
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        padding: 50px 40px;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    }

    .pwd-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .pwd-header i {
        font-size: 45px;
        color: var(--secondary-color);
        margin-bottom: 15px;
        filter: drop-shadow(0 0 10px rgba(26, 188, 156, 0.4));
    }

    .pwd-header h2 {
        color: var(--text-main);
        margin: 0;
        font-weight: 700;
        font-size: 26px;
        letter-spacing: 0.5px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        color: var(--secondary-color);
        letter-spacing: 1.2px;
        font-weight: 700;
        margin-bottom: 8px;
        padding-left: 5px;
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

    .pwd-card input {
        width: 100%;
        padding: 14px 15px 14px 45px;
        background: var(--input-bg);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        color: white;
        font-family: sans-serif; /* Để dấu chấm password nhìn rõ hơn */
        font-size: 16px;
        outline: none;
        transition: all 0.3s ease;
    }

    .pwd-card input:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 15px rgba(26, 188, 156, 0.2);
        background: rgba(255, 255, 255, 0.1);
    }

    /* Thông báo lỗi/thành công */
    .alert {
        padding: 12px 15px;
        border-radius: 12px;
        font-size: 13px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid;
    }

    .alert-danger {
        background: rgba(231, 76, 60, 0.15);
        color: #ff7675;
        border-color: rgba(231, 76, 60, 0.3);
    }

    .alert-success {
        background: rgba(46, 204, 113, 0.15);
        color: #55efc4;
        border-color: rgba(46, 204, 113, 0.3);
    }

    .pwd-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 35px;
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        background: var(--secondary-color);
        color: white;
        border: none;
        border-radius: 18px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Quicksand', sans-serif;
    }

    .btn-submit:hover {
        background: #16a085;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(26, 188, 156, 0.3);
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
        transition: 0.3s;
    }

    .btn-back:hover {
        color: white;
        border-color: white;
        background: rgba(255, 255, 255, 0.05);
    }
</style>

<div class="pwd-bg">
    <div class="pwd-card">
        <div class="pwd-header">
            <i class="fa-solid fa-shield-lock"></i>
            <h2>Bảo mật tài khoản</h2>
        </div>

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
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="current_password" required placeholder="••••••••">
                </div>
            </div>

            <div class="form-group">
                <label>Mật khẩu mới</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock-open"></i>
                    <input type="password" name="new_password" required placeholder="••••••••">
                </div>
            </div>

            <div class="form-group">
                <label>Xác nhận mật khẩu</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-check-double"></i>
                    <input type="password" name="confirm_password" required placeholder="••••••••">
                </div>
            </div>

            <div class="pwd-actions">
                <button type="submit" class="btn-submit">
                    Cập nhật mật khẩu
                </button>
                <a href="/profile/<?= (int)$_SESSION['user_id'] ?>" class="btn-back">
                    <i class="fa-solid fa-chevron-left"></i> Quay lại hồ sơ
                </a>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layouthome.php';
?>