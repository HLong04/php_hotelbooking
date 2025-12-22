<?php ob_start(); ?>

<style>
    :root {
        --primary: #cda45e;
        --primary-hover: #b08d38;
        --bg-body: #f8f9fa; /* Màu nền xám nhạt như trong hình profile */
        --card-bg: #ffffff;
        --text-main: #212529;
        --text-muted: #6c757d;
        --radius: 12px;
        --shadow: 0 10px 30px rgba(0,0,0,0.05);
        --font-heading: 'Playfair Display', serif;
        --font-body: 'Poppins', sans-serif;
    }

    .booking-page {
        background: var(--bg-body);
        min-height: 100vh;
        padding: 80px 20px;
        font-family: var(--font-body);
    }

    .booking-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Tiêu đề trang giống Profile */
    .page-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title {
        font-family: var(--font-heading);
        font-size: 32px;
        font-weight: 700;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
    }

    .section-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary);
    }

    /* Bố cục 2 cột */
    .booking-wrapper {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    /* Cột trái: Thông tin phòng (Avatar style) */
    .room-sidebar {
        flex: 0 0 350px;
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 30px;
        text-align: center;
    }

    .room-image-circle {
        width: 220px;
        height: 220px;
        border-radius: 15px; /* Bo góc nhẹ thay vì tròn hẳn để thấy rõ phòng */
        object-fit: cover;
        margin-bottom: 20px;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .room-sidebar h3 {
        font-family: var(--font-heading);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .badge-status {
        background: #fdfaf3;
        color: var(--primary);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Cột phải: Form đặt phòng */
    .booking-main-content {
        flex: 1;
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 40px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-item {
        background: #fff;
        border: 1px solid #f0f0f0;
        padding: 15px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .info-item i {
        font-size: 20px;
        color: var(--primary);
        background: #fdfaf3;
        padding: 12px;
        border-radius: 8px;
    }

    .info-label {
        display: block;
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        display: block;
        font-weight: 600;
        color: var(--text-main);
    }

    /* Form Styles */
    .form-label-custom {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 10px;
        display: block;
    }

    .input-custom {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #eee;
        border-radius: 8px;
        background: #fafafa;
        transition: 0.3s;
    }

    .input-custom:focus {
        outline: none;
        border-color: var(--primary);
        background: #fff;
    }

    .total-box-highlight {
        background: #fdfaf3;
        border: 1px dashed var(--primary);
        padding: 20px;
        border-radius: 10px;
        margin-top: 25px;
        text-align: center;
    }

    /* Nút bấm đồng bộ Profile */
    .btn-group-booking {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-confirm {
        background: var(--primary);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-confirm:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: #fff;
        color: var(--text-main);
        border: 1px solid #eee;
        padding: 15px;
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background: #f8f9fa;
    }

    @media (max-width: 900px) {
        .booking-wrapper { flex-direction: column; }
        .room-sidebar { flex: none; width: 100%; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="booking-page">
    <div class="booking-container">
        <div class="page-header">
            <h2 class="section-title">XÁC NHẬN ĐẶT PHÒNG</h2>
        </div>

        <div class="booking-wrapper">
            <div class="room-sidebar">
                <img src="<?= !empty($room['image']) ? URLROOT . '/img/' . $room['image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=60' ?>" 
                     class="room-image-circle" alt="Room">
                <h3>Phòng <?= htmlspecialchars($room['room_number']) ?></h3>
                <span class="badge-status">Sẵn sàng phục vụ</span>
                
                <div style="margin-top: 25px; text-align: left;">
                    <div class="info-item" style="margin-bottom: 10px; border: none; background: transparent; padding: 0;">
                        <i class="fa-solid fa-tag"></i>
                        <div>
                            <span class="info-label">Giá mỗi đêm</span>
                            <span class="info-value" style="color: #c0392b; font-size: 18px;"><?= number_format($room['price']) ?> VNĐ</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-main-content">
                <h4 style="margin-bottom: 25px; font-weight: 700;">Thông tin phòng</h4>
                
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fa-solid fa-bed"></i>
                        <div>
                            <span class="info-label">Loại phòng</span>
                            <span class="info-value"><?= htmlspecialchars($room['room_type_name'] ?? 'Standard Room') ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fa-solid fa-expand"></i>
                        <div>
                            <span class="info-label">Diện tích</span>
                            <span class="info-value">35 m²</span>
                        </div>
                    </div>
                </div>

                <h4 style="margin-bottom: 20px; font-weight: 700;">Thời gian lưu trú</h4>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Ngày nhận phòng</label>
                            <input type="date" name="check_in" id="check_in" class="input-custom" 
                                   min="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Ngày trả phòng</label>
                            <input type="date" name="check_out" id="check_out" class="input-custom"
                                    min="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="total-box-highlight">
                        <span class="info-label">Tổng tiền tạm tính</span>
                        <div id="display-total" style="font-size: 28px; font-weight: 700; color: var(--primary); margin: 5px 0;">
                            <?= number_format($room['price']) ?> VNĐ
                        </div>
                        <small class="text-muted"><i class="fa-solid fa-circle-info"></i> Thanh toán trực tiếp khi nhận phòng</small>
                    </div>

                    <div class="btn-group-booking">
                        <a href="javascript:history.back()" class="btn-cancel">HỦY BỎ</a>
                        <button type="submit" class="btn-confirm">
                            <i class="fa-solid fa-check-circle"></i> XÁC NHẬN ĐẶT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const pricePerNight = <?= (int)$room['price'] ?>;
    const cIn = document.getElementById('check_in');
    const cOut = document.getElementById('check_out');
    const totalDisplay = document.getElementById('display-total');

    function calculateTotal() {
        if (cIn.value && cOut.value) {
            const d1 = new Date(cIn.value);
            const d2 = new Date(cOut.value);
            if (d2 > d1) {
                const diffTime = Math.abs(d2 - d1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const total = diffDays * pricePerNight;
                totalDisplay.innerText = total.toLocaleString('vi-VN') + " VNĐ";
            } else {
                totalDisplay.innerText = pricePerNight.toLocaleString('vi-VN') + " VNĐ";
            }
        }
    }
    cIn.onchange = calculateTotal;
    cOut.onchange = calculateTotal;
</script>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layoutprofile.php';
?>