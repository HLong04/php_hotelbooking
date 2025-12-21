<?php
// src/Views/user/detail_room.php
ob_start();

// Helper nhỏ để map trạng thái từ tiếng Anh (DB) sang tiếng Việt và class CSS
function getStatusConfig($status) {
    switch ($status) {
        case 'available':
            return ['label' => 'Còn trống', 'class' => 'status-available', 'btn_text' => 'Đặt phòng ngay', 'disabled' => false];
        case 'booked':
            return ['label' => 'Đã có khách', 'class' => 'status-booked', 'btn_text' => 'Đã được đặt', 'disabled' => true];
        case 'maintenance':
            return ['label' => 'Đang bảo trì', 'class' => 'status-maintenance', 'btn_text' => 'Bảo trì', 'disabled' => true];
        default:
            return ['label' => 'Không xác định', 'class' => '', 'btn_text' => 'N/A', 'disabled' => true];
    }
}
?>

<div class="page-header" style="background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('/uploads/<?= $typeInfo['image'] ?? 'default-room.jpg' ?>'); background-size: cover; background-position: center; color: white; padding: 80px 0; text-align: center; margin-bottom: 40px;">
    <h1 style="font-size: 3rem; margin: 0; font-family: var(--font-heading);"><?= htmlspecialchars($typeInfo['name']) ?></h1>
    <p style="opacity: 0.9; margin-top: 10px; font-size: 1.1rem;">Trải nghiệm sự sang trọng và tiện nghi bậc nhất</p>
</div>

<div class="container" style="max-width: 1600px; margin: 0 auto; padding: 0 15px; margin-bottom: 80px;">
    
    <div class="detail-layout" style="display: grid; grid-template-columns: 350px 1fr; gap: 40px;">
        
        <aside class="room-info-sidebar">
            <div class="info-box" style="background: #fff; padding: 30px; border: 1px solid #eee; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); position: sticky; top: 20px;">
                <h3 style="border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 20px; color: var(--primary);">Thông tin hạng phòng</h3>
                
                <div style="margin-bottom: 20px; border-radius: 4px; overflow: hidden;">
                    <img src="/img/<?= $typeInfo['image'] ?? 'default_room.jpg' ?>" alt="<?= htmlspecialchars($typeInfo['name']) ?>" style="width: 100%; height: auto; display: block;">
                </div>

                <p style="margin-bottom: 12px;"><strong><i class="fa-solid fa-tag" style="width: 25px; color: #666;"></i> Giá niêm yết:</strong> <br>
                    <span style="color: #e74c3c; font-weight: bold; font-size: 1.5rem; display: block; margin-top: 5px;"><?= number_format($typeInfo['price']) ?> VNĐ</span> <span style="font-size: 0.9rem; color: #888;">/ đêm</span>
                </p>
                
                <p style="margin-bottom: 12px;"><strong><i class="fa-solid fa-file-lines" style="width: 25px; color: #666;"></i> Mô tả:</strong></p>
                <div style="font-size: 0.95rem; color: #555; line-height: 1.6; text-align: justify;">
                    <?= nl2br(htmlspecialchars($typeInfo['description'])) ?>
                </div>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px dashed #ddd;">
                    <a href="/" style="display: block; text-align: center; color: #666; font-weight: 500;"><i class="fa-solid fa-arrow-left"></i> Quay lại danh sách</a>
                </div>
            </div>
        </aside>

        <div class="room-list-container">
            <h3 style="margin-bottom: 25px; font-size: 1.5rem; color: #333;">Danh sách phòng thuộc hạng này</h3>
            
            <?php if (empty($roomList)): ?>
                <div style="background: #fff3cd; color: #856404; padding: 20px; border-radius: 5px; border: 1px solid #ffeeba;">
                    <i class="fa-solid fa-circle-info"></i> Hiện chưa có phòng nào được setup cho hạng mục này. Vui lòng quay lại sau.
                </div>
            <?php else: ?>
                
                <div class="room-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                    <?php foreach ($roomList as $room): ?>
                        <?php 
                            // Lấy config hiển thị dựa trên status từ DB
                            $config = getStatusConfig($room['status']); 
                        ?>
                        
                        <div class="room-item <?= $config['class'] ?>" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; transition: all 0.3s ease; position: relative;">
                            <div style="height: 6px; width: 100%;" class="status-bar"></div>
                            
                            <div style="padding: 25px 20px; text-align: center;">
                                <div style="font-size: 0.9rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Phòng số</div>
                                <div class="room-number" style="font-size: 2.5rem; font-weight: 700; color: #333; line-height: 1; margin-bottom: 15px;">
                                    <?= $room['room_number'] ?>
                                </div>
                                
                                <div class="room-status-badge" style="display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;">
                                    <i class="fa-solid fa-circle" style="font-size: 8px; vertical-align: middle; margin-right: 5px;"></i> <?= $config['label'] ?>
                                </div>

                                <?php if (!$config['disabled']): ?>
                                    <a href="/booking/create/<?= $room['id'] ?>" class="btn-book-room"
                                    style="display: block; width: 100%; padding: 10px 0; background: var(--primary); color: #fff; text-decoration: none; border-radius: 4px; font-weight: 500; transition: 0.3s;">
                                        <?= $config['btn_text'] ?>
                                    </a>
                                <?php else: ?>
                                    <button disabled style="width: 100%; padding: 10px 0; background: #eee; color: #aaa; border: none; border-radius: 4px; cursor: not-allowed; font-weight: 500;">
                                        <?= $config['btn_text'] ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layouthome.php';
?>