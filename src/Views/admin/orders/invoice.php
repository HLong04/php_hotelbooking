<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn #<?= $invoice['invoice_code'] ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; padding: 20px; color: #333; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .company-info h2 { margin: 0; color: #2c3e50; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td { padding: 5px; vertical-align: top; }
        table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        table tr.item td { border-bottom: 1px solid #eee; }
        table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        
        /* Chỉ in nội dung cần thiết */
        @media print {
            .no-print { display: none; }
            .invoice-box { border: none; box-shadow: none; }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="header">
        <div class="company-info">
            <h2>MY HOTEL</h2>
            <p>Địa chỉ: 123 Đường Lê Lợi, TP. Huế, Việt Nam<br>Hotline: +84 905 123 456</p>
        </div>
        <div class="invoice-details" style="text-align: right;">
            <h3>HÓA ĐƠN THANH TOÁN</h3>
            <p>Mã HĐ: <strong><?= $invoice['invoice_code'] ?></strong></p>
            <p>Ngày tạo: <?= date('d/m/Y H:i', strtotime($invoice['created_at'])) ?></p>
        </div>
    </div>

    <table cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>Thông tin khách hàng</td>
            <td></td>
        </tr>
        <tr class="details">
            <td colspan="2">
                Khách hàng: <?= $order['full_name'] ?><br>
                Email: <?= $order['email'] ?><br>
                SĐT: <?= $order['phone'] ?>
            </td>
        </tr>

        <tr class="heading">
            <td>Dịch vụ</td>
            <td style="text-align: right;">Thành tiền</td>
        </tr>

        <tr class="item">
            <td>
                Phòng: <?= $order['room_number'] ?><br>
                <small>Check-in: <?= date('d/m/Y', strtotime($order['check_in'])) ?> | Check-out: <?= date('d/m/Y', strtotime($order['check_out'])) ?></small>
            </td>
            <td style="text-align: right;">
                <?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ
            </td>
        </tr>

        <tr class="total">
            <td></td>
            <td style="text-align: right; padding-top: 20px;">
                Tổng cộng: <?= number_format($invoice['total_amount'], 0, ',', '.') ?> VNĐ
            </td>
        </tr>
    </table>

    <div style="margin-top: 50px; text-align: center;">
        <p><i>Cảm ơn quý khách đã sử dụng dịch vụ!</i></p>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2980b9; color: white; border: none; cursor: pointer; border-radius: 5px;">
            In ngay
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #7f8c8d; color: white; border: none; cursor: pointer; border-radius: 5px; margin-left: 10px;">
            Đóng
        </button>
    </div>
</div>

</body>
</html>