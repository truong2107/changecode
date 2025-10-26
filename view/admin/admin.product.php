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
    <link rel="stylesheet" href="css/admin.product.css" />
    <link rel="stylesheet" href="css/index.css" />
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
                              <li><a href="selectDay.php" class="menu-1">Thống kê</a></li>
                    <li><a href="admin.product.php" class="menu-1">Sản phẩm</a></li>
                    <li><a href="admin.order.php" class="menu-1">Đơn hàng</a></li>
                    <li><a href="AccountManage.php" class="menu-1">Tài khoản khách hàng</a></li>
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
            <h2>Danh mục sản phẩm</h2>
          </div>
          <div class="product">
            <div class="FilterAdd">
              <select class="Filter" style="visibility: hidden;">
                <option>Tất cả</option>
                <option>Hoạt động</option>
                <option>Dừng hoạt động</option>
              </select>
              <div class="Add">
                <i class="fa-solid fa-plus"></i>
                <button
                  onclick="window.location.href='./admin.product-add.php'"
                >
                  Thêm mới
                </button>
              </div>
            </div>

            <div class="ListProduct" style="width: 100%">
              <table class="table">
                <?php
                  require_once $_SERVER['DOCUMENT_ROOT'] . '/web/controller/admin/ProductIndexContr.php';
                  $products = new ProductIndexContr();
                  $productList = $products->showAllProducts();

                  if (empty($productList)) {
                    echo '<div style="text-align:center"><h1>Không có sản phẩm nào</h1></div>';
                  } else { 
                echo "
                  <thead>
                    <tr>
                      <th>Mã sản phẩm</th>
                      <th>Hình ảnh</th>
                      <th>Tiêu đề</th>
                      <th>Giá</th>
                      <th>Trạng thái</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                ";
                    foreach ($productList as $product) {
                ?>
                    <tr>
                      <td><?php echo $product['MaSP'] ?></td>
                      <td>
                        <img
                          src="../img/product/<?php echo $product['HinhAnh']?>"
                          alt="<?php echo $product['TenSP'] ?>"
                          width="100px"
                          height="auto"
                        />
                      </td>
                      <td><?php echo $product['TenSP'] ?></td>
                      <td><?php echo number_format($product['DonGia'], 0, ',', '.') . 'đ';?></td>
                      <td>
                        <?php 
                          if($product['TrangThai'] == 1){
                            echo '<button class="active">Hoạt động</button>';
                          }
                          else{
                            echo '<button class="inactive">Dừng hoạt động</button>';
                          }
                        ?>
                      </td>
                      <td>
                        <a href="./admin.product-edit.php?id=<?php echo $product['MaSP']; ?>">
                          <button>Sửa</button>
                        </a>
                        <button type="button" class="delete-btn" data-id="<?php echo $product['MaSP']; ?>">Xóa</button>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
                <?php } ?>
              </table>
            </div>
          </div>

          <div>
            <ul class="listPage">
            </ul>
          </div>
        </main>
      </div>
    </div>
    <div id="warning-box"></div>
  </body>
</html>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach((button) => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-id");

            fetch(`../../inc/admin/warning-box.php?id=${productId}`)
              .then((response) => response.text())
              .then((data) => {
                  let warningBox = document.getElementById("warning-box");
                  warningBox.innerHTML = data;

                  let warning = document.querySelector(".warning");
                  if (warning) {
                      warning.style.display = "flex";
                      
                      // Lưu lại ID sản phẩm vào nút "Đồng ý"
                      document.querySelector(".btn-save").setAttribute("data-id", productId);
                  }
              })
              .catch((error) => console.error("Lỗi:", error));
        });
    });

    // Xử lý khi bấm "Đồng ý"
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("btn-save")) {
            let action = event.target.getAttribute("data-act"); // "delete" hoặc "hide"
            let productId = event.target.getAttribute("data-id");

            let url = action === "delete"
                ? `../../inc/admin/delete-product.php?id=${productId}`
                : `../../inc/admin/hide-product.php?id=${productId}`;

            fetch(url, { method: "POST" })
                .then((response) => response.text())
                .then((data) => {
                    alert(data); // Thông báo kết quả

                    // Ẩn hộp cảnh báo sau khi thực hiện
                    let warning = document.querySelector(".warning");
                    if (warning) {
                        warning.style.display = "none";
                        document.getElementById("warning-box").innerHTML = "";
                        location.reload(); // Tải lại danh sách sản phẩm
                    }
                })
                .catch((error) => console.error("Lỗi:", error));
        }
    });

    // Sự kiện đóng hộp cảnh báo khi bấm "Hủy bỏ"
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("btn-cancle")) {
            let warning = document.querySelector(".warning");
            if (warning) {
                    warning.style.display = "none";
                    document.getElementById("warning-box").innerHTML = ""; 
            }
        }
    });
});


