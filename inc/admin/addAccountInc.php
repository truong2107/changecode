<?php


if (isset($_POST['signUp'])) {

    $tenNguoiDung = $_POST['tenNguoiDung'];
    $tenDangNhap = $_POST['tenDangNhap'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sdt = $_POST['sdt'];
    $diaChi = $_POST['diaChi'];
    $quan_huyen = $_POST['quan_huyen'];
    $phuong_xa = $_POST['phuong_xa'];


    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/addAccountContr.php";

    $addUser = new ThemmoiContr($tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa);
    

    $addUser->addUser();
    
} else {

    header("Location: /web/view/admin/quanlytk.php");
    exit();
}
?>