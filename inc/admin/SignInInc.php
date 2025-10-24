<?php
// File: /web/inc/admin/AdminSignInInc.php

if (isset($_POST['signIn'])) {
    // Lấy dữ liệu từ form
    $tenDangNhap = $_POST['tenDangNhap'];
    $password = $_POST['password'];

    // Gọi Controller
    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/SignInContr.php";

    $signIn = new AdminSignInContr($tenDangNhap, $password);
    $signIn->signInAdmin();
    
} else {
    // Nếu truy cập trực tiếp file này, đá về trang đăng nhập
    header("Location: /web/view/admin/index.php");
    exit();
}
?>