<?php
// File: /web/controller/admin/AccountManageContr.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/accountManageClass.php"; 

class AccountManageContr extends AccountManageClass {

    public function showUsers() {
        $usersData = $this->getUsers();
        return $usersData;
    }
}
?>