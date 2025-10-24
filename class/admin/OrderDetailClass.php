<?php
// File: /web/class/admin/CustomerHistoryClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class CustomerHistoryClass extends DatabaseClass {

    /**
     * Lấy toàn bộ lịch sử mua hàng của một khách hàng trong khoảng thời gian.
     * @param int $userId ID của người dùng.
     * @param string $fromDate Ngày bắt đầu (Y-m-d).
     * @param string $toDate Ngày kết thúc (Y-m-d).
     * @return array|false Mảng chứa thông tin khách hàng và các đơn hàng, hoặc false nếu không có.
     */
    protected function getCustomerHistory($userId, $fromDate, $toDate) {
        $conn = $this->connect();
        $history = [];

        // 1. Lấy thông tin cơ bản của người dùng
        $sqlUser = "SELECT tenNguoiDung, email, sdt FROM nguoidung WHERE id_nguoidung = ?";
        $stmtUser = $conn->prepare($sqlUser);
        if (!$stmtUser) { die("Lỗi SQL: " . $conn->error); }
        $stmtUser->bind_param("i", $userId);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        if ($resultUser->num_rows === 0) {
            return false; // Không tìm thấy người dùng
        }
        $history['customer'] = $resultUser->fetch_assoc();
        $stmtUser->close();

        // 2. Lấy tất cả các hóa đơn của người dùng trong khoảng thời gian
        $sqlOrders = "SELECT IdHoaDon, NgayDatHang, TongTien FROM hoadon 
                      WHERE IdNguoiDung = ? AND NgayDatHang >= ? AND DATE(NgayDatHang) <= ? AND TrangThai = '3' 
                      ORDER BY NgayDatHang DESC";
        $stmtOrders = $conn->prepare($sqlOrders);
        if (!$stmtOrders) { die("Lỗi SQL: " . $conn->error); }
        $stmtOrders->bind_param("iss", $userId, $fromDate, $toDate);
        $stmtOrders->execute();
        $resultOrders = $stmtOrders->get_result();
        $orders = $resultOrders->fetch_all(MYSQLI_ASSOC);
        $stmtOrders->close();

        // 3. Lấy chi tiết sản phẩm cho TẤT CẢ các hóa đơn tìm được trong một lần truy vấn
        $orderIds = array_column($orders, 'IdHoaDon');
        if (empty($orderIds)) {
            $history['orders'] = [];
            return $history;
        }
        $placeholders = implode(',', array_fill(0, count($orderIds), '?')); // Tạo chuỗi ?,?,?
        $sqlDetails = "SELECT c.IdHoaDon, s.TenSP, s.HinhAnh, c.DonGia, c.SoLuong 
                       FROM chitiethoadon c 
                       JOIN sanpham s ON s.MaSP = c.MaSP 
                       WHERE c.IdHoaDon IN ($placeholders)";
        $stmtDetails = $conn->prepare($sqlDetails);
        if (!$stmtDetails) { die("Lỗi SQL: " . $conn->error); }
        // Bind ID của các hóa đơn vào câu lệnh
        $stmtDetails->bind_param(str_repeat('i', count($orderIds)), ...$orderIds);
        $stmtDetails->execute();
        $resultDetails = $stmtDetails->get_result();
        $details = $resultDetails->fetch_all(MYSQLI_ASSOC);
        $stmtDetails->close();
        
        // 4. Gộp dữ liệu: Thêm mảng 'products' vào mỗi đơn hàng
        foreach ($orders as &$order) { // Dùng tham chiếu & để sửa trực tiếp
            $order['products'] = [];
            foreach ($details as $detail) {
                if ($detail['IdHoaDon'] == $order['IdHoaDon']) {
                    $order['products'][] = $detail;
                }
            }
        }

        $history['orders'] = $orders;
        return $history;
    }
}
?>