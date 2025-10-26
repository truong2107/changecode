<?php
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
            <h2>Danh sách sản phẩm / Thêm sản phẩm</h2>
          </div>

          <div class="addProduct">
            <h3 class="titleAddProduct">Tạo mới sản phẩm</h3>
            <form  method="POST" enctype="multipart/form-data" action="../../inc/admin/addProduct.php">
              <div class="infoProduct">
                <div class="form-group">
                  <label class="control-label">Tên sản phẩm</label>
                  <input class="form-control" type="text" name="name" required/>
                </div>
                <div class="form-group">
                  <label for="selectform" class="control-label">Trạng thái</label>
                  <select class="form-control" id="selectform" name="status" required>
                    <option value="" disabled selected>-- Chọn trạng thái --</option>
                    <option value="1">Hoạt động</option>
                    <option value="0">Dừng hoạt động</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Giá bán</label>
                  <input class="form-control" type="number" name="price" min="0" required/>
                </div>
                <div class="form-group">
                  <label for="selectform" class="control-label">Loại</label>
                  <select class="form-control" id="selectform" name="category" required>
                    <option value="" disabled selected>-- Chọn danh mục loại --</option>
                    <?php
                      require_once $_SERVER['DOCUMENT_ROOT'] . '/web/controller/admin/ProductIndexContr.php';
                      $productContr = new ProductIndexContr();
                      $productCategoryList = $productContr->showAllProductCategories();    

                      foreach ($productCategoryList as $productCategory) {
                    ?>
                      <option value="<?php echo $productCategory['MaLoaiSP'] ?>"> <?php echo $productCategory['TenLoaiSP']?> </option>

                    <?php } ?>
                  </select>
                </div>
                <div class="form-group desc">
                  <label for="desc" class="control-label">Mô tả</label>
                  <textarea id="desc" class="form-control" name="description"></textarea>
                </div>
                <div class="form-group">
                  <button class="uploadImg">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i> Chọn ảnh
                    <input type="file" name="image" accept="image/*" required/>
                  </button>
                  <div class="img-wrapper">
                    <img src="" width="1000px" height="auto" />
                    <button type="button"  class="removeImg">X</button>
                  </div>
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

      // Ẩn ảnh & nút X khi trang vừa load
      imgPreview.style.display = "none";
      removeImgBtn.style.display = "none";

      fileInput.addEventListener("change", function (event) {
          const file = event.target.files[0];

          if (file) {
              const reader = new FileReader();
              reader.onload = function (e) {
                  imgPreview.src = e.target.result;
                  imgPreview.style.display = "block"; // Hiện ảnh
                  removeImgBtn.style.display = "inline-block"; // Hiện nút X
              };
              reader.readAsDataURL(file);
          }
      });

      removeImgBtn.addEventListener("click", function () {
          imgPreview.src = "";
          fileInput.value = "";
          imgPreview.style.display = "none"; // Ẩn ảnh
          removeImgBtn.style.display = "none"; // Ẩn nút X
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
