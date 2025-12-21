<?php ob_start(); ?>

<style>
    /* CSS cho thanh tìm kiếm */
    .search-bar {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        border: 1px solid #ddd;
    }

    .form-control {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        outline: none;
    }

    .btn-search {
        background: #cda45e;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-search:hover {
        background: #b38b45;
    }

    .btn-reset {
        text-decoration: none;
        color: #666;
        padding: 10px 15px;
        display: flex;
        align-items: center;
    }
</style>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Quản lý Phòng</h3>
        <a href="/admin/rooms/create" class="btn-add" style="background: #2c3e50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            <i class="fa-solid fa-plus"></i> Thêm phòng mới
        </a>
    </div>

    <div class="card-body">

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
                                $statusColor = 'green';
                                $statusText = 'Trống';

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
                        <td colspan="5" style="text-align: center; padding: 20px; color: #999;">Không tìm thấy phòng nào phù hợp.</td>
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