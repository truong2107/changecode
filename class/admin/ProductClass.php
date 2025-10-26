<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class ProductClass extends DataBaseClass{

    protected function getAllProducts(){
        $conn = $this->connect();
        $sql = "SELECT * FROM sanpham ORDER BY MaSP ASC";
        $result = $conn->query($sql);

        if(!$result){
            die("Lỗi truy vấn: " . $conn->error);
        }

        return $result;
    }

    protected function getAllProductCategories(){   
        $conn = $this->connect();
        $sql = "SELECT * FROM loaisanpham ORDER BY MaLoaiSP ASC";
         
        $result = $conn->query($sql);

        if(!$result){
            die("Lỗi truy vấn: " . $conn->error);
        }

        return $result;
    }
}
?>