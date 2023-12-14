<?php
require('../core/database.php');
require('../core/flash.php');
require('../core/pagination.php');
require('./middleware.php');

class OrderManager {
    private $db;
    private $per_page = 10;
    private $current_page;

    public function __construct($db) {
        $this->db = $db;
        $this->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    }

    public function getOrders() {
        $offset = ($this->current_page - 1) * $this->per_page;
        $sql = "SELECT * FROM transaction ORDER BY id DESC LIMIT $offset, $this->per_page";
        return $this->db->getAll($sql);
    }

    public function getTotalOrders() {
        $sql_total = "SELECT COUNT(*) as total FROM transaction";
        $result = $this->db->getOne($sql_total);
        return $result['total'];
    }

    public function renderPagination() {
        $total = $this->getTotalOrders();
        $total_page = ceil($total / $this->per_page);
        $pagination = new Pagination($total_page, $this->current_page);
        return $pagination->render();
    }
}

$orderManager = new OrderManager($db);
$transaction = $orderManager->getOrders();
?>

<?php include('./layout/head.php'); ?>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Đơn đặt hàng</li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="col-md-8">Quản lý đơn đặt hàng</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="info">
                                <th class="text-center">STT</th>
                                <th>Tên khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Số ĐT</th>
                                <th>Giá tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $stt = 0;
                            foreach ($transaction as $value) {
                                $stt = $stt + 1;
                            ?>
                                <tr>
                                    <td style="vertical-align: middle;text-align: center;"><strong><?php echo $stt; ?></strong></td>
                                    <td><strong><?php echo $value['user_name']; ?></strong></td>
                                    <td><strong><?php echo date_format(date_create($value['created']), 'H:i:s d/m/Y') ?></strong></td>
                                    <td><strong><?php echo $value['user_phone']; ?></strong></td>
                                    <!-- <td><strong><?php echo number_format($value['amount']); ?></strong> VNĐ</td> -->
                                    <td><strong><?php echo number_format($value['amount'], 0, '', ','); ?></strong> VNĐ</td>
                                    <td>
                                        <?php
                                        switch ($value['status']) {
                                            case '0':
                                                echo "<p style='color:red'>Đang chờ </p>";
                                                break;
                                            case '1':
                                                echo "<p style='color:green'>Đã xác nhận</p>";
                                                break;
                                            default:
                                                echo 'Đang chờ';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td class="list_td aligncenter">
                                        <a href="order_detail.php?id=<?php echo $value['id'] ?>" title="Chi tiết"><span class="glyphicon glyphicon-list-alt"></span></a>&nbsp;&nbsp;&nbsp;
                                        <?php if ($value['status'] != 1) { ?>
                                            <a href="order_delete.php?id=<?php echo $value['id'] ?>" title="Hủy"> <span class="glyphicon glyphicon-remove" onclick=" return confirm('Bạn chắc chắn muốn hủy đơn đặt hàng này')"></span> </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?= $orderManager->renderPagination() ?>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->

<?php include('./layout/footer.php'); ?>