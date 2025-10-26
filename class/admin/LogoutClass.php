<?php


class LogoutClass {


    protected function logUserOut() {
        session_start();
        session_unset();
        session_destroy();
        header("location: /web/view/admin/index.php");
        exit();
    }
}
?>