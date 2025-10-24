<?php
// File: /web/class/admin/StatisticsClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class StatisticsClass extends DatabaseClass {

    /**
     * Lấy top 5 khách hàng mua nhiều nhất trong một khoảng thời gian.
     * @param string $fromDate Ngày bắt đầu (định dạng Y-m-d).
     * @param string $toDate Ngày kết thúc (định dạng Y-m-d).
     * @return array Mảng chứa dữ liệu thống kê.
     */
    protected function getTopCustomersByDateRange($fromDate, $toDate) {
        $conn = $this->connect();
        
        // ⭐ BẢO MẬT: Chống SQL Injection bằng Prepared Statements
        $sql = "SELECT 
                    COUNT(h.TongTien) as sldon,
                    SUM(h.TongTien) AS sotien,
                    h.IdNguoiDung as id,
                    n.tenNguoiDung as ten 
                FROM hoadon h
                JOIN nguoidung n ON h.IdNguoiDung = n.id_nguoidung 
                WHERE 
                    h.NgayDatHang >= ? 
                    AND DATE(h.NgayDatHang) <= ? 
                    AND h.TrangThai = '3' 
                GROUP BY h.IdNguoiDung 
                ORDER BY sotien DESC 
                LIMIT 5";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        // 'ss' nghĩa là có 2 tham số đều là kiểu string
        $stmt->bind_param("ss", $fromDate, $toDate);
        $stmt->execute();
        $result = $stmt->get_result();

        // Lấy tất cả các dòng kết quả vào một mảng
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $data;
    }
}
?>