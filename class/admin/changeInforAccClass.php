<?php
// File: /web/class/admin/ChinhsuaClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class changeInforAccClass extends DatabaseClass {


    protected function getUserById($id) {
        $conn = $this->connect();

        $sql = "SELECT * FROM nguoidung WHERE id_nguoidung = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            $stmt->close();
            return false; 
        }
    }


    protected function updateUser($id, $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa) {
        $conn = $this->connect();


        $sqlCheck = "SELECT id_nguoidung FROM nguoidung WHERE email = ? AND id_nguoidung != ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("si", $email, $id);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {

            $stmtCheck->close();
            header("Location: /web/view/admin/changeInforAcc.php?this_id=" . $id . "&error=emailtaken");
            exit();
        }
        $stmtCheck->close();


        $sql = "UPDATE nguoidung SET tenNguoiDung=?, tenDangNhap=?, email=?, password=?, sdt=?, diaChi=?, quan_huyen=?, phuong_xa=? WHERE id_nguoidung=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("ssssssssi", $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa, $id);

        if ($stmt->execute()) {
            header("location: /web/view/admin/accountManage.php");
            exit();
        } else {
            die("Lỗi khi cập nhật người dùng: " . $stmt->error);
        }
    }
}
?>