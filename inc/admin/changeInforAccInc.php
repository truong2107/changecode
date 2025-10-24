<?php
// File: /web/inc/admin/changeInforAccInc.php

if (isset($_POST['updateUser'])) {
    // Lấy toàn bộ dữ liệu từ form
    $id = $_POST['id_nguoidung'];
    $tenNguoiDung = $_POST['tenNguoiDung'];
    $tenDangNhap = $_POST['tenDangNhap'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sdt = $_POST['sdt'];
    $diaChi = $_POST['diaChi'];
    $quan_huyen = $_POST['quan_huyen'];
    $phuong_xa = $_POST['phuong_xa'];

    // Gọi Controller
    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/changeInforAccContr.php";

    $editor = new changeInforAccContr($id, $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa);
    
    // Bắt đầu quá trình cập nhật
    $editor->editUser();
    
} else {
    // Nếu truy cập trực tiếp, đá về trang quản lý
    header("Location: /web/view/admin/addAccount.php");
    exit();
}
?>