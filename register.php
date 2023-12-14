<?php 
include './layout/head.php';
require './user.php';

// session_start();

if(isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // So sánh password với confirm password
    if($password !== $confirmPassword){
        header('location: ./register.php?error=Mật khẩu không khớp');
    } else if(strlen($password) < 6){
        header('location: register.php?error=Mật khẩu phải ít nhất 6 ký tự');
    } else {
        // Kiểm tra email đã có chưa
        $stmt1 = $db->getConnection()->prepare("SELECT COUNT(*) FROM user WHERE email=?");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->fetch();

        // Nếu tài khoản với email đó đã tồn tại
        if($num_rows != 0){
            header('location: register.php?error= Email đã tồn tại, vui lòng nhập email khác');
        } else {
            $stmt1->close();

            // Thêm user mới
            $stmt = $db->getConnection()->prepare("INSERT INTO user (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");

            // Sử dụng password_hash để mã hoá mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bind_param('sssss', $name, $email, $hashedPassword, $phone, $address);

            // Nếu tạo tài khoản thành công
            if($stmt->execute()){
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                $_SESSION['logged_in'] = true;
                $stmt->close();
                header('location: login.php?register=Tạo tài khoản thành công');
            } else {
                $stmt->close();
                header('location: register.php?error=Không thể tạo tài khoản bây giờ');
            }
        }
        $stmt1->close();
        $stmt->close();
    }
}
?>

     
<section class="my-5 py-5" style="background-color: #eee;">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Đăng Ký</h2>
        <hr class="mx-auto">
    </div>  
    <div class="mx-auto container">
        <form id="register-form" method="POST" action="register.php">
            <p style="color: red;"><?php if(isset($_GET['error'])){echo $_GET['error'];}?> </p>  
            <div class="form-group">
                <label>Họ tên</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Nhập họ tên" required/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="register-email" name="email" placeholder="Địa chỉ Email" required/>
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" class="form-control" id="register-phone" name="phone" placeholder="Số điện thoại" required/>
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" class="form-control" id="register-address" name="address" placeholder="Địa chỉ" required/>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" class="form-control" id="register-password" name="password" placeholder="Mật khẩu" required/>
            </div>
            <div class="form-group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="register-confirm-password" name="confirm_password" placeholder="Nhập lại mật khẩu" required/>
            </div>

            <div class="form-group">
                <input type="submit" class="btn" id="register-btn" name="register" value="Đăng ký"/>
            </div>
            <div class="form-group">
                <a id="login-url" class="btn" href="login.php">Bạn đã có tài khoản? Đăng nhập </a>
            </div>
        </form>
    </div>
</section>

<?php include './layout/footer.php' ?>
