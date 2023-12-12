<?php
session_start();
class Cart {
    public function emptyCart() {
        $_SESSION['cart'] = [];
    }
}
$cart = new Cart();
$cart->emptyCart();
header('location: ./cart.php');
?>
