<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class OrderDetailClass extends DataBaseClass {
    protected function getAnOrderById($id){
        $conn = $this->connect();
        $sql = "SELECT * FROM hoadon WHERE IdHoaDon = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    protected function getProductsInOrder($id){
        $conn = $this->connect();
        $sql = "
            SELECT sp.*, cthd.SoLuong, cthd.DonGia
            FROM chitiethoadon cthd
            JOIN sanpham sp ON cthd.MaSP = sp.MaSP
            WHERE cthd.IdHoaDon = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    protected function updateStatus($id, $status){
        $conn = $this->connect();
        $sql = "UPDATE hoadon SET TrangThai = ? WHERE IdHoaDon = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }
}
?>
