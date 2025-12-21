<?php ob_start(); ?>

<div style="display: flex; gap: 20px;">
    
    <div class="card" style="flex: 2;">
        <div class="card-header">
            <h3>Chi tiết đơn hàng #<?= $order['id'] ?></h3>
        </div>
        <div class="card-body">
            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Thông tin khách hàng</h4>
            <p><strong>Họ tên:</strong> <?= $order['full_name'] ?></p>
            <p><strong>Email:</strong> <?= $order['email'] ?></p>
            <p><strong>SĐT:</strong> <?= $order['phone'] ?></p>

            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; margin-top: 20px;">Thông tin đặt phòng</h4>
            <p><strong>Phòng số:</strong> <span style="font-size: 1.2em; font-weight: bold; color: #2c3e50;"><?= $order['room_number'] ?></span></p>
            <p><strong>Ngày nhận phòng:</strong> <?= date('d/m/Y', strtotime($order['check_in'])) ?></p>
            <p><strong>Ngày trả phòng:</strong> <?= date('d/m/Y', strtotime($order['check_out'])) ?></p>
            <p><strong>Ngày tạo đơn:</strong> <?= $order['created_at'] ?></p>
            
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
                <strong>Tổng tiền thanh toán:</strong> 
                <span style="font-size: 1.5em; color: #e74c3c; font-weight: bold; margin-left: 10px;">
                    <?= number_format($order['total_price']) ?> VNĐ
                </span>
            </div>
        </div>
    </div>

    <div class="card" style="flex: 1; height: fit-content;">
        <div class="card-header">
            <h3>Trạng thái đơn</h3>
        </div>
        <div class="card-body">
            
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div style="color: green; margin-bottom: 10px;">
                    <?= $_SESSION['flash_message']; unset($_SESSION['flash_message']); ?>
                </div>
            <?php endif; ?>

            <?php 
                // Kiểm tra xem đơn hàng đã kết thúc chưa (Completed hoặc Cancelled)
                // Dùng strtolower để đảm bảo không bị lỗi chữ hoa/thường
                $stt = strtolower($order['status']);
                $is_finished = ($stt == 'completed' || $stt == 'cancelled');
            ?>

            <form action="/admin/orders/status/<?= $order['id'] ?>" method="POST">
                <label style="display: block; margin-bottom: 10px;">Cập nhật trạng thái:</label>
                
                <select name="status" <?= $is_finished ? 'disabled' : '' ?> style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 15px; background-color: <?= $is_finished ? '#f0f0f0' : '#fff' ?>;">
                    <option value="pending" <?= $stt == 'pending' ? 'selected' : '' ?>>Pending (Chờ duyệt)</option>
                    <option value="confirmed" <?= $stt == 'confirmed' ? 'selected' : '' ?>>Confirmed (Đã xác nhận)</option>
                    <option value="completed" <?= $stt == 'completed' ? 'selected' : '' ?>>Completed (Đã trả phòng)</option>
                    <option value="cancelled" <?= $stt == 'cancelled' ? 'selected' : '' ?>>Cancelled (Hủy bỏ)</option>
                </select>
                
                <?php if (!$is_finished): ?>
                    <button type="submit" style="width: 100%; background: #2c3e50; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer;">
                        Cập nhật
                    </button>
                <?php else: ?>
                    <div style="width: 100%; background: #eee; color: #777; padding: 10px; border: none; border-radius: 4px; text-align: center;">
                        Đơn hàng đã đóng, không thể chỉnh sửa
                    </div>
                <?php endif; ?>
            </form>

            <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                <a href="/admin/orders" style="text-decoration: none; color: #666;">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php'; 
?>