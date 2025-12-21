<?php ob_start(); ?>

<div class="search-page-container">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

        <div class="page-header">
            <h2>Kết Quả Tìm Kiếm</h2>
            <?php if (!empty($rooms)): ?>
                <p>Tìm thấy <strong><?= count($rooms) ?></strong> phòng phù hợp với yêu cầu của bạn</p>
            <?php else: ?>
                <p>Rất tiếc, không tìm thấy phòng nào phù hợp.</p>
            <?php endif; ?>
            <div class="divider-gold"></div>
        </div>

        <div class="hotel-grid-container">

            <?php if (!empty($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
                    <?php
                    // Logic xử lý dữ liệu
                    $isAvailable = ($room['status'] == 'available' || $room['status'] == 'Available');
                    $imgSrc = !empty($room['image']) ? '/img/' . $room['image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500&q=60';

                    // Link đặt phòng (nếu có ngày checkin/checkout từ URL thì giữ nguyên)
                    $checkIn = $_GET['checkin'] ?? date('Y-m-d');
                    $checkOut = $_GET['checkout'] ?? date('Y-m-d', strtotime('+1 day'));

                    // Nếu chưa có hàm confirm, trỏ về trang chi tiết trước
                    $bookLink = "/room/detail/" . $room['id'];
                    ?>

                    <div class="hotel-card-item">
                        <div class="hotel-img-wrap">
                            <span class="room-badge">P.<?= $room['room_number'] ?></span>

                            <?php if ($isAvailable): ?>
                                <span class="status-badge status-available">Còn trống</span>
                            <?php else: ?>
                                <span class="status-badge status-booked">Đã đặt</span>
                            <?php endif; ?>

                            <a href="<?= $bookLink ?>">
                                <img src="<?= $imgSrc ?>" alt="Phòng khách sạn" onerror="this.src='https://via.placeholder.com/400x300?text=Hotel'">
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
                                <a href="<?= $bookLink ?>" style="color: inherit; text-decoration: none;">
                                    Phòng <?= $room['room_number'] ?> - View Đẹp
                                </a>
                            </h3>

                            <div class="hotel-features">
                                <span><i class="fa-solid fa-bed"></i> <?= $room['max_adults'] ?> Người</span>
                                <span><i class="fa-solid fa-wifi"></i> Wifi</span>
                                <span><i class="fa-solid fa-bath"></i> Bồn tắm</span>
                            </div>

                            <div style="font-size: 14px; color: #666; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= strip_tags($room['description'] ?? 'Không gian sang trọng, đầy đủ tiện nghi...') ?>
                            </div>

                            <div class="hotel-price">
                                <span>Giá mỗi đêm:</span>
                                <span class="price-number"><?= number_format($room['price']) ?> đ</span>
                            </div>

                            <?php if ($isAvailable): ?>
                                <a href="<?= $bookLink ?>" class="btn-action btn-gold">
                                    Xem chi tiết & Đặt phòng
                                </a>
                            <?php else: ?>
                                <button class="btn-action btn-disabled" disabled>
                                    Đang bận
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #fff; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 50px; color: #ddd; margin-bottom: 20px;"></i>
                    <h3 style="color: #666; font-family: 'Playfair Display', serif;">Không tìm thấy kết quả nào</h3>
                    <p style="color: #999; margin-bottom: 30px;">Vui lòng thử tìm kiếm với ngày khác hoặc loại phòng khác.</p>
                    <a href="/" class="btn-action btn-gold" style="display: inline-block; width: auto; padding: 12px 30px;">
                        Quay về trang chủ
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
// Logic include Layout thông minh
$layoutPath = __DIR__ . '/../layouthome.php';
if (!file_exists($layoutPath)) $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/templates/layouthome.php';
if (!file_exists($layoutPath)) $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/src/Views/layouthome.php';

if (file_exists($layoutPath)) {
    include $layoutPath;
} else {
    echo $content;
}
?>