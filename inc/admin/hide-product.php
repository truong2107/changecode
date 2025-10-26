<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductDeleteContr.php";


if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $product = new ProductDeleteContr();
    $result = $product->anSanPhamTheoId($id);

    if ($result) {
        echo "Sản phẩm đã được ẩn!";
    } else {
        echo "Lỗi khi cập nhật trạng thái!";
    }
} else {
    echo "Thiếu Id sản phẩm!";
}
?>
