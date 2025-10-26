<?php
session_start();
if (!isset($_SESSION['tennguoidung'])) {
    header("location: index.php");
    exit();
}


if (!isset($_GET['from']) || !isset($_GET['to']) || empty($_GET['from']) || empty($_GET['to'])) {

    header("location: chonngay.php");
    exit();
}
$from = $_GET['from'];
$to = $_GET['to'];

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/StatisticsContr.php";
$statistics = new StatisticsContr();
$reportData = $statistics->showTopCustomersReport($from, $to);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kết quả thống kê</title>
    <link href="../../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
   <link rel="stylesheet" href="css/accountManage.css">
    <link rel="stylesheet" href="css/Statistics.css" />
</head>
<body>
    <div class="classQuanLy">
        <div class="menu">
            <i class="fa-solid fa-bars"></i>
            <div class="logo">
                <div>
                    <img src="../img/DMTD-Food-Logo.jpg" alt="Logo"/>
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
        <div class="out">
            <div class="menu-toggle"><i class="fa-solid fa-bars"></i></div>
            <div class="out1"><a href="/web/inc/admin/LogoutInc.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></div>
        </div>
        <div class="ThongKe">
            <div class="bang">
                <h1>Top 5 tài khoản mua hàng nhiều nhất từ: <?php echo htmlspecialchars($from);?> đến <?php echo htmlspecialchars($to); ?></h1>
            </div>

            <?php
            if (empty($reportData)) {
            ?>
                <div class="thongbao"><p>Không có dữ liệu để hiển thị cho khoảng thời gian này.</p></div>
            <?php
            } else {
            ?>
                <table>
                    <tr>
                        <th>Xếp hạng</th>
                        <th>ID người dùng</th>
                        <th>Tên Người Dùng</th>
                        <th>Số lượng đơn</th>
                        <th>Tổng số tiền</th>
                        <th>Xem chi tiết</th>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($reportData as $row) {
                        $i++;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['ten']); ?></td>
                            <td><?php echo htmlspecialchars($row['sldon']); ?></td>
                            <td><?php echo number_format($row['sotien'], 0, '', '.'); ?> đ</td>
                            <td>
                                <div class="icon-container">
                                    <a href="OrderDetail.php?thisid=<?php echo $row['id']; ?>&from=<?php echo $from; ?>&to=<?php echo $to; ?>">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <div class="tooltip">Chi tiết đơn hàng</div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } 
                    ?>
                </table>
            <?php
            } 
            ?>
            <div class="back"><a href="chonngay.php"><button>Quay lại</button></a></div>
        </div>
    </div>
    <style>
        .back { display: flex; justify-content: center; }
        .back button { margin-top: 5px; padding: 5px 15px; cursor: pointer; border: 1px solid grey; }
        .back button:hover { background-color: orange; }
        .thongbao { display: flex; justify-content: center; }
    </style>
<script>
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
    </script>
</body>
</html>