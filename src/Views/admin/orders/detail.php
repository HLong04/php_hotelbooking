<?php ob_start(); ?>

<style>
    /* 1. BUTTON STYLE: Nút in hóa đơn đẹp */
    .btn-print {
        background-color: #ffffff;
        color: #2c3e50; /* Màu xanh đen */
        border: 1px solid #2c3e50;
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px; /* Khoảng cách giữa icon và chữ */
        text-decoration: none;
    }

    .btn-print:hover {
        background-color: #2c3e50;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(44, 62, 80, 0.2);
        transform: translateY(-2px);
    }

    .btn-print i {
        font-size: 16px;
    }

    /* 2. MEDIA PRINT: Cấu hình khi nhấn In */
    @media print {
        /* Ẩn các thành phần không cần thiết */
        .sidebar, header, footer, .btn-print, .card-status, .btn-back {
            display: none !important;
        }

        /* Canh chỉnh lại khổ giấy */
        body, .main-content {
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .card-invoice {
            border: none !important;
            box-shadow: none !important;
            flex: 1 !important;
            width: 100% !important;
        }
        
        /* Ẩn cột bên phải (trạng thái) để hóa đơn bung full giấy */
        .layout-container {
            display: block !important;
        }
    }
</style>

<div class="layout-container" style="display: flex; gap: 20px; align-items: flex-start;">

    <div class="card card-invoice" style="flex: 2;">
        
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0;">Chi tiết đơn hàng #<?= $order['id'] ?></h3>
            
            <button class="btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> In Hóa Đơn
            </button>
        </div>

        <div class="card-body">
            <div style="text-align: center; margin-bottom: 30px; display: none;" class="print-show">
                <h2 style="margin: 0; color: #cda45e;">LUXURY HOTEL</h2>
                <p>Hóa đơn thanh toán dịch vụ</p>
            </div>

            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; color: #2c3e50;">Thông tin khách hàng</h4>
            <p style="margin-bottom: 8px;"><strong>Họ tên:</strong> <?= $order['full_name'] ?></p>
            <p style="margin-bottom: 8px;"><strong>Email:</strong> <?= $order['email'] ?></p>
            <p style="margin-bottom: 8px;"><strong>SĐT:</strong> <?= $order['phone'] ?></p>

            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; margin-top: 30px; color: #2c3e50;">Thông tin phòng</h4>
            <p style="margin-bottom: 8px;"><strong>Phòng số:</strong> <span style="font-size: 1.2em; font-weight: bold; color: #2c3e50;"><?= $order['room_number'] ?></span></p>
            <p style="margin-bottom: 8px;"><strong>Ngày nhận phòng:</strong> <?= date('d/m/Y', strtotime($order['check_in'])) ?></p>
            <p style="margin-bottom: 8px;"><strong>Ngày trả phòng:</strong> <?= date('d/m/Y', strtotime($order['check_out'])) ?></p>
            <p style="margin-bottom: 8px;"><strong>Ngày tạo đơn:</strong> <?= date('H:i d/m/Y', strtotime($order['created_at'])) ?></p>

            <div style="margin-top: 30px; padding: 20px; background: #fdfdfd; border: 1px dashed #ddd; border-radius: 5px; text-align: right;">
                <span style="font-size: 1.1em; font-weight: 600; color: #555;">Tổng tiền thanh toán:</span><br>
                <span style="font-size: 1.8em; color: #cda45e; font-weight: 800; margin-top: 5px; display: inline-block;">
                    <?= number_format($order['total_price']) ?> VNĐ
                </span>
            </div>
            
            <div style="margin-top: 50px; display: none; justify-content: space-between;" class="print-show-flex">
                <div style="text-align: center;">
                    <p><strong>Khách hàng</strong></p>
                    <p style="font-size: 12px; font-style: italic;">(Ký và ghi rõ họ tên)</p>
                </div>
                <div style="text-align: center;">
                    <p><strong>Nhân viên lập phiếu</strong></p>
                    <p style="font-size: 12px; font-style: italic;">(Ký và ghi rõ họ tên)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-status" style="flex: 1; height: fit-content; position: sticky; top: 20px;">
        <div class="card-header">
            <h3>Cập nhật trạng thái</h3>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    <?= $_SESSION['flash_message']; unset($_SESSION['flash_message']); ?>
                </div>
            <?php endif; ?>

            <?php
            $stt = strtolower($order['status']);
            $is_finished = ($stt == 'completed' || $stt == 'cancelled');
            ?>

            <form action="/admin/orders/status/<?= $order['id'] ?>" method="POST">
                <label style="display: block; margin-bottom: 10px; font-weight: 600;">Chọn trạng thái:</label>

                <select name="status" <?= $is_finished ? 'disabled' : '' ?> style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 15px; background-color: <?= $is_finished ? '#f9f9f9' : '#fff' ?>; outline: none;">
                    <option value="pending" <?= $stt == 'pending' ? 'selected' : '' ?>>🟡 Chờ duyệt (Pending)</option>
                    <option value="confirmed" <?= $stt == 'confirmed' ? 'selected' : '' ?>>🔵 Đã xác nhận (Confirmed)</option>
                    <option value="completed" <?= $stt == 'completed' ? 'selected' : '' ?>>🟢 Đã trả phòng (Completed)</option>
                    <option value="cancelled" <?= $stt == 'cancelled' ? 'selected' : '' ?>>🔴 Hủy bỏ (Cancelled)</option>
                </select>

                <?php if (!$is_finished): ?>
                    <button type="submit" style="width: 100%; background: #2c3e50; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.3s;">
                        Lưu Thay Đổi
                    </button>
                <?php else: ?>
                    <div style="width: 100%; background: #eee; color: #999; padding: 12px; border-radius: 4px; text-align: center; font-size: 14px;">
                        <i class="fa-solid fa-lock"></i> Đơn hàng đã đóng
                    </div>
                <?php endif; ?>
            </form>

            <div class="btn-back" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                <a href="/admin/orders" style="text-decoration: none; color: #666; display: flex; align-items: center; gap: 5px; transition: 0.3s;">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .print-show { display: block !important; }
        .print-show-flex { display: flex !important; }
        .card-header button { display: none !important; } /* Ẩn nút in khi đang in */
    }
</style>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layout-admin.php';
?>