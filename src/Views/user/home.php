<?php
ob_start();
?>
<section class="intro-section">
    <div class="container">

        <div class="intro-text">
            <span class="sub-heading">BOOK HOTEL</span>
            <h2 class="main-heading">Trải nghiệm nghỉ dưỡng đẳng cấp &<br>sang trọng bậc nhất</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="#type" class="btn-intro">ĐẶT PHÒNG NGAY</a>
            <?php else: ?>
                <a href="/login" class="btn-intro">ĐĂNG NHẬP ĐỂ ĐẶT PHÒNG</a>
            <?php endif; ?>
            <!-- <a href="#booking" class="">ĐẶT PHÒNG NGAY</a> -->
        </div>

        <div class="features-grid">
            <div class="feature-item">
                <div class="icon-box">
                    <i class="fa-solid fa-wifi"></i>
                </div>
                <h3>Wifi Tốc độ cao</h3>
            </div>

            <div class="feature-item">
                <div class="icon-box">
                    <i class="fa-solid fa-person-swimming"></i>
                </div>
                <h3>Hồ bơi vô cực</h3>
            </div>

            <div class="feature-item">
                <div class="icon-box">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h3>Nhà hàng 5 sao</h3>
            </div>

            <div class="feature-item">
                <div class="icon-box">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
                <h3>Phòng Gym</h3>
            </div>
        </div>
    </div>
</section>


<section id="type" class="featured-rooms">
<section class="featured-rooms">
    <h2 class="section-title">CÁC HẠNG PHÒNG NỔI BẬT</h2> <div class="room-grid">
        <?php if (!empty($roomTypes)): ?>
            <?php
            // $limit = 4;
            // $count = 0;
            foreach ($roomTypes as $type):
                // if ($count >= $limit) break;
                // $count++;

                $imgSrc = !empty($type['image']) ? URLROOT . '/img/' . $type['image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500&q=60';
            ?>

                <div class="room-card">
                    <div class="room-img">
                        <img src="<?= $imgSrc ?>" alt="<?= $type['name'] ?>">
                    </div>
                    <div class="room-info">
                        <h3><?= $type['name'] ?></h3>
                        
                        <div class="room-price">
                            <?= number_format($type['price']) ?> VNĐ / đêm
                        </div>
                        
                        <div style="font-size: 14px; color: #555; margin-bottom: 10px;">
                            <i class="fa-solid fa-users" style="color: var(--primary);"></i>
                            <strong><?= $type['max_adults'] ?></strong> người lớn
                        </div>

                        <p style="font-size: 14px; color: #666; margin-bottom: 10px;">
                           <?= substr($type['description'], 0, 100) ?>...
                        </p>

                       <?php
                        // --- ĐOẠN ĐÃ SỬA ---
                        // Kiểm tra session user_id để xác định link
                        if (isset($_SESSION['user_id'])) {
                            $detailLink = '/rooms/type/' . $type['id'];
                        } else {
                            $detailLink = '/login';
                        }
                        // -------------------
                        ?>
                        <a href="<?= $detailLink ?>" class="btn-detail">Xem danh sách phòng</a>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">Hiện chưa có hạng phòng nào.</p>
        <?php endif; ?>
    </div>

</section>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layouthome.php';
?>