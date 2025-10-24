<?php
session_start();
if (!isset($_SESSION['tennguoidung'])) {
    header("location: index.php");
    exit();
}

// Gọi controller để lấy dữ liệu
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/AccountManageContr.php";
$accountManager = new AccountManageContr();
$users = $accountManager->showUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DMTD FOOD - Quản lý tài khoản</title>
    
    <link href="../../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
       <link rel="stylesheet" href="css/accountManage.css">
    
</head>
<body>
    <div class="classQuanLy">
        <div class="menu">
            <i class="fa-solid fa-bars"></i>
            <div class="logo">
                <div>
                    <img src="../../img/DMTD-Food-Logo.jpg" alt="Logo"/>
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
             <div class="menu-toggle">
               <i class="fa-solid fa-bars"></i>
             </div>
             <a href="index.html" style="color: inherit">
               <div class="out1">
                <a href="/web/inc/admin/LogoutInc.php"> <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
               </div>
             </a>
        </div>
        <div class="content">
            <p class="time"></p>
            <div class="TieuDe">
                <h3 style="margin-left: 10px">Danh sách tài khoản</h3>
            </div>
            <div class="list">
                <div class="search">
                    <div class="Themmoi">
                        <a href="addAccount.php">
                            <button style="background-color: #f37319; padding: 5px; color: white; border: none; cursor: pointer;">
                                Thêm mới
                            </button>
                        </a>
                    </div>
                </div>
                <div class="Table">
                    <table class="listPage">
                        <tr>
                            <th>ID</th>
                            <th>Tên tài khoản</th>
                            <th>Tên đăng nhập</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>SĐT</th>
                            <th>Ngày tạo</th>
                            <th>Địa chỉ</th>
                            <th>Tính năng</th>
                        </tr>
                        <?php 
                        if (!empty($users)) {
                            foreach ($users as $user) {
                        ?>
                                <tr class="list_user">
                                    <td class="id_nd"><?php echo htmlspecialchars($user['id_nguoidung']); ?></td>
                                    <td><?php echo htmlspecialchars($user['tenNguoiDung']); ?></td>
                                    <td><?php echo htmlspecialchars($user['tenDangNhap']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['password']); ?></td>
                                    <td><?php echo htmlspecialchars($user['sdt']); ?></td>
                                    <td>
                                        <?php 
                                        $date = explode(" ", $user['ngay_tao']);
                                        echo $date[0];
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['diaChi'] . ", " . $user['phuong_xa'] . ", " . $user['quan_huyen']); ?></td>
                                    <td>
                                        <a href="/web/inc/admin/ToggleUserStatusInc.php?this_id=<?php echo $user['id_nguoidung']; ?>&this_tt=<?php echo $user['TrangThai']; ?>" class="chucnang">
                                            <?php if ($user['TrangThai'] == 1) {
                                                echo "<i class='fa-solid fa-lock'></i>";
                                            } else {
                                                echo "<i class='fa-solid fa-lock-open'></i>";
                                            } ?>
                                        </a>
                                        <a href="changeInforAcc.php?this_id=<?php echo $user['id_nguoidung']; ?>" class="chucnang"><i class="fa-solid fa-pen"></i></a>
                                    </td>
                                </tr>
                        <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='9' style='text-align:center;'>Không có tài khoản nào.</td></tr>";
                        }
                        ?>
                    </table>
                </div>
                <div class="foot">
                    </div>
            </div>
        </div>
    </div>
    
    <script>
      function thoigian() {
        const today = new Date();
        let day = today.getDate();
        let month = today.getMonth() + 1;
        const year = today.getFullYear();
        let hours = today.getHours();
        let minutes = today.getMinutes();
        let seconds = today.getSeconds();
        day = day < 10 ? `0${day}` : day;
        month = month < 10 ? `0${month}` : month;
        hours = hours < 10 ? `0${hours}` : hours;
        minutes = minutes < 10 ? `0${minutes}` : minutes;
        seconds = seconds < 10 ? `0${seconds}` : seconds;
        const time = document.querySelector(".time");
        if (time) {
          time.innerHTML = `Ngày ${day} tháng ${month} năm ${year}, ${hours} giờ ${minutes} phút ${seconds} giây`;
        }
      } 
      setInterval(thoigian, 1000);

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
    <script>
    let thispage = 1;
    let limit = 6;
    let list = document.querySelectorAll('.list_user');

    function loadItem() {
      let begin = limit * (thispage - 1);
      let end = limit * thispage - 1;

      list.forEach((item, key) => {
        if (key >= begin && key <= end) {
          item.style.display = 'table-row';
        } else {
          item.style.display = 'none';
        }
      });
      listpage();
    }

    function listpage() {
      let count = Math.ceil(list.length / limit);
      let listPage = document.querySelector('.foot');

      listPage.innerHTML = '';

      if (thispage != 1) {
        let prev = document.createElement('button');
        prev.innerText = 'PREV';
        prev.setAttribute('onclick', `changePage(${thispage - 1})`);
        listPage.appendChild(prev);
      }

      for (let i = 1; i <= count; i++) {
        let newPage = document.createElement('button');
        newPage.innerText = i;
        if (i == thispage) {
          newPage.style.backgroundColor = '#f37319';
        } else {
          newPage.style.backgroundColor = 'white';
        }
        newPage.setAttribute('onclick', `changePage(${i})`);
        listPage.appendChild(newPage);
      }

      if (thispage != count) {
        let next = document.createElement('button');
        next.innerText = 'NEXT';
        next.setAttribute('onclick', `changePage(${thispage + 1})`);
        listPage.appendChild(next);
      }
    }

    function changePage(i) {
      thispage = i;
      loadItem();
    }

    loadItem();
    </script>
</body>
</html>