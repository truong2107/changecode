<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/ProductDeleteClass.php"; 

class ProductDeleteContr extends ProductDeleteClass{

    public function getSoLuongBanTheoId($id){
        return $this->getSoLuongBanDB($id);
    }

    public function xoaSanPhamTheoId($id){
        return $this->xoaSanPham($id);
    }

    public function anSanPhamTheoId($id){
        return $this->anSanPham($id);
    }
}

?>