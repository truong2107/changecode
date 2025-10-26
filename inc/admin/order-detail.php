<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/Order-DetailContr.php";

$orderDetailContr = new OrderDetailContr();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: ../../view/admin/admin.order.php");
  exit();
}
$id = intval($_GET['id']);

$order = $orderDetailContr->getOrder($id);
if (!$order) {
  header("Location: ../../view/admin/admin.order.php");
  exit();
}


$status = isset($_GET['status']) ? intval($_GET['status']) : intval($order["TrangThai"]);
$result = $orderDetailContr->updateStatus($id, $status);


if (isset($result['redirect'])) {
  ob_clean();
  header("Location: " . $result['redirect']);
  exit();
}


$currentStatus = $result['currentStatus'] ?? intval($order["TrangThai"]);


$products = $orderDetailContr->getProducts($id);
?>
