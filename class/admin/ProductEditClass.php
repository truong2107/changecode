<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class ProductEditClass extends DataBaseClass {
    
    protected function getSanPham($id){
        $conn = $this->connect();
        $sql = "SELECT * FROM sanpham WHERE MaSP = '$id'";

        return mysqli_query($conn, $sql);
    }

    protected function getNameCategory($id){
        $conn = $this->connect();
        $sql = "SELECT TenLoaiSP FROM loaisanpham WHERE MaLoaiSP = '$id'";

        return mysqli_query($conn, $sql);
    }

    protected function getOtherCategories($id){
        $conn = $this->connect();
        $sql = "SELECT * FROM loaisanpham WHERE MaLoaiSP <> '$id'";

        return mysqli_query($conn, $sql);
    }
    
    protected function updateProduct($maSP, $maLoaiSP, $tenSP, $gia, $moTa, $anh, $trangThai){
        $conn = $this->connect();
        $sql = "UPDATE sanpham SET MaLoaiSP = '$maLoaiSP', TenSP = '$tenSP', DonGia = '$gia', MoTa = '$moTa', HinhAnh = '$anh', TrangThai = '$trangThai' WHERE MaSP = $maSP";

        if(mysqli_query($conn, $sql)){
            header("Location: ../../view/admin/admin.product.php");
            exit();
        }
    }
}
?>