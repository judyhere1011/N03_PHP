<?php
require('../core/database.php');
require('../core/flash.php');
require('../core/pagination.php');
require('./middleware.php');

class ProductManager
{
    private $db;
    private $perPage;
    private $currentPage;
    private $offset;
    private $totalPage;
    private $pagination;
    private $searchQuery;
    private $productData;

    public function __construct($db)
    {
        $this->db = $db;
        $this->perPage = 10;
        $this->currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->offset = ($this->currentPage - 1) * $this->perPage;
        $this->searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

        $this->initProductData();
    }

    private function initProductData()
    {
    $sql = "SELECT product.id as id, product.name as name, price, discount, image_link, view, buyed, catalog.name as namecatalog
            FROM product INNER JOIN catalog ON catalog.id = product.catalog_id";

    $sql_total = "SELECT COUNT(*) as total FROM product";

    // Tìm kiếm
    if ($this->searchQuery) {
        $searchString = mysqli_real_escape_string($this->db->getConnection(), "%{$this->searchQuery}%");
        $sql .= " WHERE product.name LIKE '$searchString'";
        $sql_total .= " WHERE product.name LIKE '$searchString'";
    }

    // Phân trang
    $sql .= " LIMIT $this->offset, $this->perPage";

    $total = $this->db->query($sql_total)->fetch_assoc()['total'];
    $this->totalPage = ceil($total / $this->perPage);

    $this->pagination = new Pagination($this->totalPage, $this->currentPage);
    $this->productData = $this->db->getAll($sql);
    }

    public function renderProductTable()
    {
        ob_start();
        include('./layout/head.php');
        $this->renderSearchForm();
        $this->renderProductList();
        include('./layout/footer.php');
        echo ob_get_clean();
    }

    private function renderSearchForm()
    {
        ?>
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home">
                            <use xlink:href="#stroked-home"></use>
                        </svg></a></li>
                <li class="active">Sản phẩm</li>
            </ol>
        </div>
        <h3><span id="message"></span></h3>
        <?php
    }

    private function renderProductList()
    {
        ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="col-md-4">Quản lý sản phẩm
                </div>
                <div class="col-md-2" style="float:right"><a href="./product_add.php" class='btn btn-info'><svg class="glyph stroked plus sign">
                            <use xlink:href="#stroked-plus-sign" />
                        </svg> Thêm sản phẩm</a></div>
                <div class="col-md-1"></div>
                <div class="col-md-6" style="float:right;margin-top: 5px">
                    <form role="search" method="get">
                        <div class="form-group">
                            <input name="search" type="text" class="form-control" placeholder="Nhập tên sản phẩm" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                        </div>
                        <button class="btn text-right" style="position: absolute;right: 16px;top: 2px;float:right; padding: 4px 8px 4px 8px;" type="submit"><img src="./public/images/ic_search.png" /></button>
                    </form>
                </div>
            </div>
            <div class="panel-body">
                <?php if ($this->productData) : ?>
                <form action="" method="post">
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                            <tr class="info">
                                <th class="text-center">ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->productData as $value) { ?>
                                <tr>
                                    <td style="vertical-align: middle;text-align: center;"><strong><?php echo $value['id']; ?></strong></td>
                                    <td><img src="../public/images/product/<?php echo $value['image_link']; ?>" alt="" style="width: 50px;float:left;margin-right: 10px;"><strong><?php echo $value['name']; ?></strong>
                                        <p style="font-size: 12px;margin-top: 4px;">View: <?php echo $value['view']; ?> <span> | Đã bán :<?php echo $value['buyed']; ?></span></p>
                                    </td>
                                    <td style="vertical-align: middle"><strong><?php echo $value['namecatalog']; ?></strong></td>
                                    <td style="vertical-align: middle">
                                        <?php
                                        if ($value['discount'] > 0) {
                                            $price_new = $value['price'] - $value['discount'];
                                        ?>
                                            <strong><?php echo number_format($price_new); ?> VNĐ</strong><br><del><?php echo number_format($value['price']); ?> VNĐ</del>
                                        <?php } else { ?>
                                            <strong><?php echo number_format($value['price']); ?> VNĐ</strong>
                                        <?php } ?>
                                    </td>
                                    <td class="list_td aligncenter">
                                        <a href="./product_edit.php?id=<?= $value['id'] ?>" title="Sửa"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
                                        <a href="./product_delete.php?id=<?php echo $value['id']; ?>" title="Xóa" class="remove" onclick=" return confirm('Xóa sản phẩm sẽ đặt số lượng bằng 0')"> <span class="glyphicon glyphicon-remove"></span> </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                        <?= $this->pagination->render() ?>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

// Sử dụng class ProductManager
$productManager = new ProductManager($db);
$productManager->renderProductTable();
?>