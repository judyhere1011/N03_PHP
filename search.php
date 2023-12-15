<?php
require('./core/database.php');
require('./core/flash.php');

class Search
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function searchProductsByName($name)
    {
        return $this->db->getAll("SELECT * FROM product WHERE name LIKE '%$name%'");
    }

    public function filterProducts($catalogId, $priceFrom, $priceTo)
    {
        $list = $this->db->getById("catalog", $catalogId);
        $sqlProduct = "SELECT * FROM product WHERE true";

        if ($list['parent_id'] == '1') {
            $listChild = $this->db->getAll("SELECT * FROM catalog WHERE parent_id = $catalogId");
            $listId = array_map(function ($value) {
                return $value['id'];
            }, $listChild);
            $strList = implode(",", $listId);
            $sqlProduct .= " AND catalog_id IN ($strList)";
        } else {
            $sqlProduct .= " AND catalog_id = $catalogId";
        }

        $sqlProduct .= " AND price >= $priceFrom AND price <= $priceTo ORDER BY price ASC";
        return $this->db->getAll($sqlProduct);
    }
}

$productManager = new ProductManager($db);

if (isset($_GET['name'])) {
    $productList = $productManager->searchProductsByName($_GET['name']);
    $total = count($productList);
} else {
    $catalogId =  $_GET['catalog_id'];
    $priceFrom = $_GET['price_from'];
    $priceTo = $_GET['price_to'];

    $productList = $productManager->filterProducts($catalogId, $priceFrom, $priceTo);
    $total = count($productList);
}

?>
<?php include('./layout/head.php') ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearpadding" style="margin-top: 15px;">
        <?php include('./admin/layout/message.php') ?>
        <?php include('./layout/sidebar.php') ?>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 clearpaddingr">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearpadding">
                <ol class="breadcrumb">
                    <li><a href="./"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Trang chủ</a></li>
                    <li class="active">Tìm kiếm sản phẩm</li>
                </ol>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Kết quả tìm kiếm ( <?php echo $total; ?> sản phẩm)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearpadding">
                            <?php
                            foreach ($productList as $value) { ?>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 re-padding">
                                    <div class="product_item">
                                        <div class="product-image">
                                            <a href="product.php?id=<?php echo $value['id']; ?>"><img src="./public/images/product/<?php echo $value['image_link']; ?>" alt="" class=""></a>
                                        </div>
                                        <p class="product_name"><a href="product.php?id=<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a></p>
                                        <?php
                                        if ($value['discount'] > 0) {
                                            $new_price = $value['price'] - $value['discount'];
                                        ?>
                                            <p><span class='price text-right'><?php echo number_format($new_price); ?> VNĐ</span> <del class="product-discount"><?php echo number_format($value['price']); ?> VNĐ</del></p>
                                        <?php } else { ?>
                                            <p><span class='price text-right'><?php echo number_format($value['price']); ?> VNĐ</span></p>
                                        <?php } ?>
                                        <?php
                                        if ($value['discount'] != 0)
                                            echo '<span class="label_pro">Giảm giá</span>';
                                        ?>
                                        <p>
                                            <?php $raty_tb = round($value['rate_total'] / $value['rate_count']); ?>
                                            <?php
                                            $i2 = 1;

                                            for ($i2; $i2 <= $raty_tb; $i2++) {
                                                echo '<i class="fa fa-star" style="color:gold"></i>';
                                            }
                                            $i3 = 1;
                                            for ($i3; $i3 <= (5 - $raty_tb); $i3++) {
                                                echo '<i class="fa fa-star-o" style="color: gold"></i>';
                                            }
                                            ?>
                                        </p>
                                        <?php
                                        $query_count = 'SELECT SUM(quantity) As totalproduct FROM sizedetail WHERE product_id = ' . $value['id'];
                                        $result = $db->getFirst($query_count);
                                        $sl = $result['totalproduct'];
                                        if ($sl > 0) {
                                        ?>
                                            <a href="cart_edit.php?id=<?php echo $value['id']; ?>"><button class='btn btn-info'><span class="fa fa-shopping-cart" aria-hidden="true"></span> Thêm giỏ hàng</button></a>
                                        <?php } else { ?>
                                            <a style="pointer-events: none;"><button style="pointer-events: none;background-color: #333;border: none " class='btn btn-info'>Hết hàng</button></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('./layout/footer.php') ?>
