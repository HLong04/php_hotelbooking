<?php ob_start(); ?>


<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Quản lý Phòng</h3>
        <a href="/admin/rooms/create" class="btn-add" style="background: #2c3e50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            <i class="fa-solid fa-plus"></i> Thêm phòng mới
        </a>
    </div>

    <div class="card-body " style="margin-top: 20px;">
        <form action="" method="GET" class="search-bar ">
            <input type="text" name="keyword" class="form-control" style="flex: 1;"
                placeholder="Nhập ID hoặc Số phòng..."
                value="<?= htmlspecialchars($keyword ?? '') ?>">

            <select name="status" class="form-control" style="width: 200px;">
                <option value="">-- Tất cả trạng --</tháioption>
                <option value="available" <?= (isset($status) && $status == 'available') ? 'selected' : '' ?>>Phòng Trống (Available)</option>
                <option value="booked" <?= (isset($status) && $status == 'booked') ? 'selected' : '' ?>>Có khách (Booked)</option>
                <option value="maintenance" <?= (isset($status) && $status == 'maintenance') ? 'selected' : '' ?>>Bảo trì</option>
            </select>

            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
            <?php if (!empty($keyword) || !empty($status)): ?>
                <a href="/admin/rooms" class="btn-reset"><i class="fa-solid fa-rotate-left"></i> Đặt lại</a>
            <?php endif; ?>
        </form>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <?= $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); ?>
            </div>
        <?php endif; ?>

        <table width="100%" style="border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Số phòng</th>
                    <th style="padding: 12px;">Loại phòng</th>
                    <th style="padding: 12px;">Trạng thái</th>
                    <th style="padding: 12px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">#<?= $room['id'] ?></td>
                            <td style="padding: 12px; font-weight: bold; color: #2c3e50;"><?= $room['room_number'] ?></td>
                            <td style="padding: 12px;"><?= isset($room['room_type_name']) ? $room['room_type_name'] : $room['room_type_id'] ?></td>
                            <td style="padding: 12px;">
                                <?php
                                $statusColor = 'gray';
                                $statusText = $room['status'];
                                if ($room['status'] == 'available') {
                                    $statusColor = '#27ae60';
                                    $statusText = 'Trống';
                                }
                                if ($room['status'] == 'booked') {
                                    $statusColor = '#c0392b';
                                    $statusText = 'Có khách';
                                }
                                if ($room['status'] == 'maintenance') {
                                    $statusColor = '#f39c12';
                                    $statusText = 'Bảo trì';
                                }
                                ?>
                                <span style="color: <?= $statusColor ?>; font-weight: 700;">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <a href="/admin/rooms/update/<?= $room['id'] ?>" style="color: #3498db; margin-right: 10px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="/admin/rooms/delete/<?= $room['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa phòng này?');" style="color: #e74c3c;"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Không tìm thấy phòng nào phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1): ?>
            <ul class="pagination">
                <?php if ($current_page > 1): ?>
                    <li>
                        <a href="?page=<?= $current_page - 1 ?>&keyword=<?= $keyword ?>&status=<?= $status ?>">« Trước</a>
                    </li>
                <?php else: ?>
                    <li class="disabled"><span>« Trước</span></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?= ($i == $current_page) ? 'active' : '' ?>">
                        <?php if ($i == $current_page): ?>
                            <span><?= $i ?></span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?>&keyword=<?= $keyword ?>&status=<?= $status ?>"><?= $i ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li>
                        <a href="?page=<?= $current_page + 1 ?>&keyword=<?= $keyword ?>&status=<?= $status ?>">Sau »</a>
                    </li>
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