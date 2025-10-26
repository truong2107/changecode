<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class ThemmoiClass extends DatabaseClass {

    protected function checkUserExists($tenDangNhap, $email) {
        $conn = $this->connect();
        
        // Câu lệnh SQL an toàn để kiểm tra cả hai cột
        $sql = "SELECT tenDangNhap FROM nguoidung WHERE tenDangNhap = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("ss", $tenDangNhap, $email);
        $stmt->execute();
        $stmt->store_result(); // Lưu kết quả để có thể đếm số dòng
        
        // Nếu số dòng > 0, nghĩa là đã tìm thấy người dùng -> trả về true
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true; 
        }
        
        // Nếu không tìm thấy, trả về false
        $stmt->close();
        return false;
    }

    /**
     * THÊM NGƯỜI DÙNG MỚI VÀO CSDL.
     * Hàm này sẽ gọi hàm checkUserExists() trước khi thêm.
     */
    protected function setUser($tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa) {
        
        // **LOGIC QUAN TRỌNG:** Gọi hàm kiểm tra.
        // Nếu hàm checkUserExists() trả về true (nghĩa là user ĐÃ TỒN TẠI)...
        if ($this->checkUserExists($tenDangNhap, $email)) {
            // ...thì lập tức chuyển hướng về trang thêm mới với mã lỗi.
            header("Location: /web/view/admin/addAccount.php?error=useroremailtaken");
            exit(); // Dừng thực thi ngay lập tức
        }

        // Nếu không trùng, tiếp tục thực hiện thêm mới vào CSDL
        $conn = $this->connect();
        $sql = "INSERT INTO nguoidung (tenNguoiDung, tenDangNhap, email, password, sdt, diaChi, quan_huyen, phuong_xa) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        // ⭐ Cải tiến bảo mật: Mã hóa mật khẩu trước khi lưu
        // $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        // $stmt->bind_param("ssssssss", ..., $hashedPwd, ...);
        
        $stmt->bind_param("ssssssss", $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa);
        
        if ($stmt->execute()) {
            // Thêm thành công, chuyển về trang quản lý
            header("location: /web/view/admin/accountManage.php");
            exit();
        } else {
            die("Lỗi khi thêm người dùng: " . $stmt->error);
        }
    }
}
?>