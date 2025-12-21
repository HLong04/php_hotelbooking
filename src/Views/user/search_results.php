<?php 
ob_start(); 
?>

<style>
    /* Container Flexbox */
    .custom-row {
        display: flex !important;
        flex-wrap: wrap !important;
        margin-right: -15px;
        margin-left: -15px;
    }

    .custom-col {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-bottom: 30px;
    }

    @media (min-width: 992px) {
        .custom-col { flex: 0 0 33.333333%; max-width: 33.333333%; }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .custom-col { flex: 0 0 50%; max-width: 50%; }
    }

    /* CARD STYLE */
    .room-card {
        border: none; /* Bỏ viền đen cũ */
        border-radius: 12px; /* Bo góc mềm mại hơn */
        overflow: hidden;
        background: #fff;
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08); /* Đổ bóng nhẹ */
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .room-card:hover {
        transform: translateY(-8px); /* Bay lên cao hơn chút */
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .room-img-container {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    .room-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .room-card:hover .room-img-container img {
        transform: scale(1.1); /* Zoom ảnh khi hover */
    }

    .badge-room {
        position: absolute;
        top: 15px;
        left: 15px; /* Đổi qua trái cho lạ mắt */
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        color: #fff;
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.85rem;
        z-index: 10;
        letter-spacing: 1px;
    }

    /* [MỚI] STYLE CHO NÚT ĐẶT PHÒNG */
    .btn-booking-custom {
        background: linear-gradient(45deg, #bfa145, #d4b95e); /* Màu vàng kim Gradient */
        color: white !important;
        border: none;
        padding: 12px;
        border-radius: 50px; /* Bo tròn kiểu viên thuốc */
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px rgba(191, 161, 69, 0.4); /* Bóng màu vàng */
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px; /* Khoảng cách giữa chữ và icon */
        cursor: pointer;
    }

    .btn-booking-custom:hover {
        background: linear-gradient(45deg, #1a1a1a, #333); /* Hover đổi sang màu đen sang trọng */
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        transform: translateY(-2px);
    }
    
    .btn-booking-custom i {
        font-size: 1.1em;
    }
</style>

<div class="container py-5" style="margin-top: 50px; min-height: 500px;">
    <div class="text-center mb-5">
        <h2 style="font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">KẾT QUẢ TÌM KIẾM</h2>
        <div style="width: 60px; height: 3px; background: #bfa145; margin: 10px auto;"></div> <p class="text-muted mt-3">
            Thời gian lưu trú: <strong class="text-dark"><?= htmlspecialchars(date('d/m/Y', strtotime($checkIn))) ?></strong> 
            <i class="fa fa-arrow-right mx-2" style="font-size: 0.8rem"></i> 
            <strong class="text-dark"><?= htmlspecialchars(date('d/m/Y', strtotime($checkOut))) ?></strong>
        </p>
    </div>

    <?php if (empty($rooms)): ?>
        <div class="alert alert-warning text-center shadow-sm border-0 p-5">
            <h1 class="mb-3" style="font-size: 4rem;">😕</h1>
            <h4>Hết phòng rồi!</h4>
            <p class="text-muted">Rất tiếc, không còn phòng nào trống trong khoảng thời gian này.</p>
            <a href="/" class="btn btn-outline-dark mt-3 px-4 py-2">Chọn ngày khác</a>
        </div>
    <?php else: ?>
        
        <div class="custom-row">
            <?php foreach ($rooms as $room): ?>
                <div class="custom-col">
                    <div class="room-card">
                        <div class="room-img-container">
                            <span class="badge-room">PHÒNG <?= htmlspecialchars($room['room_number']) ?></span>
                            <img src="/img/<?= htmlspecialchars($room['image'] ?? 'anhphong01.jpg') ?>" 
                                 onerror="this.src='https://via.placeholder.com/400x300?text=LuxStay'"
                                 alt="Phòng">
                        </div>

                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <div class="mb-2">
                                <small class="text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <?= htmlspecialchars($room['room_type_name'] ?? 'Luxury Room') ?>
                                </small>
                            </div>
                            
                            <h5 class="font-weight-bold text-dark mb-2">
                                <?= htmlspecialchars($room['room_type_name'] ?? 'Tên phòng') ?>
                            </h5>
                            
                            <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                                <?= htmlspecialchars(substr(strip_tags($room['description'] ?? ''), 0, 70)) ?>...
                            </p>

                            <div class="d-flex justify-content-between align-items-end mb-4 pt-3 border-top">
                                <div>
                                    <span class="text-muted small">Giá mỗi đêm</span><br>
                                    <span style="color: #bfa145; font-size: 1.4rem; font-weight: 800;">
                                        <?= number_format($room['price'] ?? 0) ?> đ
                                    </span>
                                </div>
                            </div>

                            <form action="/booking/create/<?= $room['id'] ?>" method="POST" class="mt-auto">
                                <input type="hidden" name="check_in" value="<?= $checkIn ?>">
                                <input type="hidden" name="check_out" value="<?= $checkOut ?>">
                                <input type="hidden" name="price" value="<?= $room['price'] ?? 0 ?>">
                                
                                <button type="submit" class="btn-booking-custom w-100">
                                    <span>ĐẶT NGAY</span>
                                    <i class="fa fa-arrow-right"></i> </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean(); 

$layoutPath = __DIR__ . '/../layouthome.php'; 
if (!file_exists($layoutPath)) {
    $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/templates/layouthome.php';
}
if (!file_exists($layoutPath)) {
     $layoutPath = $_SERVER['DOCUMENT_ROOT'] . '/src/Views/layouthome.php';
}

if (file_exists($layoutPath)) {
    require_once $layoutPath;
} else {
    echo $content;
}
?>