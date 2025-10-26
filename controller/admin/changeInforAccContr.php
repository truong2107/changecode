<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/changeInforAccClass.php"; 

class changeInforAccContr extends changeInforAccClass {

    private $id;
    private $tenNguoiDung;
    private $tenDangNhap;
    private $email;
    private $password;
    private $sdt;
    private $diaChi;
    private $quan_huyen;
    private $phuong_xa;


    public function __construct($id=null, $tenNguoiDung=null, $tenDangNhap=null, $email=null, $password=null, $sdt=null, $diaChi=null, $quan_huyen=null, $phuong_xa=null) {
        if ($id) {
            $this->id = $id;
            $this->tenNguoiDung = $tenNguoiDung;
            $this->tenDangNhap = $tenDangNhap;
            $this->email = $email;
            $this->password = $password;
            $this->sdt = $sdt;
            $this->diaChi = $diaChi;
            $this->quan_huyen = $quan_huyen;
            $this->phuong_xa = $phuong_xa;
        }
    }

    public function showUser($id) {
        $userData = $this->getUserById($id);
        return $userData;
    }

    public function editUser() {
        $this->updateUser($this->id, $this->tenNguoiDung, $this->tenDangNhap, $this->email, $this->password, $this->sdt, $this->diaChi, $this->quan_huyen, $this->phuong_xa);
    }
}
?>