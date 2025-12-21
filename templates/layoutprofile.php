<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay - Trải nghiệm nghỉ dưỡng đẳng cấp</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="/templates/css/tooplate-bistro-elegance.css">
    <link rel="stylesheet" href="/templates/css/profile.css">

</head>

<body>

    <nav>
        <div class="nav-container">
            <a href="/" class="logo">
                <i class="fa-solid fa-hotel" style="color: var(--primary);"></i>
                LUX<span>STAY</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="/" class="active">Trang chủ</a></li>
                <li><a href="/rooms">Phòng & Suites</a></li>
                <li><a href="/services">Dịch vụ</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="dropdown">
                        <a href="#" style="color: var(--primary); font-weight: 600;">
                            <i class="fa-regular fa-user-circle"></i> 
                            <?= htmlspecialchars($_SESSION['user_name']) ?> <i class="fa-solid fa-caret-down"></i>
                        </a>
                        
                        <ul class="dropdown-menu">
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                                <li><a href="/adminhome"><i class="fa-solid fa-gauge"></i> Quản trị viên</a></li>
                            <?php else: ?>
                                <li><a href="/profile/<?= (int)$_SESSION['user_id'] ?>"><i class="fa-solid fa-id-card"></i> Hồ sơ của tôi</a></li>
                                <li><a href="/myorders"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử đặt phòng</a></li>
                            <?php endif; ?>
                            <li><a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="/login" style="border: 1px solid var(--primary); padding: 8px 20px; border-radius: 20px; color: var(--primary);">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <?php 
            if(isset($content)) {
                echo $content; 
            } else {
                // Nội dung mẫu nếu biến $content chưa có
                echo "<h2 style='text-align:center; font-family: var(--font-heading); margin-bottom:20px;'>Các phòng nổi bật</h2>";
                echo "<p style='text-align:center;'>Vui lòng tải nội dung view vào biến \$content.</p>";
            }
        ?>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>LuxStay Hotel</h3>
                <p>123 Đường Lê Lợi, TP. Huế, Việt Nam</p>
                <p>Tel: +84 905 123 456</p>
                <p>Email: booking@luxstay.com</p>
            </div>
            <div class="footer-section">
                <h3>Liên kết nhanh</h3>
                <p><a href="#">Về chúng tôi</a></p>
                <p><a href="#">Chính sách bảo mật</a></p>
                <p><a href="#">Điều khoản sử dụng</a></p>
            </div>
            <div class="footer-section">
                <h3>Kết nối</h3>
                <p><a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a></p>
                <p><a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a></p>
            </div>
        </div>
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); text-align: center;">
            <p>&copy; 2026 LuxStay Hotel & Resort. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Hiệu ứng dính navbar khi cuộn (Optional)
        window.addEventListener("scroll", function(){
            var nav = document.querySelector("nav");
            nav.classList.toggle("sticky", window.scrollY > 0);
        })
    </script>
</body>

</html>