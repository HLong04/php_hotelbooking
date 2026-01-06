<?php
// Bắt đầu bộ nhớ đệm output
ob_start();

// Đảm bảo biến $rankInfo tồn tại (phòng trường hợp Controller chưa truyền qua)
// Mặc định giá trị để không bị lỗi nếu chạy độc lập
$rankData = $rankInfo ?? [
    'current_rank' => 'Standard',
    'next_rank' => 'VIP',
    'needed' => '0',
    'total_spent' => '0',
    'percent' => 0
];
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    /* =========================================
       CORE VARIABLES & RESET
       ========================================= */
    :root {
        --primary: #cda45e;
        /* Vàng Gold chủ đạo */
        --primary-hover: #b08d38;
        /* Vàng đậm hover */
        --bg-dark-heading: #0c1016;
        --bg-body-profile: #f4f4f4;
        --card-bg: #ffffff;
        --text-heading: #2c3e50;
        --text-body: #333;
        --text-muted: #888;
        --border-color: #eee;
        --radius-md: 8px;
        --shadow-card: 0 5px 20px rgba(0, 0, 0, 0.05);

        --font-heading: 'Playfair Display', serif;
        --font-body: 'Poppins', sans-serif;
    }

    /* =========================================
       LAYOUT STYLES
       ========================================= */
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

    .profile-wrapper {
        display: flex;
        gap: 30px;
        width: 100%;
        max-width: 1100px;
        align-items: flex-start;
    }

    .profile-box-style {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .profile-box-style:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    /* =========================================
       SIDEBAR (LEFT)
       ========================================= */
    .profile-sidebar {
        flex: 0 0 320px;
        padding: 40px 30px;
        text-align: center;
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

    .role-admin {
        background: var(--bg-dark-heading);
        color: var(--primary);
        border: 1px solid var(--bg-dark-heading);
    }

    .role-user {
        background: #f4f4f4;
        color: #555;
        border: 1px solid #ddd;
    }

    /* =========================================
       MAIN CONTENT (RIGHT)
       ========================================= */
    .profile-main {
        flex: 1;
        padding: 40px;
        display: flex;
        flex-direction: column;
    }

    /* --- NEW RANK SECTION STYLE --- */
    .rank-section-container {
        margin-bottom: 35px;
        padding: 25px 30px;
        border-radius: var(--radius-md);
        color: #fff;
        /* Gradient nền tối sang trọng để làm nổi bật màu vàng */
        background: linear-gradient(135deg, #1e2024 0%, #2c3e50 100%);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    /* Hiệu ứng ánh sáng nền */
    .rank-section-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(205, 164, 94, 0.3) 0%, transparent 70%);
        pointer-events: none;
    }

    .rank-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
    }

    .rank-title-label {
        font-size: 12px;
        text-transform: uppercase;
        color: #aaa;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .rank-current-display {
        font-family: var(--font-heading);
        font-size: 24px;
        color: var(--primary);
        font-weight: 700;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rank-money-display {
        text-align: right;
    }

    .rank-money-val {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
    }

    /* Progress Bar Styles */
    .rank-progress-track {
        background: rgba(255, 255, 255, 0.1);
        height: 10px;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 12px;
        position: relative;
        z-index: 2;
    }

    .rank-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #cda45e 0%, #f4d03f 100%);
        border-radius: 5px;
        transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 10px rgba(205, 164, 94, 0.6);
    }

    .rank-footer-info {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #bbb;
        position: relative;
        z-index: 2;
    }

    .rank-footer-info strong {
        color: #fff;
    }

    .next-rank-text {
        color: var(--primary);
        font-weight: 600;
    }

    /* --- INFO & FORM SECTION --- */
    .section-title-profile {
        font-family: var(--font-heading);
        font-size: 22px;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .section-title-profile::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--border-color);
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 40px;
    }

    .info-item {
        background: #fff;
        padding: 20px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .info-item:hover {
        border-color: var(--primary);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .icon-box-profile {
        width: 45px;
        height: 45px;
        background: rgba(205, 164, 94, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 18px;
        flex-shrink: 0;
    }

    .data-box label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }

    .data-box span {
        display: block;
        font-size: 15px;
        font-weight: 500;
        color: var(--text-body);
        word-break: break-all;
    }

    .action-row {
        display: flex;
        gap: 15px;
        margin-top: auto;
        border-top: 1px solid var(--border-color);
        padding-top: 30px;
    }

    .btn-profile {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-primary-profile {
        background: var(--primary);
        color: white;
        border: 1px solid var(--primary);
    }

    .btn-primary-profile:hover {
        background: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(205, 164, 94, 0.4);
    }

    .btn-outline-profile {
        background: transparent;
        color: var(--text-body);
        border: 1px solid #ddd;
    }

    .btn-outline-profile:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: white;
    }

    @media (max-width: 768px) {
        .profile-bg {
            padding: 40px 15px;
        }

        .profile-wrapper {
            flex-direction: column;
            gap: 20px;
        }

        .profile-sidebar {
            width: 100%;
            flex: none;
            padding: 30px;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .action-row {
            flex-direction: column;
        }

        .rank-header-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .rank-money-display {
            text-align: left;
        }
    }
</style>

<div class="profile-bg">
    <div class="profile-wrapper">

        <div class="profile-sidebar profile-box-style">
            <div class="sidebar-content">
                <div class="avatar-box">
                    <div class="avatar-circle">
                        <?php
                        $initial = !empty($user['full_name']) ? strtoupper(substr($user['full_name'], 0, 1)) : '';
                        ?>
                        <?php if ($initial): ?>
                            <span><?= $initial ?></span>
                        <?php else: ?>
                            <i class="fa-solid fa-user"></i>
                        <?php endif; ?>
                    </div>
                </div>

                <h2 class="user-name"><?= htmlspecialchars($user['full_name'] ?? 'Guest User') ?></h2>
                <?php if ($user['rank_level'] == 'vip'): ?>
                    <img src="/templates/image/—Pngtree—3d metal vip badge golden_7522372.png" alt="anh kimcuong" style="width: 100px; display: block; margin: 0 auto 10px auto;">
                <?php elseif ($user['rank_level'] == 'diamond'): ?>
                    <img src="/templates/image/Gemini_Generated_Image_caduu0caduu0cadu.png" alt="anh kimcuong" style="width: 100px; display: block; margin: 0 auto 10px auto;">
                <?php else:  ?>
                <?php endif; ?>
                <span class="user-role-badge <?= ($user['role'] ?? 0) == 1 ? 'role-admin' : 'role-user' ?>">
                    <?= ($user['role'] ?? 0) == 1 ? 'Administrator' : 'Member' ?>
                </span>
            </div>
        </div>

        <div class="profile-main profile-box-style">

            <div class="rank-section-container">
                <div class="rank-header-row">
                    <div>
                        <div class="rank-title-label">Hạng thành viên hiện tại</div>
                        <div class="rank-current-display">
                            <i class="fa-solid fa-crown"></i> <?= $rankData['current_rank'] ?>
                        </div>
                    </div>
                    <div class="rank-money-display">
                        <div class="rank-title-label">Tổng chi tiêu tích lũy</div>
                        <div class="rank-money-val"><?= $rankData['total_spent'] ?> VNĐ</div>
                    </div>
                </div>

                <div class="rank-progress-track">
                    <div class="rank-progress-fill" style="width: <?= $rankData['percent'] ?>%;"></div>
                </div>

                <div class="rank-footer-info">
                    <div>Tiến trình: <strong><?= $rankData['percent'] ?>%</strong></div>

                    <?php if ($rankData['next_rank'] !== 'Max Level'): ?>
                        <div>
                            Cần thêm <strong class="next-rank-text"><?= $rankData['needed'] ?> VNĐ</strong>
                            để lên <strong><?= $rankData['next_rank'] ?></strong>
                        </div>
                    <?php else: ?>
                        <div class="next-rank-text">Bạn đã đạt cấp bậc cao nhất!</div>
                    <?php endif; ?>
                </div>
            </div>
            <h3 class="section-title-profile">Thông tin cá nhân</h3>

            <div class="info-grid">
                <div class="info-item">
                    <div class="icon-box-profile"><i class="fa-solid fa-envelope"></i></div>
                    <div class="data-box">
                        <label>Email đăng ký</label>
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
                        <label>Trạng thái tài khoản</label>
                        <span style="color: green; font-weight: 600;">Đang hoạt động</span>
                    </div>
                </div>
            </div>

            <div class="action-row">
                <a href="/profile/update/<?= $user['id'] ?? '' ?>" class="btn-profile btn-primary-profile">
                    <i class="fa-solid fa-pen-to-square"></i> Cập nhật thông tin
                </a>
                <a href="/profile/change-password/<?= (int)($user['id'] ?? 0) ?>" class="btn-profile btn-outline-profile">
                    <i class="fa-solid fa-key"></i> Đổi mật khẩu
                </a>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
// Include Layout Profile (Đảm bảo đường dẫn này đúng trong project của bạn)
if (defined('APPROOT')) {
    include APPROOT . '/templates/layoutprofile.php';
} else {
    // Fallback nếu không định nghĩa APPROOT (Tùy chỉnh đường dẫn này nếu cần)
    include '../templates/layoutprofile.php';
}
?>