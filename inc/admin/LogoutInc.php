<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/LogoutContr.php";

$logout = new LogoutContr();
$logout->processLogout();
?>