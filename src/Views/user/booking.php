<?php ob_start(); ?>

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
                        <a href="/myorders" class="btn-cancel">HỦY BỎ</a>
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