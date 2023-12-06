<?php 
    session_start();
    include './layout/head.php';


    $title = "First Login";
    if(isset($_POST['login_btn'])){
        
        $email = trim($_POST['email']);
        $password = md5($_POST['password']);

        // buoc1 so khop du lieu tu form vs db 
        $check = mysqli_query($conn,"SELECT * FROM user WHERE email = '$email'");

        $errors;
        if(mysqli_num_rows($check) == 1){
            $data = mysqli_fetch_assoc($check);
            $pass = $data['password'];

            $checPass = password_verify($pass);

            if($checPass){
              // lưu vao session 
              $_SESSION['login'] = $data;

              if(isset($_GET['url'])){
                header('location: '.$_GET['url']);
              } else {
                 header('location: index.php');
              }
             
            } else{
              $title = "Mật khẩu không chính xác";
              include 'header-modal.php';
            }

        } else{
          $title = "Tài khoản không tồn tại";
          include 'header-modal.php';
        }      
    }

    if (isset($_GET['register'])) {
      echo "<script>alert('Đăng kí thành công')</script>";  
    }
 ?>

<html>
<head>
    <title> Login </title>
</head>
<body>
<section class="my-5 py-5" style="background-color: #eee;">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Đăng Nhập</h2>
        <hr class="mx-auto">
    </div>  
    <div class="mx-auto container">
        <form id="login-form" action="login.php" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="Địa chỉ Email" required/>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Mật khẩu" required/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" name="login-btn" value="Đăng nhập"/>
            </div>
            <div class="form-group">
                <a id="register-url" class="btn" href="register.php">Bạn chưa có tài khoản? Đăng ký ngay</a>
            </div>
        </form>
    </div>
</section>
</body>
</html> 

<?php 
  include './layout/footer.php'
?>