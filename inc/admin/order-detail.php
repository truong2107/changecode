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

// Xử lý status
$status = isset($_GET['status']) ? intval($_GET['status']) : intval($order["TrangThai"]);
$result = $orderDetailContr->updateStatus($id, $status);

// Nếu cần redirect về URL chuẩn
if (isset($result['redirect'])) {
  ob_clean();
  header("Location: " . $result['redirect']);
  exit();
}

// Trạng thái hiện tại
$currentStatus = $result['currentStatus'] ?? intval($order["TrangThai"]);

// Lấy sản phẩm trong đơn
$products = $orderDetailContr->getProducts($id);
?>
