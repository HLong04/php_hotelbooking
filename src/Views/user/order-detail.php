<?php 

ob_start(); 

function getStatusBadge($status) {
    switch ($status) {
        case 'pending':
            return '<span class="badge badge-warning">Đang chờ duyệt</span>';
        case 'confirmed':
            return '<span class="badge badge-success">Đã xác nhận</span>';
        case 'completed':
            return '<span class="badge badge-info">Đã hoàn thành</span>';
        case 'cancelled':
            return '<span class="badge badge-danger">Đã hủy</span>';
        default:
            return '<span class="badge badge-secondary">' . $status . '</span>';
    }
}

// Tính số đêm
$checkIn = new DateTime($booking['check_in']);
$checkOut = new DateTime($booking['check_out']);
$nights = $checkOut->diff($checkIn)->days;
?>

<style>
    .page-header-min {
        background: linear-gradient(rgba(12, 16, 22, 0.8), rgba(12, 16, 22, 0.8)), url('/img/bg-header.jpg');
        background-size: cover;
        background-position: center;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 40px;
    }

    .detail-container {
        background: #fff;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 50px;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 30px;
    }

    .detail-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
    }

    .booking-code {
        color: var(--primary);
        font-weight: 600;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
    .badge-success { background-color: #d4edda; color: #155724; border: 1px solid #a8e6cf; }
    .badge-danger  { background-color: #f8d7da; color: #721c24; border: 1px solid #ff9999; }
    .badge-info    { background-color: #d1ecf1; color: #0c5460; border: 1px solid #74b9ff; }
    .badge-secondary { background-color: #e2e3e5; color: #383d41; border: 1px solid #b2bec3; }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .detail-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 8px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary);
        font-size: 1.2rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #666;
        font-weight: 500;
    }

    .info-value {
        color: #333;
        font-weight: 600;
    }

    .price-summary {
        background: #fff;
        border: 2px solid var(--primary);
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-size: 0.95rem;
        color: #333;
        border-bottom: 1px solid #f0f0f0;
    }

    .price-row:last-of-type {
        border-bottom: 2px solid #f0f0f0;
    }

    .price-total {
        display: flex;
        justify-content: space-between;
        padding-top: 20px;
        margin-top: 15px;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary);
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
    }

    .btn-back {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #ddd;
    }

    .btn-back:hover {
        background: #e9ecef;
    }

    .btn-cancel {
        background: #e74c3c;
        color: white;
        border: 1px solid #e74c3c;
    }

    .btn-cancel:hover {
        background: #c0392b;
        border-color: #c0392b;
    }

    .btn-print {
        background: var(--primary);
        color: white;
        border: 1px solid var(--primary);
    }

    .btn-print:hover {
        opacity: 0.9;
    }

    .btn-checkout {
        background: #27ae60;
        color: white;
        border: 1px solid #27ae60;
    }

    .btn-checkout:hover {
        background: #229954;
        border-color: #229954;
    }

    .date-display {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .date-display i {
        color: var(--primary);
    }

    .note-box {
        background: #fff9e6;
        border-left: 4px solid #ffc107;
        padding: 20px;
        border-radius: 6px;
        margin-bottom: 30px;
    }

    .note-box i {
        color: #ffc107;
        margin-right: 10px;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-header-min">
    <div class="container">
        <h2 style="font-family: 'Playfair Display', serif; color: var(--primary); font-size: 2.5rem;">Chi tiết đơn đặt phòng</h2>
        <p style="color: #aaa;">Thông tin chi tiết về đơn đặt phòng của bạn</p>
    </div>
</div>

<div class="container">
    <div class="detail-container">
        <!-- Header -->
        <div class="detail-header">
            <div>
                <div class="detail-title">Đơn đặt phòng <span class="booking-code">#<?= $booking['id'] ?></span></div>
                <p style="color: #888; margin-top: 8px;">Đặt ngày: <?= date('d/m/Y H:i', strtotime($booking['created_at'] ?? 'now')) ?></p>
            </div>
            <div>
                <?= getStatusBadge($booking['status']) ?>
            </div>
        </div>

        <!-- Thông tin khách hàng & Thông tin phòng -->
        <div class="detail-grid">
            <div class="detail-section">
                <div class="section-title">
                    <i class="fa-solid fa-user"></i>
                    Thông tin khách hàng
                </div>
                <div class="info-row">
                    <span class="info-label">Họ tên:</span>
                    <span class="info-value"><?= htmlspecialchars($booking['guest_name'] ?? 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?= htmlspecialchars($booking['guest_email'] ?? 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-value"><?= htmlspecialchars($booking['guest_phone'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div class="detail-section">
                <div class="section-title">
                    <i class="fa-solid fa-bed"></i>
                    Thông tin phòng
                </div>
                <div class="info-row">
                    <span class="info-label">Loại phòng:</span>
                    <span class="info-value"><?= htmlspecialchars($booking['room_type_name'] ?? 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số phòng:</span>
                    <span class="info-value"><?= $booking['room_number'] ?? 'Chưa xếp phòng' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số người:</span>
                    <span class="info-value"><?= $booking['guests'] ?? 1 ?> người</span>
                </div>
            </div>
        </div>

        <!-- Thời gian lưu trú -->
        <div class="detail-section" style="margin-bottom: 30px;">
            <div class="section-title">
                <i class="fa-solid fa-calendar-days"></i>
                Thời gian lưu trú
            </div>
            <div class="info-row">
                <span class="info-label">
                    <div class="date-display">
                        <i class="fa-solid fa-calendar-check"></i>
                        Ngày nhận phòng:
                    </div>
                </span>
                <span class="info-value"><?= date('d/m/Y', strtotime($booking['check_in'])) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">
                    <div class="date-display">
                        <i class="fa-solid fa-calendar-xmark"></i>
                        Ngày trả phòng:
                    </div>
                </span>
                <span class="info-value"><?= date('d/m/Y', strtotime($booking['check_out'])) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Số đêm:</span>
                <span class="info-value"><?= $nights ?> đêm</span>
            </div>
        </div>

        <!-- Tổng chi phí -->
        <div class="price-summary">
            <div class="section-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-receipt"></i>
                Chi tiết thanh toán
            </div>
            <div class="price-row">
                <span>Giá phòng x <?= $nights ?> đêm:</span>
                <span><?= number_format($booking['total_price']) ?> VNĐ</span>
            </div>
            <?php if (!empty($booking['discount'])): ?>
            <div class="price-row">
                <span>Giảm giá:</span>
                <span style="color: #e74c3c;">-<?= number_format($booking['discount']) ?> VNĐ</span>
            </div>
            <?php endif; ?>
            <div class="price-total">
                <span>Tổng thanh toán:</span>
                <span><?= number_format($booking['total_price']) ?> VNĐ</span>
            </div>
        </div>

        <!-- Ghi chú -->
        <?php if (!empty($booking['notes'])): ?>
        <div class="note-box">
            <i class="fa-solid fa-circle-info"></i>
            <strong>Ghi chú:</strong> <?= htmlspecialchars($booking['notes']) ?>
        </div>
        <?php endif; ?>

        <!-- Nút hành động -->
        <div class="action-buttons">
            <a href="/myorders" class="btn btn-back">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại
            </a>
            
            <?php if ($booking['status'] == 'pending'): ?>
            <button onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt phòng này không?') && (window.location.href='/booking/cancel/<?= $booking['id'] ?>')" 
                    class="btn btn-cancel">
                <i class="fa-solid fa-xmark"></i>
                Hủy đơn hàng
            </button>
            <?php endif; ?>
            
            <?php if ($booking['status'] == 'confirmed'): ?>
            <button onclick="return confirm('Xác nhận checkout?') && (window.location.href='/booking/checkout/<?= $booking['id'] ?>')" 
                    class="btn btn-checkout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Checkout
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
// Include layout
$layoutPath = __DIR__ . '/../layoutprofile.php'; 
if (!file_exists($layoutPath)) {
    $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/templates/layoutprofile.php';
}
if (file_exists($layoutPath)) {
    include $layoutPath;
} else {
    echo $content;
}
?>