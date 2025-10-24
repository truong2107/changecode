<?php
// File: /web/controller/admin/LogoutContr.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/LogoutClass.php"; 

class LogoutContr extends LogoutClass {

    public function __construct() {
        // Không cần làm gì ở đây
    }

    public function processLogout() {
        $this->logUserOut();
    }
}
?>