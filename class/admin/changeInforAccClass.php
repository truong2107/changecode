<?php
// File: /web/class/admin/ChinhsuaClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class changeInforAccClass extends DatabaseClass {

    /**
     * Lấy thông tin của một người dùng dựa vào ID.
     * @param int $id ID của người dùng cần lấy.
     * @return array|false Mảng chứa thông tin người dùng, hoặc false nếu không tìm thấy.
     */
    protected function getUserById($id) {
        $conn = $this->connect();
        // ⭐ BẢO MẬT: Chống SQL Injection cho ID
        $sql = "SELECT * FROM nguoidung WHERE id_nguoidung = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("i", $id); // 'i' là kiểu integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            $stmt->close();
            return false; // Không tìm thấy user
        }
    }

    /**
     * Cập nhật thông tin người dùng.
     */
    protected function updateUser($id, $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa) {
        $conn = $this->connect();

        // 1. Kiểm tra email trùng lặp (loại trừ chính user này)
        $sqlCheck = "SELECT id_nguoidung FROM nguoidung WHERE email = ? AND id_nguoidung != ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("si", $email, $id);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            // Nếu tìm thấy email trùng, quay lại trang sửa với thông báo lỗi
            $stmtCheck->close();
            header("Location: /web/view/admin/changeInforAcc.php?this_id=" . $id . "&error=emailtaken");
            exit();
        }
        $stmtCheck->close();

        // 2. Nếu không trùng, tiến hành cập nhật
        $sql = "UPDATE nguoidung SET tenNguoiDung=?, tenDangNhap=?, email=?, password=?, sdt=?, diaChi=?, quan_huyen=?, phuong_xa=? WHERE id_nguoidung=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        // 'ssssssssi' -> 8 string và 1 integer (ID ở cuối)
        $stmt->bind_param("ssssssssi", $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa, $id);

        if ($stmt->execute()) {
            // Cập nhật thành công, chuyển về trang quản lý
            header("location: /web/view/admin/accountManage.php");
            exit();
        } else {
            die("Lỗi khi cập nhật người dùng: " . $stmt->error);
        }
    }
}
?>