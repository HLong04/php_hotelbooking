<?php
ob_start();
?>

<style>
    /* --- SERVICE SECTION STYLES --- */

    .service-section {
        padding: 100px 0;
        background-color: #f9f9f9;
        /* Nền xám rất nhạt để tách biệt */
    }

    /* Tiêu đề chung */
    .section-title-wrapper {
        text-align: center;
        margin-bottom: 60px;
    }

    .sub-title {
        color: #cda45e;
        /* Màu vàng Gold */
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 10px;
    }

    .main-title {
        font-family: 'Playfair Display', serif;
        font-size: 40px;
        color: #2c3e50;
        /* Màu xanh đen */
        margin: 0;
    }

    .divider-gold {
        width: 60px;
        height: 3px;
        background: #cda45e;
        margin: 20px auto 0;
    }

    /* Grid Layout */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        /* Tự chia cột, tối thiểu 300px */
        gap: 30px;
    }

    /* Service Card */
    .service-item {
        background: #fff;
        padding: 40px 30px;
        text-align: center;
        border: 1px solid #eee;
        /* Viền mờ */
        border-radius: 5px;
        transition: all 0.4s ease;
        /* Hiệu ứng mượt */
        position: relative;
        overflow: hidden;
        cursor: default;
    }

    /* Icon */
    .service-icon {
        font-size: 50px;
        color: #cda45e;
        margin-bottom: 25px;
        transition: all 0.4s ease;
        display: inline-block;
    }

    /* Tên dịch vụ */
    .service-item h3 {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        color: #2c3e50;
        margin-bottom: 15px;
        transition: color 0.4s ease;
    }

    /* Mô tả */
    .service-item p {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
        transition: color 0.4s ease;
    }

    /* --- HIỆU ỨNG HOVER (Điểm nhấn Luxury) --- */

    .service-item:hover {
        background-color: #2c3e50;
        /* Đổi nền sang màu tối */
        transform: translateY(-10px);
        /* Nổi lên trên */
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        /* Đổ bóng sâu */
        border-color: #2c3e50;
    }

    .service-item:hover .service-icon {
        color: #cda45e;
        /* Giữ màu vàng hoặc chuyển trắng tùy thích */
        transform: scale(1.1) rotate(5deg);
        /* Icon phóng to nhẹ và xoay */
    }

    .service-item:hover h3 {
        color: #fff;
        /* Chữ tiêu đề thành trắng */
    }

    .service-item:hover p {
        color: #ccc;
        /* Chữ mô tả thành xám nhạt */
    }

    /* Thêm một đường viền vàng chạy dưới card khi hover */
    .service-item::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background-color: #cda45e;
        transition: width 0.4s ease;
    }

    .service-item:hover::after {
        width: 100%;
        /* Đường kẻ chạy từ 0 -> 100% */
    }

    /* --- FEATURED SERVICE (ZIG-ZAG) --- */
    .featured-service-section {
        padding: 80px 0;
        background: #fff;
    }

    .feat-item {
        display: flex;
        align-items: center;
        gap: 60px;
        margin-bottom: 100px;
        /* Khoảng cách giữa các khối */
    }

    /* Đảo ngược thứ tự cho Block 2 */
    .feat-item.reverse {
        flex-direction: row-reverse;
    }

    /* Ảnh */
    .feat-img {
        flex: 1;
        position: relative;
    }

    .feat-img img {
        width: 100%;
        border-radius: 5px;
        box-shadow: 20px 20px 0px #f0f0f0;
        /* Hiệu ứng khung bóng lệch */
        transition: transform 0.5s ease;
    }

    .feat-item:hover .feat-img img {
        transform: scale(1.02);
    }

    /* Nội dung chữ */
    .feat-content {
        flex: 1;
    }

    .feat-content h3 {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        color: #2c3e50;
        margin: 10px 0 20px;
    }

    .feat-content p {
        color: #666;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    /* List dấu tích */
    .feat-list {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }

    .feat-list li {
        margin-bottom: 10px;
        color: #444;
        font-size: 15px;
    }

    .feat-list li i {
        color: #cda45e;
        /* Màu vàng gold */
        margin-right: 10px;
    }

    /* Nút Text Link */
    .btn-text {
        color: #cda45e;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid transparent;
        transition: 0.3s;
    }

    .btn-text:hover {
        border-bottom-color: #cda45e;
        color: #b38b45;
    }

    /* --- STATS SECTION (CON SỐ) --- */
    .stats-section {
        /* Ảnh nền Parallax tối màu để làm nổi bật số vàng */
        background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80');
        background-attachment: fixed;
        /* Tạo hiệu ứng trôi ảnh nền */
        background-size: cover;
        background-position: center;
        padding: 80px 0;
        position: relative;
        color: #fff;
    }

    /* Lớp phủ màu đen mờ lên ảnh nền */
    .stats-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(12, 16, 22, 0.85);
        /* Màu đen xanh đậm 85% */
    }

    .stats-grid {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        text-align: center;
    }

    .stat-box {
        flex: 1;
        min-width: 200px;
        margin: 20px 0;
    }

    .stat-box i {
        font-size: 40px;
        color: #cda45e;
        margin-bottom: 15px;
    }

    .stat-box h2 {
        font-size: 48px;
        font-weight: 700;
        margin: 0;
        font-family: 'Playfair Display', serif;
        color: #fff;
    }

    .stat-box p {
        color: #ccc;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 14px;
        margin-top: 10px;
    }

    /* --- RESPONSIVE (Cho điện thoại) --- */
    @media (max-width: 768px) {

        .feat-item,
        .feat-item.reverse {
            flex-direction: column;
            gap: 30px;
        }

        .feat-img img {
            box-shadow: 10px 10px 0px #f0f0f0;
        }

        .stats-grid {
            flex-direction: column;
        }
    }
