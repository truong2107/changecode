<?php
session_start();
if (!isset($_SESSION['tennguoidung'])) {
    header("location: index.php");
    exit();
}

// --- PHẦN LẤY DỮ LIỆU ĐỂ HIỂN THỊ (GET) ---
if (!isset($_GET['this_id']) || !is_numeric($_GET['this_id'])) {
    header("location: accountMange.php"); // Nếu không có ID hoặc ID không phải là số, quay về
    exit();
}

$userId = $_GET['this_id'];

// Gọi Controller để lấy thông tin user
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ChangeInforAccContr.php";
$userController = new ChangeInforAccContr(); // Khởi tạo không cần tham số
$userData = $userController->showUser($userId);

// Nếu không tìm thấy user với ID này, quay về trang quản lý
if (!$userData) {
    header("location: accountMange.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chỉnh sửa tài khoản #<?php echo htmlspecialchars($userId); ?></title>
    <link href="../../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Toàn bộ CSS từ file gốc của bạn được dán vào đây */
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}
        .container{ background-color: #ffff; width: 450px; padding: 1.5rem; margin: 50px auto; border-radius: 10px; box-shadow: 0 20px 35px rgba(0,0,1,0.5); }
        .container h2{ font: size 1.5rem; font-weight:bold; text-align:center; padding: 1.3rem; margin-top:0.1rem; margin-bottom:0.2rem; }
        .input-container { display: flex; width: 100%; margin-bottom: 15px; flex-direction: column; }
        .icon { padding: 10px; background: #f37319; color: white; width: 50px; text-align: center; }
        .input-row { display: flex; }
        .input-field { width: 100%; padding: 10px; outline: none; border: 1px solid #ccc; }
        .input-field:focus { border: 2px solid black; }
        .error-message { color: red; font-size: 12px; margin-top: 5px; display: none; }
        input[type=submit] { background-color: #f37319; color: white; padding: 15px 20px; border: none; cursor: pointer; width: 100%; opacity: 0.9; }
        input[type=submit]:hover { opacity: 1; }
        .links{ display:flex; justify-content:center; padding:0 4rem; margin-top:0.3rem; font-weight:bold; }
        .links a{ color:#F37319; text-decoration:none; margin: 16px 0px 0px 2px; font-size:1rem; font-weight:bold; }
        .links a:hover{ cursor: pointer; text-decoration:underline; color: red; }
    </style>
    <script>
// Mảng dữ liệu quận huyện nội thành TPHCM
const quanHuyenData = {
  "Quận 1": ["Bến Nghé", "Bến Thành", "Cầu Kho", "Cầu Ông Lãnh", "Đa Kao", "Nguyễn Cư Trinh", "Nguyễn Thái Bình", "Phạm Ngũ Lão", "Tân Định"],
  "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
  "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 8", "Phường 9", "Phường 10", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 18"],
  "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
  "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
  "Quận 7": ["Bình Thuận", "Phú Mỹ", "Phú Thuận", "Tân Hưng", "Tân Kiểng", "Tân Phong", "Tân Phú", "Tân Quy", "Tân Thuận Đông", "Tân Thuận Tây"],
  "Quận 8": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
  "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
  "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16"],
  "Quận 12": ["An Phú Đông", "Đông Hưng Thuận", "Hiệp Thành", "Tân Chánh Hiệp", "Tân Hưng Thuận", "Tân Thới Hiệp", "Tân Thới Nhất", "Thạnh Lộc", "Thạnh Xuân", "Thới An", "Trung Mỹ Tây"],
  "Quận Bình Tân": ["An Lạc", "An Lạc A", "Bình Hưng Hòa", "Bình Hưng Hòa A", "Bình Hưng Hòa B", "Bình Trị Đông", "Bình Trị Đông A", "Bình Trị Đông B", "Tân Tạo", "Tân Tạo A"],
  "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"],
  "Quận Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 17"],
  "Quận Phú Nhuận": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 13", "Phường 14", "Phường 15", "Phường 17"],
  "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
  "Quận Tân Phú": ["Hiệp Tân", "Hòa Thạnh", "Phú Thạnh", "Phú Thọ Hòa", "Phú Trung", "Sơn Kỳ", "Tân Quý", "Tân Sơn Nhì", "Tân Thành", "Tân Thới Hòa", "Tây Thạnh"],
  "Thành phố Thủ Đức": ["An Khánh", "An Lợi Đông", "An Phú", "Bình Chiểu", "Bình Thọ", "Bình Trưng Đông", "Bình Trưng Tây", "Cát Lái", "Hiệp Bình Chánh", "Hiệp Bình Phước", "Hiệp Phú", "Linh Chiểu", "Linh Đông", "Linh Tây", "Linh Trung", "Linh Xuân", "Long Bình", "Long Phước", "Long Thạnh Mỹ", "Long Trường", "Phú Hữu", "Phước Bình", "Phước Long A", "Phước Long B", "Tam Bình", "Tam Phú", "Tăng Nhơn Phú A", "Tăng Nhơn Phú B", "Thảo Điền", "Thủ Thiêm", "Trường Thạnh", "Trường Thọ"],
  "Huyện Bình Chánh": ["An Phú Tây", "Bình Chánh", "Bình Hưng", "Bình Lợi", "Đa Phước", "Hưng Long", "Lê Minh Xuân", "Phạm Văn Hai", "Phong Phú", "Quy Đức", "Tân Kiên", "Tân Nhựt", "Tân Quý Tây", "Tân Túc", "Vĩnh Lộc A", "Vĩnh Lộc B"],
  "Huyện Cần Giờ": ["An Thới Đông", "Bình Khánh", "Long Hòa", "Lý Nhơn", "Tam Thôn Hiệp", "Thạnh An", "Cần Thạnh"],
  "Huyện Củ Chi": ["An Nhơn Tây", "An Phú", "Bình Mỹ", "Củ Chi", "Hòa Phú", "Nhuận Đức", "Phạm Văn Cội", "Phú Hòa Đông", "Phú Mỹ Hưng", "Phước Hiệp", "Phước Thạnh", "Phước Vĩnh An", "Tân An Hội", "Tân Phú Trung", "Tân Thạnh Đông", "Tân Thạnh Tây", "Tân Thông Hội", "Thái Mỹ", "Trung An", "Trung Lập Hạ", "Trung Lập Thượng"],
  "Huyện Hóc Môn": ["Bà Điểm", "Đông Thạnh", "Hóc Môn", "Nhị Bình", "Tân Hiệp", "Tân Thới Nhì", "Tân Xuân", "Thới Tam Thôn", "Trung Chánh", "Xuân Thới Đông", "Xuân Thới Sơn", "Xuân Thới Thượng"],
  "Huyện Nhà Bè": ["Hiệp Phước", "Long Thới", "Nhà Bè", "Nhơn Đức", "Phú Xuân", "Phước Kiển", "Phước Lộc"],
};

// Cập nhật danh sách huyện khi quận thay đổi
function updateHuyen() {
  const quanSelect = document.getElementById('quan_huyen');
  const huyenSelect = document.getElementById('phuong_xa');
  const selectedQuan = quanSelect.value;
  
  // Xóa tất cả các option hiện tại
  huyenSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
  
  // Thêm các option mới dựa trên quận được chọn
  if (selectedQuan && quanHuyenData[selectedQuan]) {
    quanHuyenData[selectedQuan].forEach(huyen => {
      const option = document.createElement('option');
      option.value = huyen;
      option.textContent = huyen;
            if (huyen === "<?php echo $userData['phuong_xa']; ?>") { 
        option.selected = true; // Chọn sẵn phường đã lưu
      }
      huyenSelect.appendChild(option);
    });
  }
}

// Gọi hàm khi trang tải xong
window.onload = function () {
  updateHuyen();
};

</script>
</head>
<body>
<div class="container">
    <h2>Chỉnh sửa tài khoản #<?php echo htmlspecialchars($userId); ?></h2>
    <form action="/web/inc/admin/ChangeInforAccInc.php" method="post" style="max-width:500px;margin:auto">
        <input type="hidden" name="id_nguoidung" value="<?php echo htmlspecialchars($userId); ?>">

        <div class="input-container">
             <div class="input-row">
                 <i class="fa fa-user icon"></i>
                 <input class="input-field" type="text" placeholder="Họ và tên" name="tenNguoiDung" value="<?php echo htmlspecialchars($userData['tenNguoiDung']); ?>" required>
             </div>
        </div>

        <div class="input-container">
             <div class="input-row">
                 <i class="fa fa-user icon"></i>
                 <input class="input-field" type="text" placeholder="Tên đăng nhập" name="tenDangNhap" value="<?php echo htmlspecialchars($userData['tenDangNhap']); ?>" required>
             </div>
        </div>

        <div class="input-container">
            <div class="input-row">
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="email" placeholder="Email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            </div>
            <?php 
            if (isset($_GET['error']) && $_GET['error'] == 'emailtaken') {
                echo '<span class="error-message" style="display:block;">Email này đã được sử dụng bởi tài khoản khác.</span>';
            }
            ?>
        </div>
        
        <div class="input-container">
            <div class="input-row">
                <i class="fa fa-key icon"></i>
                <input class="input-field" type="password" placeholder="Mật khẩu" name="password" value="<?php echo htmlspecialchars($userData['password']); ?>" required>
            </div>
        </div>

        <div class="input-container">
            <div class="input-row">
                <i class="fa fa-phone icon"></i>
                <input class="input-field" type="text" pattern="^0[1-9][0-9]{8,10}$" placeholder="Số điện thoại" name="sdt" value="<?php echo htmlspecialchars($userData['sdt']); ?>" required>
            </div>
        </div>

        <div class="input-container">
            <div class="input-row">
                <i class="fa fa-map-marker icon"></i>
                <input class="input-field" type="text" placeholder="Địa chỉ" name="diaChi" value="<?php echo htmlspecialchars($userData['diaChi']); ?>" required>
            </div>
        </div>

        <div class="input-container">
            <div class="input-row">
                <i class="fa fa-map icon"></i>
                <select class="input-field" id="quan_huyen" name="quan_huyen" onchange="updateHuyen()" required>
                    <option value="">Chọn quận/huyện</option>
                    <?php
                        // Tạo mảng các quận huyện từ JS object để dễ lặp
                        $quan_huyen_list = ["Quận 1", "Quận 3", "Quận 4", "Quận 5", "Quận 6", "Quận 7", "Quận 8", "Quận 10", "Quận 11", "Quận 12", "Quận Bình Tân", "Quận Bình Thạnh", "Quận Gò Vấp", "Quận Phú Nhuận", "Quận Tân Bình", "Quận Tân Phú", "Thành phố Thủ Đức", "Huyện Bình Chánh", "Huyện Cần Giờ", "Huyện Củ Chi", "Huyện Hóc Môn", "Huyện Nhà Bè"];
                        foreach ($quan_huyen_list as $quan) {
                            $selected = ($userData['quan_huyen'] == $quan) ? 'selected' : '';
                            echo "<option value=\"$quan\" $selected>$quan</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="input-container">
            <div class="input-row">
                <i class="fa fa-map-pin icon"></i>
                <select class="input-field" id="phuong_xa" name="phuong_xa" required>
                    <option value="">Chọn phường/xã</option>
                    </select>
            </div>
        </div>

        <input type="submit" value="Xác nhận" name="updateUser">
        <div class="links">
            <a href="accountManage.php" class="back">Quay lại</a>
        </div>
    </form>
</div>
<script>
// Hiển thị thông báo lỗi nếu có
<?php if($emailError): ?>
    document.getElementById('emailError').style.display = 'block';
<?php
 endif; 

ob_end_flush();
?>

// Reset thông báo lỗi khi người dùng bắt đầu nhập lại
document.querySelector('input[name="email"]').addEventListener('input', function() {
    document.getElementById('emailError').style.display = 'none';
});
</script>
</body>
</html>