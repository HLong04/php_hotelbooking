<?php ob_start(); ?>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Quản lý Loại Phòng</h3>
        <a href="/admin/typeroom/create" class="btn-add" style="background: #2c3e50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            <i class="fa-solid fa-plus"></i> Thêm mới
        </a>
    </div>

    <div class="card-body" style="margin-top: 20px;">

        <form action="" method="GET" class="search-bar">
            
            <div class="form-group-custom" style="flex: 2;">
                <label>Từ khóa</label>
                <input type="text" name="keyword" class="form-control" 
                       placeholder="Nhập ID hoặc Tên loại phòng..." 
                       value="<?= htmlspecialchars($keyword ?? '') ?>">
            </div>

            <div class="form-group-custom">
                <label>Sức chứa (Người)</label>
                <input type="number" name="capacity" class="form-control" 
                       placeholder="VD: 2" min="1"
                       value="<?= htmlspecialchars($capacity ?? '') ?>">
            </div>

            <div class="form-group-custom">
                <label>Giá tối đa</label>
                <input type="number" name="price" class="form-control" 
                       placeholder="VD: 1000000" step="10000"
                       value="<?= htmlspecialchars($maxPrice ?? '') ?>">
            </div>

            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
            <?php if(!empty($keyword) || !empty($capacity) || !empty($maxPrice)): ?>
                <a href="/admin/typeroom" class="btn-reset">Đặt lại</a>
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
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Hình ảnh</th>
                    <th style="padding: 12px;">Tên loại phòng</th>
                    <th style="padding: 12px;">Sức chứa</th>
                    <th style="padding: 12px;">Giá / Đêm</th>
                    <th style="padding: 12px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($types)): ?>
                    <?php foreach ($types as $item): ?>
                        <?php
                            $imgSrc = !empty($item['image']) ? URLROOT . '/img/' . $item['image'] : 'https://via.placeholder.com/150';
                        ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">#<?= $item['id'] ?></td>
                            <td style="padding: 12px;">
                                <img src="<?= $imgSrc ?>" alt="Img" class="room-thumb">
                            </td>
                            <td style="padding: 12px;">
                                <strong style="color: #2c3e50; font-size: 15px;"><?= $item['name'] ?></strong>
                                <br>
                                <small style="color: #888; font-style: italic;">
                                    <?= mb_strimwidth(strip_tags($item['description']), 0, 50, "...") ?>
                                </small>
                            </td>
                            <td style="padding: 12px;">
                                <span style="background: #eee; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; color: #555;">
                                    <i class="fa-solid fa-user"></i> x<?= $item['max_adults'] ?>
                                </span>
                            </td>
                            <td style="padding: 12px; color: #cda45e; font-weight: bold;">
                                <?= number_format($item['price'], 0, ',', '.') ?> đ
                            </td>
                            <td style="padding: 12px;">
                                <a href="/admin/typeroom/update/<?= $item['id'] ?>" style="color: #3498db; margin-right: 10px;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="/admin/typeroom/delete/<?= $item['id'] ?>" 
                                   onclick="return confirm('CẢNH BÁO: Xóa loại phòng này có thể ảnh hưởng đến các phòng đang sử dụng nó. Bạn chắc chắn chứ?');" 
                                   style="color: #e74c3c;">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #999;">Không tìm thấy loại phòng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if (isset($total_pages) && $total_pages > 1): ?>
            <ul class="pagination">
                <?php if ($current_page > 1): ?>
                    <li><a href="?page=<?= $current_page - 1 ?>&keyword=<?= $keyword ?? '' ?>&capacity=<?= $capacity ?? '' ?>&price=<?= $maxPrice ?? '' ?>">« Trước</a></li>
                <?php else: ?>
                    <li class="disabled"><span>« Trước</span></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?= ($i == $current_page) ? 'active' : '' ?>">
                        <a href="?page=<?= $i ?>&keyword=<?= $keyword ?? '' ?>&capacity=<?= $capacity ?? '' ?>&price=<?= $maxPrice ?? '' ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li><a href="?page=<?= $current_page + 1 ?>&keyword=<?= $keyword ?? '' ?>&capacity=<?= $capacity ?? '' ?>&price=<?= $maxPrice ?? '' ?>">Sau »</a></li>
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