<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/Order-DetailClass.php"; 

class OrderDetailContr extends OrderDetailClass{
    public function getOrder($id){
        $result = parent::getAnOrderById($id);
        return mysqli_fetch_array($result);
    }

    public function getProducts($id){
        $result = parent::getProductsInOrder($id);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status) {
        $order = $this->getOrder($id);
        if (!$order) return ['redirect' => 'admin.order.php'];

        $currentStatus = intval($order["TrangThai"]);
        $requestedStatus = intval($status);

        if ($requestedStatus < 1 || $requestedStatus > 4) {
            return ['redirect' => "admin.order-detail.php?id=$id&status=$currentStatus"];
        }

        if ($requestedStatus !== $currentStatus) {
            parent::updateStatus($id, $requestedStatus);
            return ['redirect' => "admin.order-detail.php?id=$id&status=$requestedStatus"];
        }

        return ['currentStatus' => $currentStatus];
    }
}

?>