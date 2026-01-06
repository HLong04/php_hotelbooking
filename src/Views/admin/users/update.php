<?php ob_start(); ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3>Sửa thông tin: <?= $user['full_name'] ?></h3>
    </div>
    <div class="card-body">
        <form action="/admin/users/update/<?= $user['id'] ?>" method="POST">
            <div style="margin-bottom: 15px;">
                <label>Họ và tên:</label>
                <input type="text" name="full_name" value="<?= $user['full_name'] ?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Email:</label>
                <input type="email" name="email" value="<?= $user['email'] ?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Số điện thoại:</label>
                <input type="text" name="phone" value="<?= $user['phone'] ?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Tổng chi tiêu:</label>
                <input type="number" name="total_spent" value="<?= $user['total_spent'] ?>" required style="width: 100%; padding: 8px; border: 1px solid #ddd;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Cấp độ:</label>
                <select name="rank_level" style="width: 100%; padding: 8px; border: 1px solid #ddd;">

                    <option value="standard" <?= $user['rank_level'] == 'standard' ? 'selected' : '' ?>>Standard</option>

                    <option value="vip" <?= $user['rank_level'] == 'vip' ? 'selected' : '' ?>>Vip</option>

                    <option value="diamond" <?= $user['rank_level'] == 'diamond' ? 'selected' : '' ?>>Diamond</option>

                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Vai trò:</label>
                <select name="role" style="width: 100%; padding: 8px; border: 1px solid #ddd;">
                    <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>User</option>
                    <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" style="background: #2980b9; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cập nhật</button>
            <a href="/admin/users" style="margin-left: 10px; color: #666; text-decoration: none;">Quay lại</a>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layout-admin.php';
?>