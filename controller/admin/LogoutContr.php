<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/LogoutClass.php"; 

class LogoutContr extends LogoutClass {

    public function __construct() {

    }

    public function processLogout() {
        $this->logUserOut();
    }
}
?>