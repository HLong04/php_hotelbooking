<?php ob_start(); ?>

<style>
    /* CSS Riêng cho Dashboard */
    .dashboard-wrapper {
        font-family: 'Poppins', sans-serif;
        color: #333;
    }

    /* 1. Cards Grid */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .card-single {
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid transparent;
    }

    .card-single:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* Màu sắc từng thẻ */
    .card-1 { border-left-color: #3498db; } /* Khách hàng */
    .card-2 { border-left-color: #e67e22; } /* Phòng */
    .card-3 { border-left-color: #2ecc71; } /* Doanh thu */
    .card-4 { border-left-color: #e74c3c; } /* Đơn chờ */

    .card-info h1 { font-size: 2rem; margin-bottom: 5px; color: #2c3e50; }
    .card-info span { color: #888; font-size: 0.9rem; }
    
    .card-icon { font-size: 2.5rem; opacity: 0.3; }

    /* 2. Recent Grid (Chia cột nội dung bên dưới) */
    .recent-grid {
        display: grid;
        grid-template-columns: 65% auto; /* Bên trái rộng hơn */
        gap: 20px;
    }

    .card-content {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .card-header {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 { font-size: 1.1rem; color: #2c3e50; }
    .btn-view-all {
        background: #3498db; color: white; padding: 5px 15px;
        border-radius: 4px; font-size: 0.8rem; text-decoration: none;
    }

    .card-body { padding: 20px; }

    /* Table Style */
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { border-bottom: 2px solid #eee; }
    thead td { font-weight: 600; padding-bottom: 10px; color: #555; }
    tbody tr { border-bottom: 1px solid #eee; }
    tbody tr:last-child { border-bottom: none; }
    tbody td { padding: 15px 0; font-size: 0.9rem; color: #444; }

    /* Status Badges */
    .badge { padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge.pending { background: #fff3cd; color: #856404; }
    .badge.confirmed { background: #d1ecf1; color: #0c5460; }
    .badge.completed { background: #d4edda; color: #155724; }

    /* Responsive Mobile */
    @media (max-width: 900px) {
        .recent-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-wrapper">
    <h3 style="margin-bottom: 25px; color: #2c3e50; font-weight: 700;">Dashboard Overview</h3>
    
    <div class="cards-grid">
        <div class="card-single card-1">
            <div class="card-info">
                <h1><?= $so_user ?? 0 ?></h1>
                <span>Khách hàng đăng ký</span>
            </div>
            <div class="card-icon">
                <i class="fa-solid fa-users" style="color: #3498db;"></i>
            </div>
        </div>

        <div class="card-single card-2">
            <div class="card-info">
                <h1><?= $so_room ?? 0 ?></h1>
                <span>Phòng hiện có</span>
            </div>
            <div class="card-icon">
                <i class="fa-solid fa-bed" style="color: #e67e22;"></i>
            </div>
        </div>

        <div class="card-single card-3">
            <div class="card-info">
                <h1><?= number_format($tong_tien ?? 0, 0, ',', '.') ?> <small style="font-size: 0.5em">đ</small></h1>
                <span>Tổng doanh thu</span>
            </div>
            <div class="card-icon">
                <i class="fa-solid fa-sack-dollar" style="color: #2ecc71;"></i>
            </div>
        </div>

        <div class="card-single card-4">
            <div class="card-info">
                <h1><?= $pending_count ?? 0 ?></h1>
                <span>Đơn chờ duyệt</span>
            </div>
            <div class="card-icon">
                <i class="fa-solid fa-clipboard-list" style="color: #e74c3c;"></i>
            </div>
        </div>
    </div>

    <div class="recent-grid">
        
        <div class="card-content">
            <div class="card-header">
                <h3>Đơn đặt phòng gần đây</h3>
                <a href="/admin/orders" class="btn-view-all">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <td>Khách hàng</td>
                                <td>Phòng</td>
                                <td>Trạng thái</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($recent_orders) && count($recent_orders) > 0): ?>
                                <?php foreach($recent_orders as $order): ?>
                                    <tr>
                                        <td><?= $order['full_name'] ?><br><small style="color:#888"><?= date('d/m', strtotime($order['created_at'])) ?></small></td>
                                        <td>P.<?= $order['room_number'] ?></td>
                                        <td>
                                            <?php 
                                                $cls = 'pending'; $txt = 'Chờ duyệt';
                                                if($order['status']=='confirmed') { $cls='confirmed'; $txt='Đã nhận'; }
                                                if($order['status']=='completed') { $cls='completed'; $txt='Hoàn thành'; }
                                                if($order['status']=='cancelled') { $cls='cancelled'; $txt='Đã hủy'; }
                                            ?>
                                            <span class="badge <?= $cls ?>"><?= $txt ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="text-align: center; color: #999;">Chưa có dữ liệu đơn hàng mới.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-content">
            <div class="card-header">
                <h3>Thao tác nhanh</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    
                    <a href="/admin/rooms/add" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: #f8f9fa; border-radius: 8px; color: #333; transition: 0.3s;">
                        <div style="width: 40px; height: 40px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: 14px;">Thêm phòng mới</h4>
                            <small style="color: #777;">Cập nhật kho phòng</small>
                        </div>
                    </a>

                    <a href="/admin/orders?status=Pending" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: #f8f9fa; border-radius: 8px; color: #333; transition: 0.3s;">
                        <div style="width: 40px; height: 40px; background: #e74c3c; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: 14px;">Xử lý đơn chờ</h4>
                            <small style="color: #777;">Cần duyệt gấp</small>
                        </div>
                    </a>

                    <div style="margin-top: 20px;">
                        <h4 style="font-size: 14px; margin-bottom: 10px;">Tỉ lệ lấp đầy (Demo)</h4>
                        <div style="background: #eee; border-radius: 10px; height: 10px; width: 100%; overflow: hidden;">
                            <div style="background: #2ecc71; width: 70%; height: 100%;"></div>
                        </div>
                        <small style="display: block; text-align: right; margin-top: 5px; color: #666;">70% Phòng đã đặt</small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php 
$content = ob_get_clean(); 
include APPROOT . '/templates/layout-admin.php';
?>