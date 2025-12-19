<?php ob_start(); ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3>Cập Nhật Phòng: <?= $room['room_number'] ?></h3>
    </div>
    <div class="card-body">
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?= $error ?></div>
        <?php endif; ?>

        <form action="/admin/rooms/update/<?= $room['id'] ?>" method="POST">
            <div style="margin-bottom: 15px;">
                <label>Số phòng:</label>
                <input type="text" name="room_number" value="<?= $room['room_number'] ?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Loại phòng:</label>
                <select name="room_type_id" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <?php foreach ($roomTypes as $type): ?>
                        <option value="<?= $type['id'] ?>" <?= $type['id'] == $room['room_type_id'] ? 'selected' : '' ?>>
                            <?= $type['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Trạng thái:</label>
                <select name="status" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="Available" <?= $room['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                    <option value="Occupied" <?= $room['status'] == 'Occupied' ? 'selected' : '' ?>>Occupied</option>
                    <option value="Maintenance" <?= $room['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                </select>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" style="background: #2980b9; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Cập nhật</button>
                <a href="/admin/rooms" style="margin-left: 10px; color: #666; text-decoration: none;">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php'; 
?>