<?php
require('../core/database.php');
require('../core/flash.php');
require('../core/pagination.php');
require('./middleware.php');

$sql = "SELECT user.id as id,user.name as name,user.email as email,user.password as password,user.phone as phone,user.created as created from user";
$sql_total = "SELECT * FROM user";

// tìm kiếm
if (isset($_GET['search'])) {
    $sql .= " WHERE user.name like '%{$_GET['search']}%'";
    $sql_total .= " WHERE user.name like '%{$_GET['search']}%'";
}
// phân trang
$per_page = 10;
$current_page = 1;
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
}
$offset = ($current_page - 1) * $per_page;
$total = $db->count($sql_total);
$total_page = ceil($total / $per_page);
$sql .= " LIMIT $offset,$per_page";
$pagination = new Pagination($total_page, $current_page);

$user = $db->getAll($sql);
?>
<?php include('./layout/head.php'); ?>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home">
                    <use xlink:href="#stroked-home"></use>
                </svg></a></li>
        <li class="active">Tài khoản</li>
    </ol>
</div>
<h3><span id="message"></span></h3>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="col-md-4">Quản lý tài khoản
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6" style="float:right;margin-top: 5px">
            <form role="search" method="get">
                <div class="form-group">
                    <input name="search" type="text" class="form-control" placeholder="Nhập tên tài khoản" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                </div>
                <button class="btn text-right" style="position: absolute;right: 16px;top: 2px;float:right; padding: 4px 8px 4px 8px;" type="submit"><img src="./public/images/ic_search.png" /></button>
            </form>
        </div>
    </div>
    <div class="panel-body">
        <form action="" method="post">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="info">
                            <th class="text-center">ID</th>
                            <th>Tên tài khoản</th>
                            <th>Email</th>
                            <th>Mật khẩu</th>
                            <th>Số điện thoại</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $id = 0;
                            foreach ($user as $value) {
                                $id = $id + 1;
                            ?>
                                <tr>
                                    <td style="vertical-align: middle;text-align: center;"><strong><?php echo $id; ?></strong></td>
                                    <td><strong><?php echo $value['name']; ?></strong></td>
                                    <td><strong><?php echo $value['email']; ?></strong></td>
                                    <td><strong><?php echo $value['password']; ?></strong></td>
                                    <td><strong><?php echo $value['phone']; ?></strong></td>
                                    <td><strong><?php echo $value['created']; ?></strong></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?= $pagination->render() ?>
            </div>
    </div>
</div>
</form>
<?php include('./layout/footer.php'); ?>