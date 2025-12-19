<?php 
ob_start(); 
?>

<style>

</style>

<div class="hero-section">
    <div class="hero-content">
        <h1>BOOK HOTEL</h1>
        <p>Trải nghiệm nghỉ dưỡng đẳng cấp & sang trọng bậc nhất</p>
        <a href="/rooms" class="btn-hero">ĐẶT PHÒNG NGAY</a>
    </div>
</div>

<div class="features">
    <div class="features-grid">
        <div class="feature-item">
            <i class="fa-solid fa-wifi"></i>
            <h4>Wifi Tốc độ cao</h4>
        </div>
        <div class="feature-item">
            <i class="fa-solid fa-person-swimming"></i>
            <h4>Hồ bơi vô cực</h4>
        </div>
        <div class="feature-item">
            <i class="fa-solid fa-utensils"></i>
            <h4>Nhà hàng 5 sao</h4>
        </div>
        <div class="feature-item">
            <i class="fa-solid fa-dumbbell"></i>
            <h4>Phòng Gym</h4>
        </div>
    </div>
</div>

<section class="featured-rooms">
    <h2 class="section-title">PHÒNG NỔI BẬT</h2>
    
    <div class="room-grid">
        <?php if (!empty($rooms)): ?>
            <?php 
            // Chỉ lấy 3 phòng đầu tiên để hiển thị trang chủ
            $limit = 3; 
            $count = 0;
            foreach ($rooms as $room): 
                if ($count >= $limit) break; 
                $count++;
                
                // Xử lý ảnh (Nếu không có ảnh thì dùng ảnh mặc định)
                // Giả sử DB có cột 'image', nếu không có bạn xóa thẻ img đi hoặc hardcode
                $imgSrc = !empty($room['image']) ? URLROOT . '/img/' . $room['image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500&q=60';
            ?>
            
            <div class="room-card">
                <div class="room-img">
                    <img src="<?= $imgSrc ?>" alt="Room Image">
                </div>
                <div class="room-info">
                    <h3>Phòng số: <?= $room['room_number'] ?></h3>
                    <div class="room-price">
                        <?= number_format(500000) ?> VNĐ / đêm
                    </div>
                    <p>
                        <i class="fa-solid fa-bed"></i> Loại: <?= $room['room_type_id'] ?> | 
                        <i class="fa-solid fa-check"></i> <?= $room['status'] ?>
                    </p>
                    <a href="/room/detail/<?= $room['id'] ?>" class="btn-detail">Xem chi tiết</a>
                </div>
            </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">Hiện chưa có phòng nào.</p>
        <?php endif; ?>
    </div>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="/rooms" style="color: #2c3e50; font-weight: bold; text-decoration: underline;">Xem tất cả phòng &rarr;</a>
    </div>
</section>

<?php 
// 2. Lấy nội dung gán vào biến $content
$content = ob_get_clean(); 

// 3. Gọi Layout Chính (Giả sử file layout của bạn tên là layouthome.php nằm trong templates)
include APPROOT . '/templates/layouthome.php'; 
?>