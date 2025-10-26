<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class AdminSignInClass extends DatabaseClass {

    protected function getAdminUser($tenDangNhap, $password) {
        $conn = $this->connect();
        

        $sql = "SELECT * FROM nguoidung WHERE tenDangNhap = ? AND password = ? AND vaiTro = 'admin'";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
            exit();
        }


        $stmt->bind_param("ss", $tenDangNhap, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            $stmt->close();
            header("Location: /web/view/admin/index.php?error=wrong-user-or-pass");
            exit();
        } 
        else {
            $row = $result->fetch_assoc();

            
            if ($row['TrangThai'] != 1) {
                $stmt->close();
                header("Location: /web/view/admin/index.php?error=block-user");
                exit();
            }


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
            header("location: /web/view/admin/accountManage.php"); 
        }
    }
}
?>