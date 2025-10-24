<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class AccountManageClass extends DatabaseClass {

    /**
     * Lấy tất cả người dùng có vai trò là 'user' từ CSDL.
     * @return array Mảng chứa thông tin của tất cả người dùng.
     */
    protected function getUsers() {
        $conn = $this->connect();
        $sql = "SELECT * FROM nguoidung WHERE vaiTro = 'user' ORDER BY id_nguoidung DESC";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Lấy tất cả các dòng kết quả vào một mảng
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        
        // Trả về mảng dữ liệu người dùng
        return $users;
    }
}
?>