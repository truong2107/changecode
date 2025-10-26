<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductDeleteContr.php";

if(isset($_GET["id"])){
    $id = intval($_GET['id']);

    $product = new ProductDeleteContr();
    $soLuongBan = $product->getSoLuongBanTheoId($id);

    if($soLuongBan > 0){
        echo '
            <div class="warning">
                <div class="warning-content">
                    <div class="warning-title">Cảnh báo</div>
                    <div class="warning-text">Sản phẩm đã được bán, bạn có chắc muốn ẩn không?</div>
                    <div class="warning-btns">
                        <button class="btn-cancle">Hủy bỏ</button>
                        <button class="btn-save" data-act="hide">Đồng ý</button>
                    </div>
                </div>
            </div>';
    } else{
        echo '
            <div class="warning">
                <div class="warning-content">
                    <div class="warning-title">Cảnh báo</div>
                    <div class="warning-text">Sản phẩm vẫn chưa được bán, bạn có chắc muốn xóa không?</div>
                    <div class="warning-btns">
                        <button class="btn-cancle">Hủy bỏ</button>
                        <button class="btn-save" data-act="delete">Đồng ý</button>
                    </div>
                </div>
            </div>';
    }
}
?>