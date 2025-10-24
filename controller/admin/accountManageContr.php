<?php
// File: /web/controller/admin/AccountManageContr.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/accountManageClass.php"; 

class AccountManageContr extends AccountManageClass {

    /**
     * Phương thức công khai để View gọi và lấy danh sách người dùng.
     * @return array Mảng dữ liệu người dùng.
     */
    public function showUsers() {
        $usersData = $this->getUsers();
        return $usersData;
    }
}
?>