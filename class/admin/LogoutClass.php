<?php
// File: /web/class/admin/LogoutClass.php

class LogoutClass {

    /**
     * Thực hiện việc đăng xuất bằng cách hủy toàn bộ session.
     */
    protected function logUserOut() {
        // Bắt đầu session để có thể thao tác với nó
        session_start();
        
        // Hủy tất cả các biến trong session
        session_unset();
        
        // Hủy bỏ hoàn toàn phiên làm việc
        session_destroy();
        
        // Chuyển hướng người dùng về trang đăng nhập admin
        header("location: /web/view/admin/index.php");
        exit();
    }
}
?>