<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductEditContr.php";
$productContr = new ProductEditContr();

session_start();
if(!isset($_SESSION['tennguoidung'])){
  header("location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="../img/DMTD-Food-Logo.jpg"
      rel="shortcut icon"
      type="image/x-icon"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="./css/admin.add-product.css" />
    <link rel="stylesheet" href="./css/index.css" />
    <link
      rel="shortcut icon"
      href="../assets/img/DMTD-Food-Logo.jpg"
      type="image/x-icon"
    />
    <title>DMTD FOOD</title>
  </head>

  <body>
    <div class="classQuanLy">
      <!-- Menu -->
      <div class="menu">
        <i class="fa-solid fa-bars"></i>
        <div class="logo">
          <div>
            <img
              src="../img/DMTD-Food-Logo.jpg"
              alt=""
            />
            <h4 style="white-space: unset"><?php echo $_SESSION['tennguoidung'];?></h4>

            Chào mừng bạn trở lại
          </div>
        </div>
        <div class="innermenu">
        <ul>
            <li>
              <a href="chonngay.php" class="menu-1">Thống kê</a>
            </li>
            <li><a href="admin.product.php" class="menu-1">Sản phẩm</a></li>
            <li><a href="admin.order.php" class="menu-1">Đơn hàng</a></li>
            <li>
              <a href="./quanlytk.php" class="menu-1">Tài khoản khách hàng</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- Header -->
      <div class="out">
        <div class="menu-toggle">
          <i class="fa-solid fa-bars"></i>
        </div>
        <a href="index.html" style="color: inherit">
          <div class="out1">
          <a href="dangxuat.php"> <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
          </div>
        </a>
      </div>
      <!-- Content -->
      <div class="content">
        <main>
          <div class="title">
            <h2>Danh sách sản phẩm / Sửa sản phẩm</h2>
          </div>

          <div class="addProduct">
            <h3 class="titleAddProduct">Sửa sản phẩm</h3>
            <form  method="POST" enctype="multipart/form-data" action="../../inc/admin/editProduct.php?id=<?php echo (int)$_GET['id'] ?>">
              <div class="infoProduct">
                <?php 
                  $id = (int)$_GET['id'];
                  if(isset($id)){
                    $product = $productContr->getSanPhamQuaId($id);
                  }
                ?>
                <div class="form-group">
                  <label class="control-label">Tên sản phẩm</label>
                  <input class="form-control" type="text" name="name" value ="<?php echo $product['TenSP']?>" required/>
                </div>
                <div class="form-group">
                  <label for="selectform" class="control-label">Trạng thái</label>
                  <select class="form-control" id="selectform" name="status" required>
                    <?php 
                      if($product['TrangThai'] == 0){
                        echo '
                          <option value="0" selected>Dừng hoạt động</option>
                          <option value="1">Hoạt động</option>
                        ';
                      }
                      else{
                        echo '
                          <option value="1" selected>Hoạt động</option>
                          <option value="0">Dừng hoạt động</option>
                        ';
                      }
                    ?>>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Giá bán</label>
                  <input class="form-control" type="number" name="price" min="0" value="<?php echo $product['DonGia']?>" required/>
                </div>
                <div class="form-group">
                  <label for="selectform" class="control-label">Loại</label>
                  <select class="form-control" id="selectform" name="category" required>
                    <?php 
                      $nameCategory = $productContr->getNameCategoryById($product["MaLoaiSP"]);
                    ?>
                    <option value="<?php echo $product['MaLoaiSP'] ?>"> <?php echo $nameCategory ?> </option>
                    <?php
                      $otherCategories = $productContr->getCategoriesButId($product["MaLoaiSP"]);

                      foreach ($otherCategories as $productCategory) {
                    ?>
                      <option value="<?php echo $productCategory['MaLoaiSP'] ?>"> <?php echo $productCategory['TenLoaiSP']?> </option>

                    <?php } ?>
                  </select>
                </div>
                <div class="form-group desc">
                  <label for="desc" class="control-label">Mô tả</label>
                  <textarea id="desc" class="form-control" name="description"><?php echo nl2br(htmlspecialchars($product['MoTa'] ?? '')); ?></textarea>
                </div>
                <div class="form-group">
                  <button class="uploadImg">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i> Chọn ảnh
                    <input type="file" name="image" accept="image/*"/>
                  </button>
                  <div class="img-wrapper">
                    <img src="../img/product/<?php echo htmlspecialchars($product['HinhAnh']) ?>" width="1000px" height="auto" name="preview"/>
                    <button type="button"  class="removeImg">X</button>
                  </div>
                  <input type="hidden" name="removeImage" id="removeImage" value="0" />
                  <input type="hidden" name="imageFileName" id="imageFileName" value="<?php echo htmlspecialchars($product['HinhAnh']) ?>" />
                </div>
              </div>
              <div class="warning-btns">
                <button type="reset" class="btn-cancle">Hủy bỏ</button>
                <button type="submit" class="btn-save">Đồng ý</button>
              </div>
            </form>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
<script>

  document.addEventListener("DOMContentLoaded", function () {
      const fileInput = document.querySelector(".uploadImg input");
      const imgWrapper = document.querySelector(".img-wrapper");
      const imgPreview = document.querySelector(".img-wrapper img");
      const removeImgBtn = document.querySelector(".removeImg");
      const removeImageInput = document.getElementById("removeImage");
      const imageFileNameInput = document.getElementById("imageFileName");

      // Kiểm tra xem ảnh có sẵn không
      if (imgPreview.src) {
          imgPreview.style.display = "block"; 
          removeImgBtn.style.display = "inline-block"; 
      } else {
          imgPreview.style.display = "none"; 
          removeImgBtn.style.display = "none"; 
      }

      // Xử lý khi chọn ảnh mới
      fileInput.addEventListener("change", function (event) {
          const file = event.target.files[0];

          if (file) {
              const reader = new FileReader();
              reader.onload = function (e) {
                  imgPreview.src = e.target.result;
                  imgPreview.style.display = "block"; 
                  removeImgBtn.style.display = "inline-block"; 
              };
              reader.readAsDataURL(file);
          }
      });

      // Xử lý khi bấm nút X để xóa ảnh
      removeImgBtn.addEventListener("click", function () {
          imgPreview.style.display = "none"; 
          removeImgBtn.style.display = "none"; 
          removeImageInput.value = "1"; 
          imageFileNameInput.value = ""; 
          fileInput.setAttribute("required", "required");
      });
  });


  const menu = document.querySelector(".menu");
  const menuToggle = document.querySelector(".menu-toggle i");
  menuToggle.addEventListener("click", function () {
    if (menu instanceof HTMLElement) {
      menu.style.display = "block";
    }
  });
  const menuinput = document.querySelector(".menu i");
  menuinput.addEventListener("click", function () {
    if (menu instanceof HTMLElement) {
      menu.style.display = "none";
    }
  });
  // Xử lý sự kiện thay đổi trạng thái checkbox

  const btnCancle = document.querySelector(".btn-cancle");
  btnCancle.addEventListener("click", () => {
    window.location.href = "./admin.product.php";
  });

</script>
