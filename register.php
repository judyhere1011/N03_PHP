<?php 
    include './layout/head.php';
    require './user.php';

    $title = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
    
        if ($password !== $confirmPassword) {
            $title = "Mật khẩu xác nhận không khớp";
            echo "<script>alert('" . $title . "');</script>";
        } else {
            $user = new User($name, $email, $phone, $address, $password);
            
            if ($user->register()) {
                header('Location: login.php');
            }
            
        }
    }
    
?>
     
<section class="my-5 py-5" style="background-color: #eee;">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Đăng Ký</h2>
        <hr class="mx-auto">
    </div>  
    <div class="mx-auto container">
        <form id="register-form" method="POST">
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
                <input type="submit" class="btn" id="register-btn" value="Đăng ký"/>
            </div>
            <div class="form-group">
                <a id="login-url" class="btn" href="login.php">Bạn đã có tài khoản? Đăng nhập </a>
            </div>
        </form>
    </div>
</section>

<?php include './layout/footer.php' ?>