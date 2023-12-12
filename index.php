<?php
require('./core/database.php');

class ProductController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProducts($query) {
        return $this->db->getAll($query);
    }

    public function displayProducts($products) {
        foreach ($products as $value) { 
            echo $this->generateProductHTML($value);
        }
    }

    private function generateProductHTML($value) {
        ob_start(); ?>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 re-padding">
            <div class="product_item">
                <div class="product-image">
                    <a href="product.php?id=<?php echo $value['id'] ?>"><img src="./public/images/product/<?php echo $value['image_link']; ?>" alt="" class=""></a>
                </div>
                <p class="product_name"><a href="product.php?id=<?php echo $value['id'] ?>"><?php echo $value['name']; ?></a></p>
                <?php if ($value['discount'] > 0) {
                    $new_price = $value['price'] - $value['discount']; ?>
                    <p><span class='price text-right'><?php echo number_format($new_price); ?> VNĐ</span> <del class="product-discount"><?php echo number_format($value['price']); ?> VNĐ</del></p>
                <?php } else { ?>
                    <p><span class='price text-right'><?php echo number_format($value['price']); ?> VNĐ</span></p>
                <?php } ?>
                <?php if ($value['discount'] != 0) echo '<span class="label_pro">Giảm giá</span>'; ?>
                <p>
                    <?php $raty_tb = round($value['rate_total'] / $value['rate_count']); ?>
                    <?php for ($i2 = 1; $i2 <= $raty_tb; $i2++) { ?>
                        <i class="fa fa-star" style="color:gold"></i>
                    <?php } ?>
                    <?php for ($i3 = 1; $i3 <= (5 - $raty_tb); $i3++) { ?>
                        <i class="fa fa-star-o" style="color: gold"></i>
                    <?php } ?>
                </p>
                <?php
                $query_count = 'SELECT SUM(quantity) As totalproduct FROM sizedetail WHERE product_id = ' . $value['id'];
                $result = $this->db->getFirst($query_count);
                $sl = $result['totalproduct'];
                if ($sl > 0) { ?>
                    <a href="cart_edit.php?id=<?php echo $value['id']; ?>"><button class='btn btn-info'><span class="fa fa-shopping-cart" aria-hidden="true"></span> Thêm giỏ hàng</button></a>
                <?php } else { ?>
                    <a style="pointer-events: none;"><button style="pointer-events: none;background-color: #333;border: none " class='btn btn-info'>Hết hàng</button></a>
                <?php } ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function displayPanel($title, $link, $products) {
        ?>
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-left">
                        <img src="./public/images/icon/<?php echo $link; ?>" alt="">
                        <a href="<?php echo $link; ?>" class='product_title'><?php echo $title; ?></a>
                        <img src="./public/images/icon/<?php echo $link; ?>" alt="">
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearpadding">
                        <?php $this->displayProducts($products); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

$productController = new ProductController($db);

$new_product = $productController->getProducts("select * from product order by id desc limit 4");
$hot_product = $productController->getProducts("select * from product order by buyed desc limit 4");
$view_product = $productController->getProducts("select * from product order by view desc limit 4");

include('./layout/head.php');

$productController->displayPanel("Sản phẩm mới", "product_new.php", $new_product);
$productController->displayPanel("Sản phẩm bán chạy", "ban_chay.php", $hot_product);
$productController->displayPanel("Sản phẩm được xem nhiều", "product_view.php", $view_product);

include('./layout/footer.php');
?>

