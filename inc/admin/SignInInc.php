<?php


if (isset($_POST['signIn'])) {

    $tenDangNhap = $_POST['tenDangNhap'];
    $password = $_POST['password'];


    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/SignInContr.php";

    $signIn = new AdminSignInContr($tenDangNhap, $password);
    $signIn->signInAdmin();
    
} else {

    header("Location: /web/view/admin/index.php");
    exit();
}
?>