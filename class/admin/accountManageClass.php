<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class AccountManageClass extends DatabaseClass {


    protected function getUsers() {
        $conn = $this->connect();
        $sql = "SELECT * FROM nguoidung WHERE vaiTro = 'user' ORDER BY id_nguoidung DESC";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();


        $users = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        
        return $users;
    }
}
?>