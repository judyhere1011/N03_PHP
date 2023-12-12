<?php
require('../core/database.php');
require('../core/flash.php');
require('./middleware.php');

class OrderDetailDelete {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function deleteOrderDetail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $order = $this->db->getById('order', $id);

            if (!$order) {
                Flash::set('message_fail', 'Order không tồn tại');
                header('location: ./order.php');
                exit();
            }

            $size_detail = $this->db->getFirst("SELECT * FROM sizedetail WHERE product_id = {$order['product_id']} AND size_id = {$order['size_id']}");

            if ($size_detail) {
                $id_update_size = $size_detail['id'];
                $amount = $size_detail['quantity'] + $order['qty'];
                $data2 = [
                    'product_id' => $order['product_id'],
                    'size_id' => $order['size_id'],
                    'quantity' => $amount,
                ];
                $this->db->update('sizedetail', $data2, $id_update_size);
            } else {
                $data3 = [
                    'product_id' => $order['product_id'],
                    'size_id' => $order['size_id'],
                    'quantity' => $order['qty'],
                ];
                $this->db->create('sizedetail', $data3);
            }

            $this->db->delete('order', $id);
            $transaction = $this->db->getById('transaction', $order['transaction_id']);
            $data = [
                'amount' => $transaction['amount'] - $order['amount'],
            ];
            $this->db->update('transaction', $data, $transaction['id']);

            Flash::set('message_success', 'Xóa thành công');
            header("location: ./order_detail.php?id={$order['transaction_id']}");
            exit();
        } else {
            header('location: ./order.php');
            exit();
        }
    }
}

$orderDetailDelete = new OrderDetailDelete($db);
$orderDetailDelete->deleteOrderDetail();
session_write_close();
?>