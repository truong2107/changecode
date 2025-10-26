<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class ToggleUserStatusClass extends DatabaseClass {
    protected function toggleStatus($id, $currentStatus) {
        $newStatus = ($currentStatus == 1) ? 2 : 1;
        
        $conn = $this->connect();
        
        $sql = "UPDATE nguoidung SET TrangThai = ? WHERE id_nguoidung = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("ii", $newStatus, $id);
        
        if ($stmt->execute()) {
            $stmt->close();
            header("location: /web/view/admin/accountManage.php");
            exit();
        } else {
            die("Lỗi khi cập nhật trạng thái: " . $stmt->error);
        }
    }
}
?>