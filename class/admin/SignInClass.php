<?php
// File: /web/class/admin/AdminSignInClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class AdminSignInClass extends DatabaseClass {

    protected function getAdminUser($tenDangNhap, $password) {
        $conn = $this->connect();
        
        // ⭐ BẢO MẬT: Chống SQL Injection bằng Prepared Statements
        // Thêm điều kiện `vaiTro = 'admin'` vào câu truy vấn
        $sql = "SELECT * FROM nguoidung WHERE tenDangNhap = ? AND password = ? AND vaiTro = 'admin'";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
            exit();
        }

        // Gắn biến vào câu lệnh (s = string)
        $stmt->bind_param("ss", $tenDangNhap, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Không tìm thấy admin
        if ($result->num_rows === 0) {
            $stmt->close();
            header("Location: /web/view/admin/index.php?error=wrong-user-or-pass");
            exit();
        } 
        
        // Tìm thấy admin, tiến hành kiểm tra
        else {
            $row = $result->fetch_assoc();

            // Kiểm tra trạng thái bị khóa (TrangThai khác 1 là bị khóa hoặc chưa kích hoạt)
            if ($row['TrangThai'] != 1) {
                $stmt->close();
                header("Location: /web/view/admin/index.php?error=block-user");
                exit();
            }

            // Đăng nhập thành công
            session_start();
            $_SESSION['tennguoidung'] = $row['tenNguoiDung'];
            $_SESSION['tenDangNhapadmin'] = $row['tenDangNhap'];
            $_SESSION['emailadmin'] = $row['email'];
            $_SESSION['passwordadmin'] = $row['password'];
            $_SESSION['sdtadmin'] = $row['sdt'];
            $_SESSION['diaChiadmin'] = $row['diaChi']; 
            $_SESSION['quan_huyenadmin'] = $row['quan_huyen'];
            $_SESSION['phuong_xaadmin'] = $row['phuong_xa'];
            $_SESSION['roleadmin'] = "admin";

            $stmt->close();
            header("location: /web/view/admin/accountManage.php"); // Chuyển đến trang quản lý tài khoản
            exit();
        }
    }
}
?>