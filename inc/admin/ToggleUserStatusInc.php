<?php
session_start();


if (!isset($_SESSION['tennguoidung'])) {
    header("location: /web/view/admin/index.php");
    exit();
}


if (!isset($_GET['this_id']) || !isset($_GET['this_tt'])) {
    header("location: /web/view/admin/quanlytk.php");
    exit();
}


$id = $_GET['this_id'];
$status = $_GET['this_tt'];


require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ToggleUserStatusContr.php";

$toggler = new ToggleUserStatusContr($id, $status);
$toggler->processStatusToggle();
?>