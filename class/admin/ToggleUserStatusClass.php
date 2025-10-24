<?php
// File: /web/class/admin/ToggleUserStatusClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class ToggleUserStatusClass extends DatabaseClass {

    /**
     * Cập nhật trạng thái của người dùng (từ 1->2 hoặc 2->1).
     * @param int $id ID của người dùng.
     * @param int $currentStatus Trạng thái hiện tại (1 hoặc 2).
     */
    protected function toggleStatus($id, $currentStatus) {
        // Xác định trạng thái mới
        $newStatus = ($currentStatus == 1) ? 2 : 1;
        
        $conn = $this->connect();
        
        // ⭐ BẢO MẬT: Chống SQL Injection
        $sql = "UPDATE nguoidung SET TrangThai = ? WHERE id_nguoidung = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        // 'ii' nghĩa là có 2 tham số đều là kiểu integer
        $stmt->bind_param("ii", $newStatus, $id);
        
        if ($stmt->execute()) {
            // Cập nhật thành công, chuyển hướng về trang quản lý
            $stmt->close();
            header("location: /web/view/admin/accountManage.php");
            exit();
        } else {
            die("Lỗi khi cập nhật trạng thái: " . $stmt->error);
        }
    }
}
?>