<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/web/controller/admin/OrderIndexContr.php';
$orderContr = new OrderIndexContr();

$status    = $_GET['status']     ?? '';
$district  = $_GET['district']   ?? '';
$ward      = $_GET['ward']       ?? '';
$startDate = $_GET['start_date'] ?? '';
$endDate   = $_GET['end_date']   ?? '';

$districts = $orderContr->getDistricts();
$wards = (!empty($district) && $district != 'all') ? $orderContr->getWards($district) : null;

$orders = $orderContr->filterOrders($status, $district, $ward, $startDate, $endDate);

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
    <link rel="stylesheet" href="css/admin.order.css" />
    <link rel="stylesheet" href="css/index.css" />
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
                                <li><a href="selectDay.php" class="menu-1">Thống kê</a></li>
                    <li><a href="admin.product.php" class="menu-1">Sản phẩm</a></li>
                    <li><a href="admin.order.php" class="menu-1">Đơn hàng</a></li>
                    <li><a href="AccountManage.php" class="menu-1">Tài khoản khách hàng</a></li>
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
          <?php
            $length = $orderContr->checkOrdersLength();

            if ($length === 0) {
              echo '<div style="text-align:center"><h1>Không có đơn nào</h1></div>';
            } else {
          ?>
          <div class="main-content">

            <form id="formFilter" action="" method="GET">
              <div class="Filter">
              
                <div class="form-group">

                  <select id="filter-district" name="district" onchange="this.form.submit()">  
                    <option selected disabled <?php echo empty($district) ? 'selected' : ''; ?>>Quận/Huyện</option>
                    <option value="all" <?php echo ($district == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                    <?php 
                      while($row = $districts->fetch_assoc()){ ?>
                        <option value="<?= $row['quan_huyen'] ?>" <?= ($row['quan_huyen'] == $district) ? 'selected' : '' ?>>
                          <?= $row['quan_huyen'] ?>
                        </option>
                    <?php } ?>
                  </select>


                  <select id="filter-ward " name="ward" onchange="this.form.submit()">
                    <option selected disabled <?php echo empty($ward) ? 'selected' : ''; ?>>Phường/Xã</option>
                    <option value="all" <?php echo ($ward == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                    <?php 
                      if($wards){
                        while($row = $wards->fetch_assoc()){ ?>
                          <option value="<?= $row['phuong_xa'] ?>" <?= ($row['phuong_xa'] == $ward) ? 'selected' : '' ?>>
                            <?= $row['phuong_xa'] ?>
                          </option>
                    <?php    }
                      } ?>
                  </select>

                  <select id="filter-status" name="status" onchange="this.form.submit()">
                    <option selected disabled>Lọc theo tình trạng</option>
                    <option value="all" <?= ($status == 'all') ? 'selected' : '' ?>>Tất cả</option>
                    <option value = "1" <?= ($status == '1') ? 'selected' : '' ?>>Chưa xác nhận</option>
                    <option value="2" <?= ($status == '2') ? 'selected' : '' ?>>Đã xác nhận</option>
                    <option value="3"<?= ($status == '3') ? 'selected' : '' ?>>Giao thành công</option>
                    <option value="4" <?= ($status == '4') ? 'selected' : '' ?>>Hủy đơn</option>
                  </select>
                </div>

                <div class="Date">
                  <div class="start">
                    <label for="time-start">Từ</label>
                    <input type="date" id="time-start" name="start_date" value="<?= htmlspecialchars($startDate) ?>" onchange="this.form.submit()" />
                  </div>
                  <div class="end">
                    <label for="time-end">Đến</label>
                    <input type="date" id="time-end" name="end_date" value="<?= htmlspecialchars($endDate) ?>" onchange="this.form.submit()" />
                  </div>
                </div>
              </div>
            </form> 
            
            <div class="list-order">
              <table>
                <thead>
                  <tr>
                    <td>MÃ ĐƠN</td>
                    <td>KHÁCH HÀNG</td>
                    <td>NGÀY ĐẶT</td>
                    <td>ĐỊA CHỈ</td>
                    <td>TỔNG TIỀN</td>
                    <td>TRẠNG THÁI</td>
                    <td>THAO TÁC</td>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    foreach ($orders as $row){
                  ?>
                  <tr>
                    <td><?php echo $row['IdHoaDon'] ?></td>
                    <td><?php echo $row['HoTen']?></td>
                    <td><?php 
                      $datetime = new DateTime($row['NgayDatHang']); 
                      $formatted_date = $datetime->format('d/m/Y'); 
                      echo $formatted_date;
                    ?></td>
                    <td><?php echo $row["DiaChi"] . ", " . $row["phuong_xa"] . ", " . $row["quan_huyen"] ?></td>
                    <td><?php echo number_format($row['TongTien'], 0, ',', '.') . 'đ'; ?></td>
                    <td>
                      <?php 
                        switch($row['TrangThai']){
                          case 1:
                            echo '<span class="status-btn pending">Chưa xác nhận</span>';
                            break;
                          case 2:
                            echo '<span class="status-btn confirm">Đã xác nhận</span>';
                            break;
                          case 3:
                            echo '<span class="status-btn success">Giao thành công</span>';
                            break;
                          case 4:
                            echo '<span class="status-btn cancel">Hủy đơn</span>';
                            break;
                        }
                      ?>
                    </td>
                    <td class="control">
                      <button>
                        <a
                          href="./admin.order-detail.php?id=<?php echo $row["IdHoaDon"]?>&&status=<?php echo $row["TrangThai"]?>"
                          style="font-size: 14px; color: black"
                          name="button-detail"
                          >Chi tiết</a
                        >
                      </button>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>
        </main>
      </div>
    </div>
  </body>
</html>

