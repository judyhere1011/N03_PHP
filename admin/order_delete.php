<?php
require('../core/database.php');
require('../core/flash.php');
require('./middleware.php');

class OrderDelete {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function deleteOrder() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $transaction = $this->db->getById('transaction', $id);

            if (!$transaction) {
                Flash::set('message_fail', 'Đơn hàng không tồn tại');
                header('location: ./order.php');
                exit();
            }

            $info = $this->db->getAll("SELECT * FROM `order` WHERE transaction_id = $id");

            foreach ($info as $key => $value) {
                $sl = 0;
                $size_detail = $this->db->getFirst("SELECT * FROM sizedetail WHERE product_id = {$value['product_id']} AND size_id = {$value['size_id']}");
                $sl = $sl + $value['qty'];

                if ($size_detail) {
                    $id_update_size = $size_detail['id'];
                    $amount = $size_detail['quantity'] + $value['qty'];
                    $data2 = [
                        'product_id' => $value['product_id'],
                        'size_id' => $value['size_id'],
                        'quantity' => $amount,
                    ];
                    $this->db->update('sizedetail', $data2, $id_update_size);
                } else {
                    $data3 = [
                        'product_id' => $value['product_id'],
                        'size_id' => $value['size_id'],
                        'quantity' => $value['qty'],
                    ];
                    $sl = $sl + $value['qty'];
                    $this->db->create('sizedetail', $data3);
                }

                $product = $this->db->getById('product', $value['product_id']);
                $data4 = [
                    'buyed' => $product['buyed'] - $sl,
                ];
                $this->db->update('product', $data4, $value['product_id']);
                $this->db->delete('order', $value['id']);
            }

            $this->db->delete('transaction', $id);
            Flash::set('message_success', 'Xóa đơn đặt hàng thành công');
            header('location: ./order.php');
            exit();
        } else {
            header('location: ./order.php');
            exit();
        }
    }
}

$orderDelete = new OrderDelete($db);
$orderDelete->deleteOrder();
?>