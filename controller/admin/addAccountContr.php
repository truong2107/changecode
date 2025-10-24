<?php
// File: /web/controller/admin/ThemmoiContr.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/addAccountClass.php"; 

class ThemmoiContr extends ThemmoiClass {
    // Các thuộc tính để lưu dữ liệu từ form
    private $tenNguoiDung;
    private $tenDangNhap;
    private $email;
    private $password;
    private $sdt;
    private $diaChi;
    private $quan_huyen;
    private $phuong_xa;

    public function __construct($tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa) {
        $this->tenNguoiDung = $tenNguoiDung;
        $this->tenDangNhap = $tenDangNhap;
        $this->email = $email;
        $this->password = $password;
        $this->sdt = $sdt;
        $this->diaChi = $diaChi;
        $this->quan_huyen = $quan_huyen;
        $this->phuong_xa = $phuong_xa;
    }

    public function addUser() {
        // Gọi phương thức của class cha để bắt đầu xử lý
        $this->setUser($this->tenNguoiDung, $this->tenDangNhap, $this->email, $this->password, $this->sdt, $this->diaChi, $this->quan_huyen, $this->phuong_xa);
    }
}
?>