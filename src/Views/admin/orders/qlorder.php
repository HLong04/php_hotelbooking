<?php ob_start(); ?>

<style>
    /* 1. CSS CHO THANH TÌM KIẾM (Giống trang Room) */
    .search-bar {
        background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;
        display: flex; gap: 15px; border: 1px solid #ddd; flex-wrap: wrap;
    }
    .form-control {
        padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; outline: none;
    }
    .btn-search {
        background: #cda45e; color: white; border: none; padding: 10px 20px;
        border-radius: 5px; cursor: pointer; font-weight: bold;
    }
    .btn-search:hover { background: #b38b45; }
    .btn-reset {
        text-decoration: none; color: #666; padding: 10px 15px; display: flex; align-items: center;
    }

    /* 2. CSS PHÂN TRANG (Giống trang Room) */
    .pagination {
        display: flex; justify-content: flex-end; list-style: none; padding: 0; margin-top: 20px; gap: 5px;
    }
    .pagination li a, .pagination li span {
        display: block; padding: 8px 14px; border: 1px solid #ddd; border-radius: 4px;
        text-decoration: none; color: #2c3e50; background: #fff; font-size: 14px;
    }
    .pagination li.active span {
        background-color: #cda45e; color: white; border-color: #cda45e;
    }
    .pagination li.disabled span { color: #ccc; cursor: not-allowed; }
</style>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Quản lý Đơn đặt phòng</h3>
        </div>
    
    <div class="card-body " style="margin-top: 20px;">

        <form action="" method="GET" class="search-bar">
            
            <input type="text" name="keyword" class="form-control" style="flex: 2;" 
                   placeholder="Mã đơn / Tên khách / Email..." 
                   value="<?= htmlspecialchars($keyword ?? '') ?>">
            
            <input type="text" name="room" class="form-control" style="width: 120px;" 
                   placeholder="Số phòng..." 
                   value="<?= htmlspecialchars($room ?? '') ?>">
            
            <input type="number" name="price" class="form-control" style="width: 150px;" 
                   placeholder="Tổng tiền >=" step="10000"
                   value="<?= htmlspecialchars($price ?? '') ?>">

            <select name="status" class="form-control" style="width: 180px;">
                <option value="">-- Trạng thái --</option>
                <option value="pending" <?= (isset($status) && $status == 'pending') ? 'selected' : '' ?>>Chờ duyệt</option>
                <option value="confirmed" <?= (isset($status) && $status == 'confirmed') ? 'selected' : '' ?>>Đã xác nhận</option>
                <option value="completed" <?= (isset($status) && $status == 'completed') ? 'selected' : '' ?>>Hoàn thành</option>
                <option value="cancelled" <?= (isset($status) && $status == 'cancelled') ? 'selected' : '' ?>>Đã hủy</option>
            </select>

            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
            <?php if(!empty($keyword) || !empty($room) || !empty($price) || !empty($status)): ?>
                <a href="/admin/orders" class="btn-reset">Đặt lại</a>
            <?php endif; ?>
        </form>

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
                    <th style="padding: 12px;">Thời gian</th>
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
                                <span style="font-size: 12px; color: #888;"><?= $order['email'] ?></span>
                            </td>
                            
                            <td style="padding: 12px; font-weight: bold; color: #2c3e50;">
                                <?= $order['room_number'] ?>
                            </td>
                            
                            <td style="padding: 12px; font-size: 13px;">
                                <?= date('d/m', strtotime($order['check_in'])) ?> - <?= date('d/m/Y', strtotime($order['check_out'])) ?>
                            </td>
                            
                            <td style="padding: 12px; color: #cda45e; font-weight: bold;">
                                <?= number_format($order['total_price']) ?> đ
                            </td>
                            
                            <td style="padding: 12px;">
                                <?php 
                                    $statusColor = 'gray'; $statusText = $order['status'];
                                    $st = strtolower($order['status']);
                                    
                                    if ($st == 'pending') { $statusColor = '#f39c12'; $statusText = 'Chờ duyệt'; }
                                    if ($st == 'confirmed') { $statusColor = '#27ae60'; $statusText = 'Đã xác nhận'; }
                                    if ($st == 'completed') { $statusColor = '#2980b9'; $statusText = 'Hoàn thành'; }
                                    if ($st == 'cancelled') { $statusColor = '#e74c3c'; $statusText = 'Đã hủy'; }
                                ?>
                                <span style="color: <?= $statusColor ?>; font-weight: 700;">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            
                            <td style="padding: 12px;">
                                <a href="/admin/orders/detail/<?= $order['id'] ?>" style="color: #3498db; margin-right: 10px;">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                
                                <?php if($st == 'cancelled' || $st == 'completed'): ?>
                                    <a href="/admin/orders/delete/<?= $order['id'] ?>" onclick="return confirm('Xóa đơn này?');" style="color: #e74c3c;">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Không tìm thấy đơn hàng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if (isset($total_pages) && $total_pages > 1): ?>
            <?php 
            // Tạo query string để giữ lại bộ lọc khi chuyển trang
            $query = "&keyword=" . urlencode($keyword ?? '') . 
                     "&room=" . urlencode($room ?? '') . 
                     "&price=" . urlencode($price ?? '') . 
                     "&status=" . urlencode($status ?? '');
            ?>
            <ul class="pagination">
                <?php if ($current_page > 1): ?>
                    <li><a href="?page=<?= $current_page - 1 ?><?= $query ?>">« Trước</a></li>
                <?php else: ?>
                    <li class="disabled"><span>« Trước</span></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?= ($i == $current_page) ? 'active' : '' ?>">
                        <a href="?page=<?= $i ?><?= $query ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li><a href="?page=<?= $current_page + 1 ?><?= $query ?>">Sau »</a></li>
                <?php else: ?>
                    <li class="disabled"><span>Sau »</span></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php'; 
?>