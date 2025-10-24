<?php
// File: /web/inc/admin/ThemmoiInc.php

if (isset($_POST['signUp'])) {
    // Lấy dữ liệu từ form
    $tenNguoiDung = $_POST['tenNguoiDung'];
    $tenDangNhap = $_POST['tenDangNhap'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sdt = $_POST['sdt'];
    $diaChi = $_POST['diaChi'];
    $quan_huyen = $_POST['quan_huyen'];
    $phuong_xa = $_POST['phuong_xa'];

    // Gọi Controller
    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/addAccountContr.php";

    $addUser = new ThemmoiContr($tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa);
    
    // Bắt đầu quá trình thêm người dùng
    $addUser->addUser();
    
} else {
    // Nếu truy cập trực tiếp file này, đá về trang quản lý
    header("Location: /web/view/admin/quanlytk.php");
    exit();
}
?>