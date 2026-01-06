<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn Luxury Hotel #<?= $invoice['invoice_code'] ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- CSS RESET & GLOBAL STYLES --- */
        :root {
            --primary-color: #cda45e;
            /* Màu vàng đồng Luxury */
            --text-dark: #2c3e50;
            /* Màu đen xanh chì */
            --text-light: #7f8c8d;
            --bg-light: #f9f9f9;
            --border-color: #eaeaea;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Poppins', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            font-size: 14px;
            color: #333;
            line-height: 1.6;
            background-color: #f4f4f4;
            /* Màu nền ngoài hoa đơn */
            padding: 40px 15px;
        }

        /* --- INVOICE CONTAINER --- */
        .invoice-wrapper {
            max-width: 850px;
            margin: auto;
            background-color: #fff;
            padding: 50px;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        /* Dải màu trang trí trên cùng tạo điểm nhấn */
        .invoice-wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background-color: var(--primary-color);
        }

        /* --- HEADER SECTION --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
        }

        .company-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Style cho Logo */
        .logo-img {
            width: 80px;
            /* Điều chỉnh kích thước logo */
            height: auto;
            display: block;
        }

        .company-details h1 {
            font-family: var(--font-heading);
            font-weight: 900;
            font-size: 28px;
            color: var(--text-dark);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .company-details h1 span {
            color: var(--primary-color);
        }

        .company-details p {
            color: var(--text-light);
            font-size: 13px;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta h2 {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-color);
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .meta-item {
            margin-bottom: 3px;
            color: var(--text-light);
            font-size: 13px;
        }

        .meta-item strong {
            color: var(--text-dark);
            font-weight: 600;
        }

        /* --- CLIENT & BOOKING INFO (Grid Layout) --- */
        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .info-box-title {
            font-family: var(--font-heading);
            font-size: 16px;
            color: var(--text-dark);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
        }

        .info-group {
            margin-bottom: 8px;
            display: flex;
            font-size: 13px;
        }

        .info-label {
            width: 110px;
            color: var(--text-light);
            font-weight: 500;
        }

        .info-value {
            flex: 1;
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Style riêng cho số phòng */
        .room-number-highlight {
            font-size: 16px;
            color: var(--primary-color);
            font-weight: 700;
        }

        /* --- SERVICES TABLE --- */
        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .services-table thead th {
            font-family: var(--font-body);
            font-weight: 600;
            text-align: left;
            padding: 12px 15px;
            background-color: #fbfbfb;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
            font-size: 13px;
            text-transform: uppercase;
        }

        .services-table tbody td {
            padding: 18px 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }

        .item-desc strong {
            display: block;
            color: var(--text-dark);
            font-size: 14px;
            margin-bottom: 4px;
        }

        .item-desc small {
            color: var(--text-light);
            font-size: 12px;
            font-weight: 300;
        }

        .item-price {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .text-right {
            text-align: right;
        }

        /* --- TOTALS SECTION (Luxury Style từ bước trước) --- */
        .totals-area {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 50px;
        }

        .totals-box {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border: 1px solid #e1e1e1;
            border-top: 3px solid var(--primary-color);
            border-radius: 0 0 4px 4px;
            padding: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 10px;
            font-size: 13px;
        }

        .price-label {
            color: #666;
            font-weight: 500;
        }

        .price-value {
            font-weight: 600;
            color: #333;
        }

        .price-value.discount {
            color: var(--primary-color);
        }

        .price-row.final {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .final-label {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .final-value {
            font-size: 24px;
            color: #c0392b;
            /* Màu đỏ đậm nổi bật */
            font-weight: 800;
            font-family: var(--font-body);
            white-space: nowrap;
            /* THÊM DÒNG NÀY: Ngăn xuống dòng */
        }

        /* --- FOOTER & SIGNATURE --- */
        .footer-message {
            text-align: center;
            margin-bottom: 40px;
            color: var(--text-light);
            font-style: italic;
            font-size: 13px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding: 0 30px;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-box p {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 60px;
            /* Khoảng trống để ký */
        }

        .signature-box span {
            display: block;
            font-size: 12px;
            color: var(--text-light);
            font-style: italic;
            border-top: 1px solid var(--border-color);
            padding-top: 5px;
        }

        /* --- ACTION BUTTONS (Bị ẩn khi in) --- */
        .no-print-zone {
            max-width: 850px;
            margin: 30px auto auto auto;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-print {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-print:hover {
            background-color: #b38b45;
        }

        .btn-close {
            background-color: #95a5a6;
            color: white;
        }

        .btn-close:hover {
            background-color: #7f8c8d;
        }

        /* --- PRINT STYLES (Tối ưu hóa khi in) --- */
        @media print {
            body {
                background: white;
                padding: 0;
                color: black;
                -webkit-print-color-adjust: exact;
                /* Ép buộc in màu nền */
                print-color-adjust: exact;
            }

            .invoice-wrapper {
                box-shadow: none;
                border: none;
                padding: 20px;
                /* Giảm padding khi in */
                width: 100%;
                margin: 0;
            }

            .no-print-zone {
                display: none !important;
            }

            ::placeholder {
                color: transparent;
            }

            /* Đảm bảo các element gold vẫn có màu */
            .invoice-wrapper::before,
            .info-box-title,
            .invoice-meta h2,
            .logo-details h1 span,
            .final-value,
            .price-value.discount {
                color: #cda45e !important;
                -webkit-print-color-adjust: exact;
            }

            .info-box-title {
                border-bottom-color: #cda45e !important;
            }

            .totals-box {
                border-top-color: #cda45e !important;
            }
        }
    </style>

</head>

<body>

    <div class="invoice-wrapper">
        <div class="header">
            <div class="company-info">
                <div class="company-details">
                    <h1>LUXURY <span>HOTEL</span></h1>
                    <p>123 Đường Lê Lợi, TP. Huế, Việt Nam</p>
                    <p>Hotline: +84 905 123 456 | www.luxuryhotel.com</p>
                </div>
            </div>

            <div class="invoice-meta">
                <h2>Hóa đơn</h2>
                <div class="meta-item">Mã HĐ: <strong><?= $invoice['invoice_code'] ?></strong></div>
                <div class="meta-item">Ngày tạo: <strong><?= date('d/m/Y H:i', strtotime($invoice['created_at'])) ?></strong></div>
            </div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h3 class="info-box-title">Khách hàng</h3>
                <div class="info-group">
                    <span class="info-label">Họ tên:</span>
                    <span class="info-value"><?= $order['full_name'] ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">SĐT:</span>
                    <span class="info-value"><?= $order['phone'] ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?= $order['email'] ?></span>
                </div>
            </div>

            <div class="info-box">
                <h3 class="info-box-title">Chi tiết phòng</h3>
                <div class="info-group">
                    <span class="info-label">Phòng số:</span>
                    <span class="info-value room-number-highlight"><?= $order['room_number'] ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Nhận phòng:</span>
                    <span class="info-value"><?= date('d/m/Y', strtotime($order['check_in'])) ?></span>
                </div>
                <div class="info-group">
                    <span class="info-label">Trả phòng:</span>
                    <span class="info-value"><?= date('d/m/Y', strtotime($order['check_out'])) ?></span>
                </div>
            </div>
        </div>

        <table class="services-table">
            <thead>
                <tr>
                    <th>Mô tả dịch vụ</th>
                    <th class="text-right" width="150">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr class="item">
                    <td class="item-desc">
                        <strong>Tiền phòng (Accommodation)</strong>
                        <small>Dịch vụ lưu trú từ <?= date('d/m/Y', strtotime($order['check_in'])) ?> đến <?= date('d/m/Y', strtotime($order['check_out'])) ?></small>
                    </td>
                    <td class="text-right item-price">
                        <?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="totals-area">
            <div class="totals-box">
                <div class="price-row">
                    <span class="price-label">Tổng giá trị dịch vụ:</span>
                    <span class="price-value"><?= number_format($invoice['total_amount'], 0, ',', '.') ?> VNĐ</span>
                </div>

                <?php
                // Giả định ta có số tiền cọc từ order, nếu không có trong invoice
                $deposit = isset($order['deposit_amount']) ? $order['deposit_amount'] : 0;
                $remaining = $invoice['total_amount'] - $deposit;
                ?>

                <div class="price-row">
                    <span class="price-label">Tiền đã đặt cọc (Deposit):</span>
                    <span class="price-value discount">- <?= number_format($deposit, 0, ',', '.') ?> VNĐ</span>
                </div>

                <div class="price-row final">
                    <span class="final-label">Còn lại cần thanh toán:</span>
                    <span class="final-value"><?= number_format($remaining, 0, ',', '.') ?> VNĐ</span>
                </div>
            </div>
        </div>

        <div class="footer-message">
            <p>Trân trọng cảm ơn Quý khách đã lựa chọn Luxury Hotel cho kỳ nghỉ của mình.</p>
            <p>Hẹn gặp lại Quý khách!</p>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div class="signature-section">
            <div class="signature-box">
                <p>Khách hàng</p>
                <span>(Ký và ghi rõ họ tên)</span>
            </div>
            <div class="signature-box">
                <p>Xác nhận nhân viên</p>
                <span>(Ký và ghi rõ họ tên)</span>
            </div>
        </div>
    </div>

    <div class="no-print-zone">
        <button onclick="window.print()" class="btn btn-print">
            In hóa đơn
        </button>
        <button onclick="window.close()" class="btn btn-close">
            Đóng
        </button>
    </div>

</body>

</html>