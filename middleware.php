<?php

class Middleware
{
    private $auth = false;
    public function __construct()
    {
        $this->checkAuthentication();
    }

    private function checkAuthentication()
    {
        if (isset($_SESSION['admin'])) {
            $this->auth = true;
        }

        if (isset($_COOKIE['admin'])) {
            $this->auth = true;
        }

        if (!$this->auth) {
            $this->redirectToLogin();
        }
    }

    private function redirectToLogin()
    {
        header('location: ./login.php');
        exit;
    }

    public function isAuthorized()
    {
        return $this->auth;
    }
}

$middleware = new Middleware();

// Kiểm tra quyền truy cập
if (!$middleware->isAuthorized()) {
    // $middleware->redirectToLogin();
}
?>