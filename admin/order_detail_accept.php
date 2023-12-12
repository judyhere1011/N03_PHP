<?php
require('../core/database.php');
require('../core/flash.php');
require('./middleware.php');

class OrderDetailAccept {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function acceptOrderDetail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $transaction = $this->db->getById('transaction', $id);

            if (!$transaction) {
                Flash::set('message_fail', 'Đơn hàng không tồn tại');
                header('location: ./order.php');
                exit();
            }

            $data = [
                'status' => 1,
            ];

            $kq = $this->db->update('transaction', $data, $id);
            Flash::set('message_success', 'Xác nhận đơn đặt hàng thành công');
            header('location: ./order.php');
            exit();
        } else {
            header('location: ./order.php');
            exit();
        }
    }
}

$orderDetailAccept = new OrderDetailAccept($db);
$orderDetailAccept->acceptOrderDetail();
session_write_close();
?>