window.history.replaceState({}, document.title, window.location.pathname);
document.addEventListener("DOMContentLoaded", function() {
  // Xóa query parameters khi trang load
  window.history.replaceState({}, document.title, window.location.pathname);
});
//Pagination
let thisPage = 1;
let limit = 5;
let list = document.querySelectorAll(".table tbody tr ");

function loadItem(){
  let beginGet = limit * (thisPage - 1);
  let endGet = limit * thisPage -1;
  list.forEach((item, index) =>{
    if(index >= beginGet && index <= endGet){
      item.style.display = "table-row";
    }
    else{
      item.style.display = "none";
    }
  });
  listPage();
}
loadItem();
function listPage(){
  let count = Math.ceil(list.length / limit);
  document.querySelector(".listPage").innerHTML = ""; 

  if(thisPage != 1){
    let prev = document.createElement('li');
    prev.innerText = '<';
    prev.setAttribute('onclick', "changePage("+ (thisPage - 1) + ")");
    document.querySelector('.listPage').appendChild(prev); 
  }

  for(i = 1; i<= count; i++){
    let newPage = document.createElement('li');
    newPage.innerText = i;
    if(i == thisPage){
      newPage.classList.add("active");
    }
    newPage.setAttribute('onclick', "changePage("+ i + ")");
    document.querySelector('.listPage').appendChild(newPage); 
  }

  if(thisPage != count){
    let next = document.createElement('li');
    next.innerText = '>';
    next.setAttribute('onclick', "changePage(" + (thisPage + 1) + ")");
    document.querySelector(".listPage").appendChild(next);
  }
}

function changePage(i){
  thisPage = i;
  loadItem();
}
//End pagination

// Truyền req.query ko bị reload
document.querySelectorAll(".delete-btn").forEach(button => {
  button.addEventListener("click", function(event) {
      event.preventDefault(); 
      let id = this.getAttribute("data-id");
      let url = new URL(window.location.href);
      url.searchParams.set("id", id);
      history.pushState(null, "", url); // Cập nhật URL mà không reload
  });
});

// End Truyền req.query ko bị reload

const btnDelete = document.querySelectorAll(
  ".table tbody tr td:nth-child(6) button"
);


const warningBox = document.querySelector(".warning");
const warningContent = document.querySelector(".warning-content");
const confirmBox = document.querySelector(".confirm");

btnDelete.forEach((button) => {
  button.addEventListener("click", (event) => {
    warningBox.style.display = "flex";
  });
});

const btnCancle = document.querySelector(".btn-cancle");
const btnSave = document.querySelector(".btn-save");

btnSave.addEventListener("click", () => {
  warningContent.style.display = "none";
  confirmBox.style.display = "block";
});
btnCancle.addEventListener("click", () => {
  warningBox.style.display = "none";
});

const confirmBtn = document.querySelector(".btn-confirm");
confirmBtn.addEventListener("click", () => {
  warningBox.style.display = "none";
  warningContent.style.display = "block";
  confirmBox.style.display = "none";
});
</script>
