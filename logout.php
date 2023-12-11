<?php

class AdminLogout
{
    public function __construct()
    {
        session_start();
        $this->logout();
    }

    private function logout()
    {
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }

        if (isset($_COOKIE['admin'])) {
            setcookie('admin', '', time() - 1, '/');
        }

        header('location: ./login.php');
    }
}

// Sử dụng đối tượng AdminLogout
$adminLogout = new AdminLogout();
?>