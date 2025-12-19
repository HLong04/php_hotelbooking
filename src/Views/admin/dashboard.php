<?php 
ob_start(); 
?>

<div class="dashboard-wrapper">
    <h3 style="margin-bottom: 20px;">Tổng quan hoạt động</h3>
    
    <div class="cards">
        <div class="card-single">
            <div>
                <h1><?= $so_user ?></h1>
                <span>Khách hàng</span>
            </div>
            <div>
                <span class="fa-solid fa-users" style="color: #3498db;"></span>
            </div>
        </div>

        <div class="card-single">
            <div>
                <h1><?= $so_room ?></h1>
                <span>Phòng hiện có</span>
            </div>
            <div>
                <span class="fa-solid fa-bed" style="color: #2ecc71;"></span>
            </div>
        </div>

        <div class="card-single">
            <div>
                <h1><?= number_format($tong_tien, 0, ',', '.') ?> đ</h1>
                <span>Doanh thu</span>
            </div>
            <div>
                <span class="fa-solid fa-sack-dollar" style="color: #f1c40f;"></span>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 50px; background: white; padding: 20px; border-radius: 5px;">
        <h3>Chào mừng quay trở lại trang quản trị!</h3>
        <p>Chọn các mục bên menu trái để quản lý hệ thống.</p>
    </div>
</div>

<?php 
$content = ob_get_clean(); 

include APPROOT . '/templates/layout-admin.php';
?>