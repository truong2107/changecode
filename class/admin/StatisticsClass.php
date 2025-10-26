<?php
// File: /web/class/admin/StatisticsClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class StatisticsClass extends DatabaseClass {


    protected function getTopCustomersByDateRange($fromDate, $toDate) {
        $conn = $this->connect();
        
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

        $stmt->bind_param("ss", $fromDate, $toDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $data;
    }
}
?>