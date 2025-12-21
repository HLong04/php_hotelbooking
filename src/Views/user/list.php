<?php 
ob_start(); 
// Đảm bảo Controller đã gọi hàm getAllRoomsWithDetails()
?>

<style>
    /* CSS QUAN TRỌNG ĐỂ CHIA 3 CỘT (Grid Layout) */
    .hotel-grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Ép buộc chia 3 cột đều nhau */
        gap: 30px; /* Khoảng cách giữa các ô */
        margin-bottom: 50px;
    }

    /* Responsive: Trên điện thoại thì tự về 1 cột */
    @media (max-width: 992px) {
        .hotel-grid-container { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .hotel-grid-container { grid-template-columns: 1fr; }
    }

    /* THIẾT KẾ CARD GIỐNG HỆT ẢNH MẪU */
    .hotel-card-item {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hotel-card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* Ảnh phòng */
    .hotel-img-wrap {
        position: relative;
        height: 220px; /* Chiều cao cố định */
        overflow: hidden;
    }

    .hotel-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Badge ĐEN: PHÒNG 101 */
    .badge-black {
        position: absolute;
        top: 15px; left: 15px;
        background-color: #000;
        color: #fff;
        padding: 6px 12px;
        font-weight: 700;
        border-radius: 4px;
        font-size: 13px;
        text-transform: uppercase;
        z-index: 5;
    }

    /* Nội dung bên dưới */
    .hotel-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .small-type {
        font-size: 12px;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .hotel-title {
        font-size: 18px;
        font-weight: 800;
        color: #111;
        margin-bottom: 8px;
    }

    .hotel-desc {
        font-size: 14px;
        color: #555;
        margin-bottom: 15px;
        line-height: 1.5;
        /* Cắt chữ nếu dài quá 2 dòng */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hotel-price {
        font-size: 20px;
        font-weight: 800;
        color: #d4b95e; /* Màu vàng kim */
        margin-bottom: 15px;
    }

    /* Nút Đặt ngay (Màu vàng bo tròn) */
    .btn-gold {
        background-color: #d4b95e;
        color: #fff;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        border: none;
        display: inline-block;
        text-decoration: none;
        width: fit-content;
    }
    .btn-gold:hover {
        background-color: #bfa145;
        color: #fff;
        text-decoration: none;
    }

    .btn-disabled { background: #ccc; cursor: not-allowed; }
</style>

<div class="container py-5" style="margin-top: 60px;">
    <div class="hotel-grid-container">
        
        <?php if (empty($rooms)): ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                <p>Đang cập nhật dữ liệu phòng...</p>
            </div>
        <?php else: ?>
            
            <?php foreach ($rooms as $room): ?>
                <?php 
                    $isAvailable = ($room['status'] == 'available');
                ?>
                
                <div class="hotel-card-item">
                    <div class="hotel-img-wrap">
                        <span class="badge-black">PHÒNG <?= htmlspecialchars($room['room_number']) ?></span>
                        
                        <?php if (!$isAvailable): ?>
                             <div style="position: absolute; top:0; right:0; background:rgba(220,53,69,0.9); color:#fff; padding:5px 10px; font-size:12px; font-weight:bold;">ĐÃ ĐẶT</div>
                        <?php endif; ?>

                        <img src="/img/<?= htmlspecialchars($room['image'] ?? 'default.jpg') ?>" 
                             onerror="this.src='https://via.placeholder.com/400x300?text=Hotel'" alt="Phòng">
                    </div>

                    <div class="hotel-content">
                        <div class="small-type">
                            <?= htmlspecialchars($room['type_name'] ?? 'Luxury Room') ?>
                        </div>
                        
                        <h3 class="hotel-title">
                            <?= htmlspecialchars($room['type_name'] ?? 'Tên phòng') ?>
                        </h3>
                        
                        <div class="hotel-desc">
                            <?= htmlspecialchars(strip_tags($room['description'] ?? 'Mô tả phòng...')) ?>
                        </div>

                        <div class="hotel-price">
                            <?= number_format($room['price']) ?> đ
                        </div>

                        <?php if ($isAvailable): ?>
                            <a href="/search?checkin=<?= date('Y-m-d') ?>&checkout=<?= date('Y-m-d', strtotime('+1 day')) ?>" class="btn-gold">
                                ĐẶT NGAY <i class="fa fa-arrow-right"></i>
                            </a>
                        <?php else: ?>
                            <button class="btn-gold btn-disabled" disabled>HẾT PHÒNG</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
        <?php endif; ?>

    </div>
</div>

<?php 
$content = ob_get_clean(); 
// Gọi Layout chính
$layoutPath = __DIR__ . '/../layouthome.php'; 
if (!file_exists($layoutPath)) $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/templates/layouthome.php';
if (!file_exists($layoutPath)) $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/src/Views/layouthome.php';
if (file_exists($layoutPath)) { require_once $layoutPath; } else { echo $content; }
?>