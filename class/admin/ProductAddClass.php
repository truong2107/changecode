<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class ProductAddClass extends DataBaseClass{
    
    protected function insertProduct($maLoaiSP, $tenSP, $gia, $moTa, $anh, $trangthai, $soLuongBan){
        $conn = $this->connect();

        $sql = "INSERT INTO sanpham (MaLoaiSP, TenSP, DonGia, SoLuongBan, MoTa, HinhAnh, TrangThai) VALUES ('$maLoaiSP', '$tenSP', '$gia', '$soLuongBan', '$moTa', '$anh', '$trangthai' )";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../../view/admin/admin.product.php");
            exit();
        } else {
            echo "Lỗi khi thêm sản phẩm: " . mysqli_error($conn);
        }
    }
}

?>