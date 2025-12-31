<?php ob_start(); ?>

<style>
    /* CSS cho phần Upload và QR Code */
    .payment-section {
        background: #fdfdfd;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 25px;
        margin-top: 30px;
    }
    
    .payment-title {
        font-family: 'Playfair Display', serif;
        color: #2c3e50;
        border-bottom: 2px solid #cda45e;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .qr-box {
        text-align: center;
        background: #fff;
        padding: 15px;
        border: 1px dashed #cda45e;
        border-radius: 10px;
    }

    .vip-alert {
        background: linear-gradient(135deg, #fff3cd 0%, #ffecb3 100%);
        color: #856404;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
        border: 1px solid #ffeeba;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
        color: #666;
    }
    
    .price-row.final {
        font-size: 20px;
        font-weight: 700;
        color: #c0392b;
        border-top: 1px dashed #ddd;
        padding-top: 10px;
        margin-top: 10px;
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
                            <span class="info-label">Giá niêm yết</span>
                            <span class="info-value" style="color: #c0392b; font-size: 18px;"><?= number_format($room['price']) ?> VNĐ/đêm</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-main-content">
                <form method="POST" enctype="multipart/form-data">
                    
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

                    <h4 style="margin-bottom: 20px; font-weight: 700; margin-top: 30px;">Thời gian lưu trú</h4>
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

                    <div class="payment-section">
                        <h4 class="payment-title"><i class="fa-solid fa-credit-card"></i> Thanh toán & Đặt cọc</h4>
                        
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <div class="qr-box">
                                    <p style="font-size: 13px; color: #666; margin-bottom: 5px;">Quét mã để cọc tiền</p>
                                    <img src="https://img.vietqr.io/image/MB-0000000000-compact2.jpg?amount=0&addInfo=DATPHONG%20KHACHSAN&accountName=KHACH%20SAN" 
                                         alt="QR Thanh Toán" style="width: 100%; max-width: 180px;">
                                    <p style="font-weight: bold; margin-top: 10px; color: #2c3e50;">MB Bank: 0000000000</p>
                                    <p style="font-size: 12px;">Chủ TK: NGUYEN VAN A</p>
                                </div>
                            </div>

                            <div class="col-md-7 mb-3">
                                <?php if(isset($user['rank_level']) && $user['rank_level'] != 'standard'): ?>
                                    <div class="vip-alert">
                                        <i class="fa-solid fa-crown" style="font-size: 20px; color: #b38b45;"></i>
                                        <div>
                                            <strong>Thành viên <?= strtoupper($user['rank_level']) ?></strong><br>
                                            <span style="font-size: 13px;">Bạn được giảm <strong><?= ($user['rank_level'] == 'vip') ? '5%' : '10%' ?></strong> tổng hóa đơn.</span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <div class="total-box-highlight" style="margin-top: 20px; background: #fff; border: 1px solid #cda45e;">
                        <div class="price-row">
                            <span>Đơn giá:</span>
                            <span><?= number_format($room['price']) ?> đ x <span id="num-days">0</span> đêm</span>
                        </div>
                        
                        <div class="price-row" id="row-discount" style="display: none; color: #27ae60;">
                            <span>Ưu đãi thành viên (<?= isset($user['rank_level']) ? strtoupper($user['rank_level']) : '' ?>):</span>
                            <span>- <span id="discount-amount">0</span> đ</span>
                        </div>

                        <div class="price-row final">
                            <span>TỔNG CỘNG:</span>
                            <span id="display-total">0 VNĐ</span>
                        </div>

                        <div class="price-row" style="margin-top: 10px; font-weight: bold; color: #2c3e50; border-top: 1px solid #eee; padding-top: 10px;">
                            <span>Cần đặt cọc (30%):</span>
                            <span id="deposit-display">0 VNĐ</span>
                        </div>
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
    // Lấy hạng thành viên từ PHP (nếu chưa login thì mặc định standard)
    const userRank = "<?= isset($user['rank_level']) ? $user['rank_level'] : 'standard' ?>";
    
    const cIn = document.getElementById('check_in');
    const cOut = document.getElementById('check_out');
    
    // Các phần tử hiển thị giá
    const numDaysEl = document.getElementById('num-days');
    const totalDisplay = document.getElementById('display-total');
    const rowDiscount = document.getElementById('row-discount');
    const discountAmountEl = document.getElementById('discount-amount');
    const depositDisplay = document.getElementById('deposit-display');

    function calculateTotal() {
        if (cIn.value && cOut.value) {
            const d1 = new Date(cIn.value);
            const d2 = new Date(cOut.value);
            
            if (d2 > d1) {
                // 1. Tính số ngày
                const diffTime = Math.abs(d2 - d1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                numDaysEl.innerText = diffDays;

                // 2. Tính tổng gốc
                let total = diffDays * pricePerNight;

                // 3. Tính giảm giá VIP
                let discountRate = 0;
                if(userRank === 'vip') discountRate = 0.05;      // 5%
                if(userRank === 'diamond') discountRate = 0.10;  // 10%

                let discountMoney = total * discountRate;
                let finalPrice = total - discountMoney;

                // 4. Tính tiền cọc (30%)
                let depositMoney = finalPrice * 0.3;

                // 5. Hiển thị lên giao diện
                // - Nếu có giảm giá thì hiện dòng giảm giá
                if(discountRate > 0) {
                    rowDiscount.style.display = 'flex';
                    discountAmountEl.innerText = discountMoney.toLocaleString('vi-VN');
                } else {
                    rowDiscount.style.display = 'none';
                }

                totalDisplay.innerText = finalPrice.toLocaleString('vi-VN') + " VNĐ";
                depositDisplay.innerText = depositMoney.toLocaleString('vi-VN') + " VNĐ";
                
            } else {
                // Reset nếu chọn ngày sai
                totalDisplay.innerText = "0 VNĐ";
                depositDisplay.innerText = "0 VNĐ";
                numDaysEl.innerText = "0";
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