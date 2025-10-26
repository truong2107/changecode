<?php
session_start();
if(!isset($_SESSION['tennguoidung'])){
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DMTD FOOD - Thống kê</title>
    
    <link href="../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
       <link rel="stylesheet" href="css/accountManage.css">
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
            <div class="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </div>
            <div class="out1">
                <a href="/web/inc/admin/LogoutInc.php"> <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </div>

        <div class="form_date">
            <div class="date_con">
                <h1>Thống kê khách hàng</h1>
                <form action="Statistics.php" method="GET">
                    <div class='in'>
                        <p>Chọn mốc thời gian</p>
                        <label for="from">Từ:</label>
                        <input type="date" name="from" id="from" required>
                        <label for="to">Đến:</label>
                        <input type="date" name="to" id="to" required>
                    </div>
                    <input type="submit" value="Xem kết quả" class="btn">
                </form>
            </div>
        </div>
    </div>

    <style>
        .form_date { display: flex; justify-content: center; align-items: start; margin-top: 50px; }
        .date_con { width: 50%; padding: 20px; display: flex; flex-direction: column; align-items: center; background-color: #e9e9e9; border: 1px solid; }
        .date_con form { display: flex; flex-direction: column; align-items: center; gap: 15px; height: 80%; }
        .in { display: flex; align-items: center; gap: 10px; width: 100%; height: 20%; }
        .in p { white-space: nowrap; }
        label { width: auto; text-align: right; }
        input[type="date"] { width: 150px; height: 35px; padding: 5px; }
        .btn { padding:10px 30px; font-size:larger; cursor: pointer; border: 1px solid #ccc; }
        .btn:hover { background-color: orange; color: white; }
    </style>
    <script>
        // Toàn bộ script menu của bạn
        const menu = document.querySelector(".menu");
        const menuToggle = document.querySelector(".menu-toggle i");
        menuToggle.addEventListener("click", function () {
            if (menu instanceof HTMLElement) { menu.style.display = "block"; }
        });
        const menuinput = document.querySelector(".menu i");
        menuinput.addEventListener("click", function () {
            if (menu instanceof HTMLElement) { menu.style.display = "none"; }
        });
    </script>
</body>
</html>