<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductEditContr.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productContr = new ProductEditContr();

    $id = (int) $_GET['id'];    
    if (isset($id)) {
        $product = $productContr->getSanPhamQuaId($id);

        $ten = $_POST['name'];
        $trangthai = (int) $_POST['status'];
        $giaban = $_POST['price'];
        $loaisp = (int) $_POST['category'];
        $mota = $_POST['description'];

        $anh = $_FILES['image']['name'];    
        $removeImage = (int) $_POST['removeImage'];
        $currentImage = $_POST['imageFileName']; 

    
        if ($removeImage == 1 && !empty($product['HinhAnh']) && file_exists("../../view/img/product/" . $product['HinhAnh'])) {
            unlink("../../view/img/product/" . $product['HinhAnh']);
        }
        
        if (!empty($anh)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../../view/img/product/" . basename($anh));
            $productEdit = new ProductEditContr($id, $loaisp, $ten, $giaban, $mota, $anh, $trangthai);
            $productEdit->editProduct();
        } else {
            $productEdit = new ProductEditContr($id, $loaisp, $ten, $giaban, $mota, $currentImage, $trangthai);
            $productEdit->editProduct();
        }
    }
}    
?>