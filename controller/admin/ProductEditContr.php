<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/ProductClass.php"; 

class ProductEditContr extends ProductClass{
    private $maSP;
    private $tenSP;
    private $gia;
    private $moTa;
    private $maLoaiSP;
    private $anh;
    private $trangthai;
    private $soLuongBan;

    public function __construct($maSP = null, $maLoaiSP = null, $tenSP = null, $gia = null, $moTa = null, $anh = null, $trangThai = null){
        $this->maSP = $maSP;
        $this->maLoaiSP = $maLoaiSP;
        $this->tenSP = $tenSP;
        $this->gia = $gia;
        $this->moTa = $moTa;
        $this->anh = $anh;
        $this->trangthai = $trangThai;
    }

    public function getSanPhamQuaId($id){

        $result = $this->getSanPham($id);
        $product = mysqli_fetch_array($result);

        if(!$product){
            header("Location: ../../view/admin/admin.product.php");
            exit();
        }

        return $product;
    }

    public function getNameCategoryById($id){
        $result = $this->getNameCategory($id);
        $nameCategory = (mysqLi_fetch_array($result))["TenLoaiSP"];

        return $nameCategory;
    }

    public function getCategoriesButId($id){
        $result = $this->getOtherCategories($id);
        $categories = [];


        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $categories[] = $row;
            }
        }
        return $categories;
    }

    public function editProduct(){
        $this->updateProduct($this->maSP, $this->maLoaiSP, $this->tenSP, $this->gia, $this->moTa, $this->anh, $this->trangthai);
    }
}

?>