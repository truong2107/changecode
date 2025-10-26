<?php
session_start();
if(!isset($_SESSION['tennguoidung'])){
  header("location: index.php");
  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/Order-DetailContr.php";
$controller = new OrderDetailContr();

include "../../inc/admin/order-detail.php";
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/admin.order-detail.css"/>
    <link rel="stylesheet" href="css/index.css"/>
    <title>DMTD FOOD</title>
  </head>

  <body>
    <div class="classQuanLy">
      <!-- Menu -->
      <div class="menu">
        <i class="fa-solid fa-bars"></i>
        <div class="logo">
          <div>
            <img src="../img/DMTD-Food-Logo.jpg" alt=""/>
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
        <a href="dangxuat.php" style="color: inherit">
          <div class="out1">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
          </div>
        </a>
      </div>

      <!-- Content -->
      <div class="content">
        <main>
          <div class="title" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Chi tiết đơn hàng</h2>
            <a href="./admin.order.php" style="text-decoration: none;">
              <button style="
                padding: 8px 16px;
                background-color: orange;
                color: white;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 14px;
                margin-right: 10px;
                transition: background-color 0.3s ease;
              ">Quay lại</button>
            </a>
          </div>

          <div class="main-content">

            <div class="bill">
              <div class="order-group">
                <?php 
                  $sum = 0;
                  foreach ($products as $product){
                ?>
                  <div class="order-product">
                    <div class="order-product-detail">
                      <img src="../img/product/<?php echo $product["HinhAnh"] ?>" alt="<?php echo $product["TenSP"] ?>" />
                      <div class="info">
                        <h4><?php echo $product["TenSP"] ?></h4>
                        <p class="quantity">SL: <?php echo $product["SoLuong"] ?></p>
                      </div>
                    </div>
                    <div class="order-product-price">
                      <?php $sum += ($product["SoLuong"] * $product["DonGia"]); ?>
                      <span><?php echo number_format($product['DonGia'], 0, ',', '.') . 'đ'; ?></span>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="description">
              <ul>
                <li>
                  <span><i class="fa-regular fa-calendar-days"></i> Ngày đặt hàng</span>
                  <span>
                    <?php 
                      $datetime = new DateTime($order['NgayDatHang']); 
                      echo $datetime->format('d/m/Y'); 
                    ?>
                  </span>
                </li>
                <li>
                  <span><i class="fa-solid fa-money-bill-transfer"></i> Phương thức thanh toán</span>
                  <span><?php echo ($order["PhuongThucTT"] == 1 ? "Tiền mặt" : "Chuyển khoản"); ?></span>
                </li>
                <li><span><i class="fa-solid fa-person"></i> Người nhận</span><span><?php echo $order["HoTen"] ?></span></li>
                <li><span><i class="fa-solid fa-phone"></i> Số điện thoại</span><span><?php echo $order["sdt"] ?></span></li>
                <li><span><i class="fa-regular fa-clock"></i> Thời gian giao</span><span>Giao ngay khi xong</span></li>
                <li style="flex-direction: column">
                  <span><i class="fa-solid fa-location-dot"></i>Địa chỉ nhận</span>
                  <p><?php echo $order["DiaChi"] . ", " . $order["phuong_xa"] . ", " . $order["quan_huyen"] ?></p>
                </li>
              </ul>
            </div>

            <div class="sum">
              <span>Thành tiền</span>
              <span><?php echo number_format($sum, 0, ',', '.') . 'đ'; ?></span>
            </div>

            <form action="" method="GET">
              <div class="changeStatus">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <select class="selectStatus" name="status" onchange="this.form.submit()">
                    <option value="1" <?php if ($currentStatus == 1) echo 'selected'; ?>>Chưa xác nhận</option>
                    <option value="2" <?php if ($currentStatus == 2) echo 'selected'; ?>>Đã xác nhận</option>
                    <option value="3" <?php if ($currentStatus == 3) echo 'selected'; ?>>Giao thành công</option>
                    <option value="4" <?php if ($currentStatus == 4) echo 'selected'; ?>>Hủy đơn</option>
                </select>
              </div>
            </form>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>