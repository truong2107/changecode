<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class ProductDeleteClass extends DataBaseClass{
    protected function getSoLuongBanDB($id){
        $conn = $this->connect();
        $sql = "SELECT SoLuongBan FROM sanpham WHERE MaSP = '$id'";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['SoLuongBan'];
        }
    }

    protected function xoaSanPham($id){
        $conn = $this->connect();
        $sql = "SELECT * FROM sanpham WHERE MaSP = '$id'";
        $result = mysqli_query($conn, $sql);

        if($result && $row = $result->fetch_assoc()){
            unlink("../../view/img/product/" . $row['HinhAnh']);
        }
       
        $sql1 = "DELETE FROM sanpham WHERE MaSP = '$id'";

        return mysqli_query($conn, $sql1);
    }

    protected function anSanPham($id){
        $conn = $this->connect();
        $sql = "UPDATE sanpham SET TrangThai = 0 WHERE MaSP = '$id'";

        return mysqli_query($conn, $sql);
    }
}
?>