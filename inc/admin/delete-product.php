<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductDeleteContr.php";


if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $product = new ProductDeleteContr();
    $result = $product->xoaSanPhamTheoId($id);

    if ($result) {
        echo "Sản phẩm đã được xóa thành công!";
    } else {
        echo "Lỗi khi xóa sản phẩm!";
    }
} else {
    echo "Thiếu Id sản phẩm!";
}
?>
