<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookHotel</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/templates/css/cssadmin.css">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="fa-solid fa-hotel"></span> BookHotel</h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <?php $uri = $_SERVER['REQUEST_URI']; ?>
                
                <li>
                    <a href="/admin" class="<?= strpos($uri, 'adminhome') !== false ? 'active' : '' ?>">
                        <span class="fa-solid fa-gauge-high"></span> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="<?= strpos($uri, 'users') !== false ? 'active' : '' ?>">
                        <span class="fa-solid fa-users"></span> <span>Khách hàng</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/rooms" class="<?= strpos($uri, 'rooms') !== false ? 'active' : '' ?>">
                        <span class="fa-solid fa-bed"></span> <span>Phòng</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/orders" class="<?= strpos($uri, 'orders') !== false ? 'active' : '' ?>">
                        <span class="fa-solid fa-clipboard-list"></span> <span>Đơn đặt</span>
                    </a>
                </li>
                <li>
                    <a href="/logout" style="color: #ff6b6b;">
                        <span class="fa-solid fa-right-from-bracket"></span> <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for=""><span class="fa-solid fa-bars"></span></label>
                Quản trị hệ thống
            </h2>
            <div class="user-wrapper">
                <div>
                    <h4>Xin chào, <?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin' ?></h4>
                    <small>Super Admin</small>
                </div>
            </div>
        </header>

        <main class="page-content">
            <?= $content ?? '' ?>
        </main>
    </div>

</body>
</html>