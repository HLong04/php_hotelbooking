<?php ob_start(); ?>
<section class="room-page-section" style="padding: 140px 0 80px;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

        <div style="text-align: center; margin-bottom: 60px;">
            <span style="color: #cda45e; letter-spacing: 3px; text-transform: uppercase; font-weight: bold; font-size: 13px;">Luxury Stay</span>
            <h2 style="font-size: 42px; color: #2c3e50; font-family: 'Playfair Display', serif; margin-top: 10px;">
                Danh sách & Đặt phòng
            </h2>
            <div style="width: 60px; height: 3px; background: #cda45e; margin: 20px auto;"></div>
        </div>


        <div class="filter-container">

            <a href="/rooms" class="cat-card <?= ($currentTypeId == null) ? 'active' : '' ?>">
                <div class="cat-icon"><i class="fa-solid fa-layer-group"></i></div>
                <div class="cat-info">
                    <h3>Tất cả</h3>
                    <p>Xem toàn bộ</p>
                </div>
            </a>

            <?php foreach ($roomTypes as $type): ?>
                <?php
                $isActive = ($currentTypeId == $type['id']) ? 'active' : '';

                // Logic Icon
                $iconClass = 'fa-bed';
                if (stripos($type['name'], 'VIP') !== false) $iconClass = 'fa-crown';
                if (stripos($type['name'], 'Family') !== false) $iconClass = 'fa-users';
                if (stripos($type['name'], 'Double') !== false) $iconClass = 'fa-user-group';
                ?>
                <a href="/rooms?type_id=<?= $type['id'] ?>" class="cat-card <?= $isActive ?>">
                    <div class="cat-icon"><i class="fa-solid <?= $iconClass ?>"></i></div>
                    <div class="cat-info">
                        <h3><?= $type['name'] ?></h3>
                        <p>Từ <?= number_format($type['price'] / 1000) ?>k</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>


        <!-- Sử dụng hotel-container-fluid thay vì div thông thường -->
        <div class="hotel-container-fluid" style="margin-top: 40px;">

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

                        // Link chi tiết - có thể dùng /room/detail hoặc /booking/create
                        $detailLink = "/room/detail/" . $room['id'];
                        
                        // Xử lý image
                        $imgBase = defined('URLROOT') ? URLROOT : '';
                        $rImage = isset($room['image']) ? $room['image'] : '';
                        $tImage = isset($room['type_image']) ? $room['type_image'] : '';
                        $imageName = !empty($rImage) ? $rImage : (!empty($tImage) ? $tImage : 'default.jpg');
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
                                    <img src="/img/<?= htmlspecialchars($imageName) ?>"
                                        onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500&q=60'"
                                        alt="Room">
                                </a>
                            </div>

                            <div class="hotel-content">
                                <div class="small-type">
                                    <?= isset($room['room_type_name']) ? $room['room_type_name'] : 'Standard' ?>
                                </div>

                                <h3 class="hotel-title">
                                    <a href="<?= $detailLink ?>" style="color: inherit; text-decoration: none;">
                                        Phòng <?= htmlspecialchars($room['room_number']) ?>
                                    </a>
                                </h3>

                                <div class="hotel-meta">
                                    <div class="meta-item">
                                        <i class="fa-solid fa-user-group"></i>
                                        <span><b><?= $maxAdults ?></b> Khách</span>
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
                                    <span class="price-value"><?= number_format(isset($room['price']) ? $room['price'] : 0) ?> đ</span>
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

    </div>
</section>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layouthome.php';
?>