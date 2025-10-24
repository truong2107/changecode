<?php
// File: /web/controller/admin/AdminSignInContr.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/SignInClass.php"; 

class AdminSignInContr extends AdminSignInClass {
    private $tenDangNhap;
    private $password;

    public function __construct($tenDangNhap, $password) {
        $this->tenDangNhap = $tenDangNhap;
        $this->password = $password;
    }

    public function signInAdmin() {
        $this->getAdminUser($this->tenDangNhap, $this->password);
    }
}
?>