<?php
session_start();
// Nếu admin đã đăng nhập rồi thì chuyển thẳng vào trong, không cho quay lại trang login
if (isset($_SESSION['tennguoidung'])) {
    header("location: accountManage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/dangnhap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <title>DMTD FOOD - ADMIN</title>
    <!-- <style>
        /* Toàn bộ CSS của bạn giữ nguyên ở đây */
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}
        /* ... dán toàn bộ CSS từ file gốc vào đây ... */
    </style> -->
</head>
<body>

<div class="container">
    <h2>ĐĂNG NHẬP ADMIN</h2>
    <form action="/web/inc/admin/SignInInc.php" method="post" style="max-width:500px;margin:auto">
        <div class="input-container">
            <i class="fa fa-user icon"></i>
            <input class="input-field" type="text" placeholder="Tên đăng nhập" name="tenDangNhap" required>
        </div>
        <div class="input-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" placeholder="Mật khẩu" name="password" required>
        </div>
        <input type="submit" value="Đăng nhập" name="signIn">
    </form>
</div>

<?php 
// Hiển thị modal lỗi dựa trên tham số 'error' trên URL
if (isset($_GET['error'])) {
    $errorType = $_GET['error'];
    echo '<script> document.addEventListener("DOMContentLoaded", function() {';
    
    switch ($errorType) {
        case 'wrong-user-or-pass':
            echo 'showLoginErrorModal("Tài khoản hoặc mật khẩu không đúng.");';
            break;
        case 'block-user':
            echo 'showLoginErrorModal("Tài khoản của bạn đã bị khóa!");';
            break;
    }
    echo '}); </script>';
}
?>

<script>
    // Toàn bộ JavaScript để hiển thị modal của bạn giữ nguyên ở đây
    function showLoginErrorModal(message) {
        const modalContainer = document.createElement("div");
        modalContainer.id = "modal-container";
        modalContainer.innerHTML = `
        <div class="modal" id="modal-demo">
            <div class="modal_header">
                <h3>Thông báo</h3>
                <button id="btn-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal_body">
                <p>${message}</p>
                <a href="index.php">Thử lại</a>
            </div>
        </div>`;
        document.body.appendChild(modalContainer);

        const btnClose = document.getElementById("btn-close");
        const modalDemo = document.getElementById("modal-demo");
        modalContainer.classList.add("show");

        btnClose.addEventListener("click", () => {
            modalContainer.classList.remove("show");
            setTimeout(() => document.body.removeChild(modalContainer), 300);
        });

        modalContainer.addEventListener("click", e => {
            if (!modalDemo.contains(e.target)) btnClose.click();
        });

        if (!document.getElementById("modal-style")) {
            const style = document.createElement("style");
            style.id = "modal-style";
            // ... Dán toàn bộ CSS của modal vào đây ...
            style.textContent = `
            #modal-container { height: 100vh; background-color: rgb(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; opacity: 0; pointer-events: none; z-index: 1000; }
            #modal-container.show { opacity: 1; pointer-events: all; }
            .modal { background-color: #fff; max-width: 500px; position: relative; left: 50%; top: 100px; transform: translateX(-50%); }
            /* ... các style khác cho modal ... */
            `;
            document.head.appendChild(style);
        }
    }
</script>

</body>
</html>