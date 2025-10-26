<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductAddContr.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $tensp = $_POST['name'];
    $trangthai = (int) $_POST['status'];
    $giaban = $_POST['price'];
    $loaisp = (int) $_POST['category'];
    $mota = $_POST['description'];
    $anh = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../../view/img/product/" . basename($anh));

    $product = new ProductContr($loaisp, $tensp, $giaban, $mota, $anh, $trangthai, 0);
    $result = $product->addProduct();
}

    
?>