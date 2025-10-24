<?php
// File: /web/inc/admin/ToggleUserStatusInc.php
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['tennguoidung'])) {
    header("location: /web/view/admin/index.php");
    exit();
}

// Kiểm tra xem ID và trạng thái có được gửi qua không
if (!isset($_GET['this_id']) || !isset($_GET['this_tt'])) {
    header("location: /web/view/admin/quanlytk.php");
    exit();
}

// Lấy dữ liệu từ URL
$id = $_GET['this_id'];
$status = $_GET['this_tt'];

// Gọi Controller
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ToggleUserStatusContr.php";

$toggler = new ToggleUserStatusContr($id, $status);
$toggler->processStatusToggle();
?>