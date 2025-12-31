<?php ob_start(); ?>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Quản lý Người dùng</h3>
        <a href="/admin/users/create" class="btn-add" style="background: #2c3e50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            <i class="fa-solid fa-user-plus"></i> Thêm User
        </a>
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
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Họ tên</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">SĐT</th>
                    <th style="padding: 12px;">Vai trò</th>
                    <th style="padding: 12px;">Tổng tiền</th>
                    <th style="padding: 12px;">Cấp độ</th>
                    <th style="padding: 12px;">Hành động</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <?php if($u['role'] == 0): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">#<?= $u['id'] ?></td>
                        <td style="padding: 12px; font-weight: bold;"><?= $u['full_name'] ?></td>
                        <td style="padding: 12px;"><?= $u['email'] ?></td>
                        <td style="padding: 12px;"><?= $u['phone'] ?></td>
                        <td style="padding: 12px;">
                            <?php if($u['role'] == 1): ?>
                                <span style="background: #e74c3c; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8em;">Admin</span>
                            <?php else: ?>
                                <span style="background: #3498db; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8em;">User</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px;"><?= $u['total_spent'] ?></td>
                        <td style="padding: 12px;"><?= $u['rank_level'] ?></td>
                        <td style="padding: 12px;">
                            <a href="/admin/users/update/<?= $u['id'] ?>" style="color: #3498db; margin-right: 10px;"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                            
                            <?php if($u['id'] != $_SESSION['user_id']): ?>
                                <a href="/admin/users/delete/<?= $u['id'] ?>" onclick="return confirm('Xóa user này?');" style="color: #e74c3c;"><i class="fa-solid fa-trash"></i> Xóa</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php'; 
?>