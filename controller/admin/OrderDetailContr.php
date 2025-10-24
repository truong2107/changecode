<?php
// File: /web/controller/admin/CustomerHistoryContr.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/OrderDetailClass.php"; 

class CustomerHistoryContr extends CustomerHistoryClass {
    
    public function showCustomerHistory($userId, $fromDate, $toDate) {
        $data = $this->getCustomerHistory($userId, $fromDate, $toDate);
        return $data;
    }
}
?>