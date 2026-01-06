<?php ob_start(); ?>

<style>
    .review-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .review-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #eee;
    }

    .review-header {
        background: #2c3e50;
        color: #fff;
        padding: 30px;
        text-align: center;
    }

    .review-header h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: #cda45e;
    }

    .review-body {
        padding: 40px;
    }

    .booking-info-mini {
        background: #f9f9f9;
        padding: 15px 20px;
        border-left: 4px solid #cda45e;
        border-radius: 4px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .rating-wrapper {
        margin-bottom: 25px;
    }

    .label-custom {
        display: block;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .select-custom, .textarea-custom {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
    }

    .select-custom:focus, .textarea-custom:focus {
        border-color: #cda45e;
        outline: none;
        box-shadow: 0 0 0 3px rgba(205, 164, 94, 0.1);
    }

    .star-select {
        color: #f1c40f;
        font-weight: bold;
    }

    .btn-submit-review {
        background: #cda45e;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        display: inline-block;
        text-align: center;
        margin-top: 10px;
    }

    .btn-submit-review:hover {
        background: #b38b45;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(205, 164, 94, 0.3);
    }

    .btn-back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #777;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-back-link:hover {
        color: #cda45e;
    }
</style>

<div class="review-container">
    <div class="review-card">
        <div class="review-header">
            <h4>ĐÁNH GIÁ TRẢI NGHIỆM</h4>
            <p style="margin:0; opacity: 0.8; font-weight: 300;">Chia sẻ cảm nhận của bạn về kỳ nghỉ tại LuxStay</p>
        </div>

        <div class="review-body">
            <div class="booking-info-mini">
                <div>
                    <span style="color: #777; font-size: 0.9rem;">Mã đơn phòng:</span>
                    <strong style="color: #2c3e50;">#<?= $booking['id'] ?></strong>
                </div>
                <div>
                    <span style="color: #777; font-size: 0.9rem;">Loại phòng:</span>
                    <strong style="color: #cda45e;"><?= htmlspecialchars($booking['room_type_name'] ?? 'Phòng Suite') ?></strong>
                </div>
            </div>

            <form action="/reviews/store" method="POST">
                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

                <div class="rating-wrapper">
                    <label class="label-custom"><i class="fa-solid fa-star-half-stroke"></i> Mức độ hài lòng của bạn</label>
                    <select name="rating" class="select-custom star-select" required>
                        <option value="5">⭐⭐⭐⭐⭐ - Tuyệt vời (5/5)</option>
                        <option value="4">⭐⭐⭐⭐ - Rất tốt (4/5)</option>
                        <option value="3" selected>⭐⭐⭐ - Bình thường (3/5)</option>
                        <option value="2">⭐⭐ - Tệ (2/5)</option>
                        <option value="1">⭐ - Rất tệ (1/5)</option>
                    </select>
                </div>

                <div class="rating-wrapper">
                    <label class="label-custom"><i class="fa-solid fa-pen-nib"></i> Nhận xét chi tiết</label>
                    <textarea name="comment" class="textarea-custom" rows="5" 
                        placeholder="Hãy chia sẻ cảm nhận về không gian phòng, chất lượng phục vụ và tiện ích..." required></textarea>
                </div>

                <button type="submit" class="btn-submit-review">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> GỬI ĐÁNH GIÁ NGAY
                </button>
                
                <a href="/myorders" class="btn-back-link">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại lịch sử đặt phòng
                </a>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layoutprofile.php';
?>