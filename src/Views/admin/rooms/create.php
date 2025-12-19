<?php ob_start(); ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3>Thêm Phòng Mới</h3>
    </div>
    <div class="card-body">
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?= $error ?></div>
        <?php endif; ?>

        <form action="/admin/rooms/create" method="POST">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Số phòng:</label>
                <input type="text" name="room_number" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Loại phòng:</label>
                <select name="room_type_id" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <?php foreach ($roomTypes as $type): ?>
                        <option value="<?= $type['id'] ?>"><?= $type['name'] ?> (<?= number_format($type['price']) ?>đ)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Trạng thái:</label>
                <select name="status" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="Available">Available (Trống)</option>
                    <option value="Occupied">Occupied (Đang có khách)</option>
                    <option value="Maintenance">Maintenance (Bảo trì)</option>
                </select>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" style="background: #2c3e50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Lưu lại</button>
                <a href="/admin/rooms" style="margin-left: 10px; color: #666; text-decoration: none;">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php'; 
?>