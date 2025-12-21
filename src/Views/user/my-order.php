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
?>

<style>
    /* CSS Riêng cho trang Lịch sử đơn hàng */
    .page-header-min {
        background: linear-gradient(rgba(12, 16, 22, 0.8), rgba(12, 16, 22, 0.8)), url('/img/bg-header.jpg');
        background-size: cover;
        background-position: center;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 40px;
    }

    .order-container {
        background: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 50px;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-custom th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #ddd;
    }

    .table-custom td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
        color: #555;
    }

    .table-custom tr:hover {
        background-color: #fcfcfc;
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

    /* Date Display Styles - Đơn giản */
    .date-container {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .date-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .date-item i {
        color: var(--primary);
        font-size: 1rem;
    }
    
    .date-item.check-out i {
        color: #e74c3c;
    }
    
    .date-text {
        color: #333;
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .date-separator {
        color: #ccc;
        font-size: 1.2rem;
        font-weight: 300;
        margin: 0 4px;
    }

    .btn-action-view {
        color: var(--primary);
        font-weight: 600;
        margin-right: 10px;
        border: 1px solid var(--primary);
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .btn-action-view:hover {
        background: var(--primary);
        color: #fff;
    }

    .btn-action-cancel {
        color: #fff;
        background: #e74c3c;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        border: 1px solid #e74c3c;
        padding: 5px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    .btn-action-cancel:hover {
        background: #c0392b;
        border-color: #c0392b;
    }
</style>

<div class="page-header-min">
    <div class="container">
        <h2 style="font-family: 'Playfair Display', serif; color: var(--primary); font-size: 2.5rem;">Lịch sử đặt phòng</h2>
        <p style="color: #aaa;">Quản lý các chuyến đi của bạn</p>
    </div>
</div>

<div class="container">
    <div class="order-container">
        <?php if (empty($bookings)): ?>
            <div style="text-align: center; padding: 40px;">
                <i class="fa-regular fa-calendar-xmark" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                <p>Bạn chưa có đơn đặt phòng nào.</p>
                <a href="/rooms" style="color: var(--primary); font-weight: bold; text-decoration: underline;">Đặt phòng ngay</a>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Thông tin phòng</th>
                            <th>Ngày nhận - Trả</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><strong>#<?= $booking['id'] ?></strong></td>
                                
                                <td>
                                    <div style="font-weight: 600; color: #333;">
                                        <?= htmlspecialchars($booking['room_type_name'] ?? 'Phòng') ?>
                                    </div>
                                    <div style="font-size: 0.85rem; color: #888;">
                                        Phòng số: <?= $booking['room_number'] ?? 'Chưa xếp' ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="date-container">
                                        <div class="date-item check-in">
                                            <i class="fa-solid fa-calendar-check"></i>
                                            <span class="date-text"><?= date('d/m/Y', strtotime($booking['check_in'])) ?></span>
                                        </div>
                                        <span class="date-separator">→</span>
                                        <div class="date-item check-out">
                                            <i class="fa-solid fa-calendar-xmark"></i>
                                            <span class="date-text"><?= date('d/m/Y', strtotime($booking['check_out'])) ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td style="color: #e74c3c; font-weight: bold;">
                                    <?= number_format($booking['total_price']) ?> VNĐ
                                </td>

                                <td>
                                    <?= getStatusBadge($booking['status']) ?>
                                </td>

                                <td>
                                    <a href="/myorders/detail/<?= $booking['id'] ?>" class="btn-action-view">
                                        <i class="fa-solid fa-eye"></i> Chi tiết
                                    </a>

                                    <?php if ($booking['status'] == 'pending'): ?>
                                        <a href="/booking/cancel/<?= $booking['id'] ?>" 
                                           class="btn-action-cancel"
                                           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt phòng này không?');">
                                           <i class="fa-solid fa-xmark"></i> Hủy đơn
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
// Include layout
$layoutPath = __DIR__ . '/../layouthome.php'; 
if (!file_exists($layoutPath)) {
    // Thử đường dẫn khác nếu cấu trúc thư mục khác
    $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/templates/layouthome.php';
}
if (file_exists($layoutPath)) {
    include $layoutPath;
} else {
    echo $content;
}
?>