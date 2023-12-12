<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../core/database.php');
require('../core/flash.php');
require('../core/pagination.php');
require('./middleware.php');

class UserManager {
    private $db;
    private $pagination;
    private $per_page = 10;

    public function __construct($db) {
        $this->db = $db;

        $total_users = $this->db->count("SELECT * FROM user");
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->pagination = new Pagination($total_users, $current_page);
    }

    public function getUsers() {
        $sql = "SELECT user.id as id, user.name as name, user.email as email, user.password as password, user.phone as phone, user.created as created from user";
        $sql_total = "SELECT * FROM user";
    
        // Tìm kiếm
        if (isset($_GET['search'])) {
            $searchTerm = $this->sanitizeInput($_GET['search']);
            $sql .= " WHERE user.name like '%$searchTerm%'";
            $sql_total .= " WHERE user.name like '%$searchTerm%'";
        }
    
        // Phân trang
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $this->per_page;
        $total = $this->db->count($sql_total);
        $total_page = ceil($total / $this->per_page);
        $sql .= " LIMIT $offset, $this->per_page";
    
        // Thực hiện truy vấn và lấy kết quả
        $users = $this->db->query($sql); 
    
        $paginationHtml = $this->pagination->render();
    
        return ['users' => $users, 'pagination' => $paginationHtml];
    }

    private function sanitizeInput($input) {
        // Thực hiện xử lý lọc dữ liệu đầu vào (prevent SQL injection, XSS, etc.)
        return $input;
    }
}

$userManager = new UserManager($db);
$userData = $userManager->getUsers();
$users = $userData['users'];
$paginationHtml = $userData['pagination'];

include('./layout/head.php');
?>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Tài khoản</li>
    </ol>
</div>

<h3><span id="message"></span></h3>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="col-md-4">Quản lý tài khoản</div>
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
                    // Kiểm tra nếu $users không null
                    if ($users !== null) {
                        foreach ($users as $value) {
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
                    <?php
                        }
                    } else {
                        // Xử lý khi $users là null (hoặc giá trị không mong muốn)
                        echo '<tr><td colspan="6">Không có dữ liệu.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?= $paginationHtml ?>
        </div>
    </div>
</div>
</form>

<?php include('./layout/footer.php'); ?>
