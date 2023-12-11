<?php
require('./core/database.php');
require('./core/cart.php');

class ProductManager {
    private $db;
    private $cart;

    public function __construct($db, $cart) {
        $this->db = $db;
        $this->cart = $cart;
    }

    public function getReferringPage() {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }

    public function redirectToReferringPage($defaultPage = './index.php') {
        $referringPage = $this->getReferringPage();
        $redirectPage = $referringPage ? $referringPage : $defaultPage;
        header("location: $redirectPage");
        exit;
    }

    public function handleProductActions() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $product = $this->db->getById('product', $id);

            if (!$product) {
                Flash::set('message_fail', 'Sản phẩm không tồn tại');
                $this->redirectToReferringPage();
            }

            $size_array = $this->db->getAll("SELECT * FROM sizedetail WHERE product_id = $id ORDER BY size_id ASC");
            $size_id = null;
            $max_quantity_size = 0;

            if (isset($_GET['size_id'])) {
                $size_id = $_GET['size_id'];
                $size_detail = $this->db->getFirst("SELECT * FROM sizedetail WHERE product_id = $id AND size_id = $size_id");

                if (!$size_detail || $size_detail['quantity'] == 0) {
                    $this->redirectToReferringPage();
                }

                $size_id = $size_detail['size_id'];
                $max_quantity_size = $size_detail['quantity'];
            } else {
                foreach ($size_array as $size) {
                    if ($size['quantity'] > 0) {
                        $size_id = $size['size_id'];
                        $max_quantity_size = $size['quantity'];
                        break;
                    }
                }
            }

            if ($size_id) {
                if (isset($_GET['quantity'])) {
                    $quantity = $_GET['quantity'];
                    $this->cart->setQuantity($product['id'], $size_id, $max_quantity_size, $quantity);
                } else if (isset($_GET['minus'])) {
                    $this->cart->minusQuantity($product['id'], $size_id);
                } else if (isset($_GET['plus'])) {
                    $this->cart->plusQuantity($product['id'], $size_id, $max_quantity_size);
                } else {
                    $this->cart->plusQuantity($product['id'], $size_id, $max_quantity_size);
                }
            }

            $this->redirectToReferringPage();
        }
    }
}

$productManager = new ProductManager($db, new Cart());
$productManager->handleProductActions();
