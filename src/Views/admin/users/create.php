<?php ob_start(); ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3>Thêm Người Dùng Mới</h3>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?= $error ?></div>
        <?php endif; ?>

        <form action="/admin/users/create" method="POST">
            <div style="margin-bottom: 15px;">
                <label>Họ và tên:</label>
                <input type="text" name="full_name" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Email:</label>
                <input type="email" name="email" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Số điện thoại:</label>
                <input type="text" name="phone" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Mật khẩu:</label>
                <input type="password" name="password" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Vai trò:</label>
                <select name="role" style="width: 100%; padding: 8px; border: 1px solid #ddd;">
                    <option value="0">User (Khách hàng)</option>
                    <option value="1">Admin (Quản trị viên)</option>
                </select>
            </div>
            <button type="submit" style="background: #2c3e50; color: white; padding: 10px 20px; border: none; cursor: pointer;">Lưu lại</button>
            <a href="/admin/users" style="margin-left: 10px; color: #666; text-decoration: none;">Hủy</a>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php'; 
?>