</style>

<section class="service-section">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

        <div class="section-title-wrapper">
            <span class="sub-title">Khám phá</span>
            <h2 class="main-title">DỊCH VỤ TIỆN ÍCH</h2>
            <div class="divider-gold"></div>
        </div>

        <div class="services-grid">

            <div class="service-item">
                <div class="service-icon">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h3>Nhà hàng 5 Sao</h3>
                <p>Thưởng thức ẩm thực đẳng cấp quốc tế với các đầu bếp hàng đầu trong không gian sang trọng.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fa-solid fa-spa"></i>
                </div>
                <h3>Spa & Wellness</h3>
                <p>Thư giãn tuyệt đối với liệu trình massage thảo dược và chăm sóc sức khỏe toàn diện.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fa-solid fa-person-swimming"></i>
                </div>
                <h3>Hồ bơi Vô cực</h3>
                <p>Hồ bơi ngoài trời với tầm nhìn toàn cảnh thành phố, nước ấm bốn mùa.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
                <h3>Phòng Gym</h3>
                <p>Trang thiết bị hiện đại, huấn luyện viên cá nhân hỗ trợ tập luyện 24/7.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fa-solid fa-car"></i>
                </div>
                <h3>Đưa đón Sân bay</h3>
                <p>Dịch vụ xe sang đưa đón tận nơi, đảm bảo sự riêng tư và thoải mái nhất.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fa-solid fa-martini-glass-citrus"></i>
                </div>
                <h3>Sky Bar</h3>
                <p>Ngắm nhìn thành phố về đêm và thưởng thức những ly cocktail thượng hạng.</p>
            </div>

        </div>
    </div>
</section>
<section class="featured-service-section">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

        <div class="feat-item">
            <div class="feat-img">
                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=800&q=80" alt="Restaurant">
            </div>
            <div class="feat-content">
                <span class="sub-title">Taste of Luxury</span>
                <h3>Ẩm Thực Đỉnh Cao</h3>
                <p>Khám phá hương vị độc đáo được chế biến bởi những đầu bếp Michelin. Từ hải sản tươi sống đến bò Wagyu thượng hạng, mỗi món ăn là một tác phẩm nghệ thuật.</p>
                <ul class="feat-list">
                    <li><i class="fa-solid fa-check"></i> Thực đơn Á - Âu đa dạng</li>
                    <li><i class="fa-solid fa-check"></i> Không gian view biển lãng mạn</li>
                    <li><i class="fa-solid fa-check"></i> Rượu vang lâu năm tuyển chọn</li>
                </ul>
                <a href="#" class="btn-text">Đặt bàn ngay &rarr;</a>
            </div>
        </div>

        <div class="feat-item reverse">
            <div class="feat-content">
                <span class="sub-title">Relax & Rejuvenate</span>
                <h3>Thiên Đường Spa</h3>
                <p>Rũ bỏ mọi mệt mỏi với liệu trình trị liệu bằng đá nóng và hương liệu tự nhiên. Chúng tôi mang đến sự cân bằng hoàn hảo cho Thân - Tâm - Trí của bạn.</p>
                <ul class="feat-list">
                    <li><i class="fa-solid fa-check"></i> Phòng xông hơi đá muối Himalaya</li>
                    <li><i class="fa-solid fa-check"></i> Massage trị liệu cổ truyền</li>
                    <li><i class="fa-solid fa-check"></i> Khu vực thiền định riêng biệt</li>
                </ul>
                <a href="#" class="btn-text">Xem gói dịch vụ &rarr;</a>
            </div>
            <div class="feat-img">
                <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80" alt="Spa">
            </div>
        </div>

    </div>
</section>

<section class="stats-section">
    <div class="stats-overlay"></div>
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
        <div class="stats-grid">

            <div class="stat-box">
                <i class="fa-solid fa-users"></i>
                <h2 class="counter">5000+</h2>
                <p>Khách hàng hài lòng</p>
            </div>

            <div class="stat-box">
                <i class="fa-solid fa-bed"></i>
                <h2 class="counter">150</h2>
                <p>Phòng & Suites</p>
            </div>

            <div class="stat-box">
                <i class="fa-solid fa-trophy"></i>
                <h2 class="counter">25</h2>
                <p>Giải thưởng Quốc tế</p>
            </div>

            <div class="stat-box">
                <i class="fa-solid fa-mug-hot"></i>
                <h2 class="counter">10</h2>
                <p>Năm kinh nghiệm</p>
            </div>

        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
include APPROOT . '/templates/layouthome.php';
?>