<?php ob_start(); ?>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 style="color: #2c3e50; font-family: 'Playfair Display', serif;">Quản lý Loại Phòng</h3>
        <a href="/admin/typeroom/create" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Thêm mới
        </a>
    </div>

    <div class="card-body">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert-success">
                <?= $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Hình ảnh</th>
                        <th width="20%">Tên loại phòng</th>
                        <th width="10%">Sức chứa</th>
                        <th width="15%">Giá / Đêm</th>
                        <th width="25%">Mô tả</th>
                        <th width="10%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($types)): ?>
                        <?php foreach ($types as $item): ?>
                            <?php
                            $imgSrc = !empty($item['image']) ? URLROOT . '/img/' . $item['image'] : 'https://via.placeholder.com/150';
                            ?>
                            <tr>
                                <td>#<?= $item['id'] ?></td>
                                <td>
                                    <div class="img-thumbnail-wrapper">
                                        <img src="<?= $imgSrc ?>" alt="<?= $item['name'] ?>">
                                    </div>
                                </td>
                                <td>
                                    <strong><?= $item['name'] ?></strong>
                                </td>
                                <td style="text-align: center;">
                                    <span style="background: #f0f0f0; padding: 5px 10px; border-radius: 15px; font-weight: bold; color: #555;">
                                        <i class="fa-solid fa-user-group"></i> <?= $item['max_adults'] ?>
                                    </span>
                                </td>
                                <td style="color: #cda45e; font-weight: bold;">
                                    <?= number_format($item['price'], 0, ',', '.') ?> đ
                                </td>
                                <td>
                                    <span style="font-size: 13px; color: #666; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= $item['description'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/admin/typeroom/update/<?= $item['id'] ?>" class="btn-icon btn-edit" title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="/admin/typeroom/delete/<?= $item['id'] ?>" class="btn-icon btn-delete" title="Xóa" onclick="return confirm('CẢNH BÁO: Xóa loại phòng này có thể ảnh hưởng đến các phòng đang sử dụng nó. Bạn chắc chắn chứ?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px;">Chưa có dữ liệu loại phòng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layout-admin.php';
?>