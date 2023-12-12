<?php
require('../core/database.php');
require('../core/flash.php');
require('./middleware.php');

$orderDetail = new OrderDetail($db);

class OrderDetail {
    private $db;
    private $transaction;
    private $listProduct;

    public function __construct($db) {
        $this->db = $db;
        $this->processOrderDetails();
    }

    public function getTransaction() {
        return $this->transaction;
    }

    public function getListProduct() {
        return $this->listProduct;
    }

    public function getTransactionStatus() {
        return $this->transaction['status'];
    }

    public function getTransactionId() {
        return $this->transaction['id'];
    }

    private function processOrderDetails() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if (!$this->db->getById('transaction', $id)) {
                Flash::set('message_fail', 'Đơn hàng không tồn tại');
                header('location: ./order.php');
            } else {
                $this->transaction = $this->db->getById('transaction', $id);
                $info = $this->db->getAll("SELECT * FROM `order` WHERE transaction_id = $id");
                $listProduct = [];
                foreach ($info as $key => $value) {
                    $listProduct[] = $this->db->getFirst("SELECT `order`.`id` as `order_id`, `product`.`id` as `id`, `product`.`name` as `name`, `image_link`, `order`.`qty` as `qty`, `order`.`amount` as `price`, `sizes`.`name` as `size_name` FROM `order` INNER JOIN product ON order.product_id = product.id INNER JOIN sizes ON order.size_id = sizes.id WHERE order.id = {$value['id']}");
                }
                $this->listProduct = $listProduct;
            }
        } else {
            header('location: ./order.php');
        }
    }

    public function renderTransactionInfo() {
        $transaction = $this->getTransaction();
    }

    public function renderOrderDetails() {
        $listProduct = $this->getListProduct();
        echo "<div class='row'>";
        echo "<div class='col-lg-12'>";
        echo "<div class='panel panel-info'>";
        echo "<div class='panel-body'>";
        echo "<h3>Chi tiết đơn đặt hàng</h3>";
        echo "<table class='table table-hover'>";
        echo "<thead>";
        echo "<tr class='info'>";
        echo "<th class='text-center'>STT</th>";
        echo "<th>Tên sản phẩm</th>";
        echo "<th>Số lượng</th>";
        echo "<th>Size</th>";
        echo "<th>Tổng Giá</th>";
    
        if ($this->getTransactionStatus() == '0') {
            echo "<th>Hành động</th>";
        }
    
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $stt = 0;
    
        if (!empty($listProduct)) {
            foreach ($listProduct as $value) {
                $stt++;
                echo "<tr>";
                echo "<td style='vertical-align: middle;text-align: center;'><strong>" . $stt . "</strong></td>";
                echo "<td><img src='../public/images/product/" . $value['image_link'] . "' alt='' style='width: 50px;float:left;margin-right: 10px;'><strong>" . $value['name'] . "</strong></td>";
                echo "<td style='vertical-align: middle'><strong>" . $value['qty'] . "</strong></td>";
                echo "<td style='vertical-align: middle'><strong>" . $value['size_name'] . "</strong></td>";
                echo "<td style='vertical-align: middle'>" . number_format($value['price']) . " VNĐ</td>";
    
                if ($this->transaction['status'] == '0') {
                    echo "<td class='list_td aligncenter'>";
                    echo "<a href='./order_detail_delete.php?id=" . $value['order_id'] . "' title='Xóa'> <span class='glyphicon glyphicon-remove' onclick=' return confirm(\"Bạn chắc chắn muốn xóa\")'></span> </a>";
                    echo "</td>";
                }
    
                echo "</tr>";
            }
        }
    
        echo "</tbody>";
        echo "</table>";
    
        if ($this->getTransactionStatus() == '0') {
            echo "<a href='./order_detail_accept.php?id=" . $this->getTransaction()['id'] . "' class='btn btn-success'> Xác nhận đơn hàng</a>";
        }
    
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    public function renderActionButtons() {
        $transaction = $this->getTransaction();
    }
}
?>

<?php include('./layout/head.php'); ?>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Chi tiết đơn đặt hàng</li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-body">
                <h3>Thông tin khách hàng</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 100px">Họ và tên</td>
                                <td><?php echo $orderDetail->getTransaction()['user_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?php echo $orderDetail->getTransaction()['user_email']; ?></td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td><?php echo $orderDetail->getTransaction()['user_phone']; ?></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td><?php echo $orderDetail->getTransaction()['user_address']; ?></td>
                            </tr>
                            <tr>
                                <td>Tin nhắn</td>
                                <td><?php echo $orderDetail->getTransaction()['message']; ?></td>
                            </tr>
                            <tr>
                                <td>Ngày đặt</td>
                                <td><?php echo date_format(date_create($orderDetail->getTransaction()['created']), "H:i:s d/m/Y"); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div><br>
                <div class="table-responsive"> </div>
            </div>
        </div>
    </div>
</div>

<?php
$orderDetail->renderTransactionInfo();
$orderDetail->renderOrderDetails();
$orderDetail->renderActionButtons();
?>

<?php include('./layout/footer.php'); ?>