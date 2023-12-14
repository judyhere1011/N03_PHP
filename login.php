<?php
// session_start();
include './layout/head.php';
require './user.php';

$title = "First Login";
$userService = new UserService($db);

// Xử lý login
if (isset($_POST['login_btn'])) {
    ob_start();

    $email = $_POST['email'];
    $enteredPassword = $_POST['password'];

    $stmt = $db->getConnection()->prepare("SELECT id, name, email, password, phone, address FROM user WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        $stmt->bind_result($id, $name, $email, $storedPassword, $phone, $address);
        $stmt->store_result();

        if ($stmt->num_rows() == 1) {
            $stmt->fetch();

            // Use password_verify to check if entered password matches the stored hashed password
            if (password_verify($enteredPassword, $storedPassword)) {
                $_SESSION['user'] = array(
                    'id' => $id,
                    'name' => $name,
                    'email' => $email
                );
                $_SESSION['logged_in'] = true;
                var_dump($_SESSION);
                header('location: index.php?message= Đăng nhập thành công!');
                // var_dump($_SESSION);

            } else {
                header('location: login.php?error=Tài khoản không tồn tại hoặc mật khẩu không đúng');
            }
        } else {
            header('location: login.php?error=Tài khoản không tồn tại');
        }
    } else {
        // Error
        header('location: login.php?error=Hệ thống đang gặp lỗi, không thể đăng nhập. Vui lòng thử lại sau');
    }
}

// Show registration success message
// if (isset($_GET['register'])) {
//     echo "<script>alert('Đăng kí thành công')</script>";
// }
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
            <p style = "color: red" class="text-center"> <?php if(isset($_GET['error'])){echo $_GET['error']; } ?> </p>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="Địa chỉ Email" required/>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Mật khẩu" required/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" name="login_btn" value="Đăng nhập"/>
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

