<?php
// File: /web/inc/admin/LogoutInc.php

// Gọi Controller để bắt đầu quá trình đăng xuất
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/LogoutContr.php";

$logout = new LogoutContr();
$logout->processLogout();
?>