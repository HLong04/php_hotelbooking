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
<!--
        


chưa code 
 



-->
        <div style="margin-top: 40px;">
            
            <p style="color: #666; margin-bottom: 20px; font-style: italic;">
                <?php 
                    if($currentTypeId) echo "Đang hiển thị các phòng thuộc loại được chọn:"; 
                    else echo "Hiển thị tất cả các phòng:";
                ?>
            </p>

            <div class="room-grid">
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <?php
                            $imgBase = defined('URLROOT') ? URLROOT : ''; 
                            $rImage = isset($room['image']) ? $room['image'] : '';
                            $tImage = isset($room['type_image']) ? $room['type_image'] : ''; 
                            $imageName = !empty($rImage) ? $rImage : (!empty($tImage) ? $tImage : 'default-room.jpg');
                            $imgSrc = $imgBase . '/img/' . $imageName;

                            // 2. Logic Trạng thái
                            $isAvailable = ($room['status'] == 'available');
                            $statusClass = $isAvailable ? 'status-available' : 'status-booked';
                            $statusText = $isAvailable ? 'Trống' : 'Đã đặt';
                            if($room['status'] == 'maintenance') { $statusClass = 'status-maintenance'; $statusText = 'Bảo trì'; }

                            // 3. Link chi tiết
                            $detailLink = "/room/detail/" . $room['id'];
                        ?>
                        
                        <div class="room-card">
                            <a href="<?= $detailLink ?>" class="room-img-wrapper">
                                <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                                <img src="<?= $imgSrc ?>" alt="Room" onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500&q=60'">
                            </a>

                            <div class="room-info">
                                <div class="room-header">
                                    <span class="room-number">P.<?= $room['room_number'] ?></span>
                                    <span class="room-type-label"><?= isset($room['room_type_name']) ? $room['room_type_name'] : 'Standard' ?></span>
                                </div>

                                <div class="room-price">
                                    <?= number_format(isset($room['price']) ? $room['price'] : 0, 0, ',', '.') ?> <small style="font-size: 14px; color: #888; font-weight: 400;">/ đêm</small>
                                </div>

                                <div class="room-features">
                                    <span><i class="fa-solid fa-wifi"></i> Wifi</span>
                                    <span><i class="fa-solid fa-tv"></i> TV</span>
                                    <span><i class="fa-solid fa-wind"></i> AC</span>
                                </div>

                                <a href="<?= $detailLink ?>" class="btn-book-now">
                                    <?= $isAvailable ? 'Xem chi tiết & Đặt' : 'Xem thông tin' ?>
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #f9f9f9; border-radius: 12px; border: 2px dashed #ddd;">
                        <i class="fa-solid fa-folder-open" style="font-size: 50px; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 style="color: #666; margin-bottom: 10px;">Không tìm thấy phòng nào</h3>
                        <p style="color: #999;">Vui lòng chọn loại phòng khác hoặc quay lại sau.</p>
                        <a href="/rooms" style="display: inline-block; margin-top: 20px; color: #cda45e; font-weight: bold;">Xóa bộ lọc</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layouthome.php';
?>