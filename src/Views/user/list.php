<?php ob_start(); ?>
<div class="hotel-container-fluid">

    <?php if (!empty($rooms)): ?>
        <p style="text-align: center; color: #666; margin-bottom: 30px;">
            Hiển thị <strong><?= count($rooms) ?></strong> phòng phù hợp nhất
        </p>
    <?php endif; ?>

    <div class="hotel-grid-container">

        <?php if (empty($rooms)): ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #fff; border-radius: 8px;">
                <i class="fa-solid fa-hotel" style="font-size: 40px; color: #ddd; margin-bottom: 20px;"></i>
                <p style="color: #666;">Chưa có dữ liệu phòng nào.</p>
            </div>
        <?php else: ?>

            <?php foreach ($rooms as $room): ?>
                <?php
                // 1. Xử lý Logic
                $isAvailable = ($room['status'] == 'available' || $room['status'] == 'Available');

                // Lấy số người từ DB (nếu null thì mặc định 2)
                $maxAdults = isset($room['max_adults']) ? $room['max_adults'] : 2;

                // Link chi tiết
                $detailLink = "/booking/create/" . $room['id'];
                ?>

                <div class="hotel-card-item">
                    <div class="hotel-img-wrap">
                        <span class="badge-room">P.<?= $room['room_number'] ?></span>

                        <?php if ($isAvailable): ?>
                            <span class="badge-status status-ok">Trống</span>
                        <?php else: ?>
                            <span class="badge-status status-busy">Đã đặt</span>
                        <?php endif; ?>

                        <a href="<?= $detailLink ?>">
                            <img src="/img/<?= htmlspecialchars($room['image'] ?? 'default.jpg') ?>"
                                onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500&q=60'"
                                alt="Room">
                        </a>
                    </div>

                    <div class="hotel-content">
                        <div class="small-type">
                            <?php foreach ($typeroom as $type): ?>
                                <?php if ($type['id'] == $room['room_type_id']): ?>
                                    <?= $type['name'] ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <h3 class="hotel-title">
                            <a href="<?= $detailLink ?>" style="color: inherit; text-decoration: none;">
                                Phòng <?= htmlspecialchars($room['room_number']) ?>
                            </a>
                        </h3>

                        <div class="hotel-meta">
                            <div class="meta-item">
                                <i class="fa-solid fa-user-group"></i>
                                <span><b><?= $maxAdults?></b> Khách</span>
                            </div>
                            <div class="meta-item">
                                <i class="fa-solid fa-maximize"></i>
                                <span>35m²</span>
                            </div>
                            <div class="meta-item">
                                <i class="fa-solid fa-wifi"></i>
                                <span>Free</span>
                            </div>
                        </div>

                        <div class="hotel-price-row">
                            <span class="price-label">Giá mỗi đêm:</span>
                            <span class="price-value"><?= number_format($room['price']) ?> đ</span>
                        </div>

                        <?php if ($isAvailable): ?>
                            <a href="<?= $detailLink ?>" class="btn-action btn-gold">
                                Xem & Đặt Phòng
                            </a>
                        <?php else: ?>
                            <button class="btn-action btn-disabled" disabled>HẾT PHÒNG</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>

<?php
$content = ob_get_clean();
// Gọi Layout
$layoutPath = __DIR__ . '/../layouthome.php';
if (!file_exists($layoutPath)) $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/templates/layouthome.php';
if (!file_exists($layoutPath)) $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/src/Views/layouthome.php';
if (file_exists($layoutPath)) {
    require_once $layoutPath;
} else {
    echo $content;
}
?>