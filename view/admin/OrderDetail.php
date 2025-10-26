<?php
session_start();
if (!isset($_SESSION['tennguoidung'])) {
    header("location: index.php");
    exit();
}

// Lấy thông tin từ URL
$userId = isset($_GET['thisid']) ? (int)$_GET['thisid'] : 0;
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';

if ($userId <= 0 || empty($from) || empty($to)) {
    header("location: Statistics.php");
    exit();
}

// Gọi Controller để lấy dữ liệu
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/OrderDetailContr.php";
$historyController = new CustomerHistoryContr();
$data = $historyController->showCustomerHistory($userId, $from, $to);

// Nếu không tìm thấy khách hàng, thông báo lỗi
if (!$data) {
    die("Không tìm thấy thông tin khách hàng.");
}
$customer = $data['customer'];
$orders = $data['orders'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử mua hàng của <?php echo htmlspecialchars($customer['tenNguoiDung']); ?></title>
    <link href="../../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon"/>
    <link rel="stylesheet" href="css/OrderDetail.css">
    <style> /* ... dán toàn bộ CSS từ file gốc vào đây ... */ </style>
</head>
<body>
<div class="ThongTin">
    <div class="content">
        <div class="KhachHang">
            <h2 style="color: #f37319">Chi tiết các món ăn đã đặt</h2>
            <p><b>Tên khách hàng:</b> <?php echo htmlspecialchars($customer['tenNguoiDung']); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($customer['email']); ?></p>
            <p><b>Số điện thoại:</b> <?php echo htmlspecialchars($customer['sdt']); ?></p>
        </div>
        <div class="oders">
            <?php if (empty($orders)): ?>
                <p>Khách hàng không có đơn hàng nào trong khoảng thời gian này.</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <h3 style="color: #f37319">Đơn hàng #<?php echo $order['IdHoaDon']; ?> (<?php echo date('d/m/Y H:i', strtotime($order['NgayDatHang'])); ?>)</h3>
                    <table class="food-table">
                        <thead>
                            <tr>
                                <th>Tên món ăn</th>
                                <th>Hình ảnh</th>
                                <th>Giá (VNĐ)</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['products'] as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['TenSP']); ?></td>
                                    <td><img src="../img/product/<?php echo htmlspecialchars($product['HinhAnh']); ?>" alt=""></td>
                                    <td><?php echo number_format($product['DonGia'], 0, '', '.'); ?></td>
                                    <td><?php echo $product['SoLuong']; ?></td>
                                    <td><?php echo number_format($product['DonGia'] * $product['SoLuong'], 0, '', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"><b>Tổng tiền đơn hàng:</b></td>
                                <td><b><?php echo number_format($order['TongTien'], 0, '', '.'); ?></b></td>
                            </tr>
                        </tfoot>
                    </table>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="goback">
            <button onclick="window.history.back()">Quay lại</button>
        </div>
    </div>
</div>
</body>
</html>