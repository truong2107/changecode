<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/ProductAddClass.php"; 

class ProductAddContr extends ProductAddClass{
    private $tenSP;
    private $gia;
    private $moTa;
    private $maLoaiSP;
    private $anh;
    private $trangthai;
    private $soLuongBan;

    public function __construct($maLoaiSP, $tenSP, $gia, $moTa, $anh, $trangThai, $soLuongBan){
        $this->maLoaiSP = $maLoaiSP;
        $this->tenSP = $tenSP;
        $this->gia = $gia;
        $this->moTa = $moTa;
        $this->anh = $anh;
        $this->trangthai = $trangThai;
        $this->soLuongBan = $soLuongBan;
    }

    public function addProduct(){
        $this->insertProduct($this->maLoaiSP, $this->tenSP, $this->gia, $this->moTa, $this->anh, $this->trangthai, $this->soLuongBan);
    }
}

?>