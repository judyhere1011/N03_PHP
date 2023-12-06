<?php 
    include './layout/head.php';
    $title = "";
    if(isset($_POST['name'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $check = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
        if (mysqli_num_rows($check) == 1) {
          $title = "Email đã tồn tại, vui lòng nhập email khác";
          include 'header-modal.php';
        } else {
          $phone = $_POST['phone'];
          $password = $_POST['password'];
          $confirmPassword = $_POST['confirm_password'];
          if (strcmp($password, $confirmPassword) != 0) {
            $title = "Mật khẩu xác nhận không khớp";
            include 'header-modal.php';
          } else {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            
            $query = mysqli_query($conn,"INSERT INTO user (name,email,password, phone) VALUES ('$name','$email','$pass','$phone')");
            header('location: login.php?register=true');
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
        <form id="register-form">
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
                <input type="password" class="form-control" id="register-confirm-password" name="confirm-password" placeholder="Nhập lại mật khẩu" required/>
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