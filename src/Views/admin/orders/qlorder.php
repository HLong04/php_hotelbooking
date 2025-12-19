<?php ob_start(); ?>

<div class="card">
    <div class="card-header">
        <h3>Quản lý Đơn đặt phòng</h3>
    </div>
    
    <div class="card-body">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <?= $_SESSION['flash_message']; unset($_SESSION['flash_message']); ?>
            </div>
        <?php endif; ?>

        <table width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px;">Mã Đơn</th>
                    <th style="padding: 12px;">Khách hàng</th>
                    <th style="padding: 12px;">Phòng</th>
                    <th style="padding: 12px;">Check-in / Out</th>
                    <th style="padding: 12px;">Tổng tiền</th>
                    <th style="padding: 12px;">Trạng thái</th>
                    <th style="padding: 12px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">#<?= $order['id'] ?></td>
                            <td style="padding: 12px;">
                                <strong><?= $order['full_name'] ?></strong><br>
                                <small><?= $order['email'] ?></small>
                            </td>
                            <td style="padding: 12px; font-weight: bold; color: #2c3e50;">
                                <?= $order['room_number'] ?>
                            </td>
                            <td style="padding: 12px; font-size: 0.9em;">
                                In: <?= date('d/m/Y', strtotime($order['check_in'])) ?><br>
                                Out: <?= date('d/m/Y', strtotime($order['check_out'])) ?>
                            </td>
                            <td style="padding: 12px; color: #e74c3c; font-weight: bold;">
                                <?= number_format($order['total_price']) ?>đ
                            </td>
                            <td style="padding: 12px;">
                                <?php 
                                    $statusColor = '#f1c40f'; // Vàng (Pending)
                                    if($order['status'] == 'Confirmed') $statusColor = '#27ae60'; // Xanh (Confirmed)
                                    if($order['status'] == 'Cancelled') $statusColor = '#e74c3c'; // Đỏ (Cancelled)
                                    if($order['status'] == 'Completed') $statusColor = '#2980b9'; // Xanh dương (Completed)
                                ?>
                                <span style="background: <?= $statusColor ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8em;">
                                    <?= $order['status'] ?>
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <a href="/admin/orders/detail/<?= $order['id'] ?>" style="color: #3498db; margin-right: 10px;">
                                    <i class="fa-solid fa-eye"></i> Chi tiết
                                </a>
                                <a href="/admin/orders/delete/<?= $order['id'] ?>" onclick="return confirm('Xóa đơn này?');" style="color: #e74c3c;">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Chưa có đơn đặt phòng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php'; 
?>