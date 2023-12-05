<?php
require('./core/database.php');
require('./core/flash.php');


if (isset($_POST['comment'])) {
    $data = [
        'name' => $_POST['name'],
        'content' => $_POST['content'],
        'product_id' => $_POST['product_id'],
    ];
    $db->create('comment', $data);
}
if (isset($_GET['id']) && isset($_GET['comment_id']) && isset($_GET['reply'])) {
    $data = [
        'reply' => $_GET['reply'],
    ];
    $db->update('comment', $data, $_GET['comment_id']);
    header('location: ./product.php?id='.$_GET['id']);
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (!$db->getById('product', $id)) {
        Flash::set('message_fail', 'Sản phẩm không tồn tại');
        header('location: ./index.php');
    } else {
        $product = $db->getById('product', $id);
        $size_array = $db->getAll("select sizedetail.*, sizes.name as size_name from sizedetail inner join sizes on sizes.id = sizedetail.size_id where sizedetail.product_id = $id");
        $catalog_product = $db->getById('catalog', $product['catalog_id']);
        $image_list = json_decode($product['image_list']);
        $productsub = $db->getAll("select * from product where catalog_id = {$product['catalog_id']} limit 4");
        $productview = $db->getAll("select * from product order by buyed desc limit 4");
        $comments = $db->getAll("select * from comment where product_id = $id order by date desc");
        
        $auth = false;
        if (isset($_SESSION['admin'])) {
            $auth = $_SESSION['admin'];
        }

        if (isset($_COOKIE['admin'])) {
            $auth = unserialize($_COOKIE['admin']);
        }
    }
} else {
    header('location: ./index.php');
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
                    <li><a href="catalog.php?id=<?php echo $catalog_product['id'] ?>"><?php echo $catalog_product['name']; ?></a></li>
                    <li class="active"><?php echo $product['name']; ?></li>
                </ol>
                <!-- zoom image -->
                <!-- <link rel="stylesheet" href="./public/js/jqzoom_ev/css/jquery.jqzoom.css" type="text/css"> -->
                <div class="panel panel-info ">
                    <div class="panel-heading cus-color">
                        <h3 class="panel-title">Xem chi tiết sản phẩm</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="text-center">
                            <img src="./public/images/product/<?php echo $product['image_link']; ?>" alt="" style="max-width:380px;max-height: 500px">
                        <div class="clearfix"></div>
                            <ul id="thumblist" style="margin-top: 20px;">
                            <?php if (is_array($image_list)) : ?>
                                        <?php foreach ($image_list as $value) { ?>
                                            <li>
                                                <a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: './public/images/product/<?php echo $value ?>',largeimage: './public/images/product/<?php echo $value ?>'}">
                                                    <img src='./public/images/product/<?php echo $value; ?>'>
                                                </a>
                                            </li>
                                        <?php } ?> <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding: 10px">
                            <h1 style="font-size: 22px;text-transform:uppercase;color: #111111;font-weight:bold;"><?php echo $product['name']; ?></h1>
                            <p><?php echo $product['content']; ?></p>

                            <?php
                            if ($product['discount'] > 0) {
                                $price_new = $product['price'] - $product['discount'];
                            ?><p>Giá cũ: <strong><del><?php echo number_format($product['price']) ?> VNĐ</del></strong></p>
                                <p>Giá khuyến mại: <span style="font-weight: bold;color: green"><?php echo number_format($price_new); ?> VNĐ</span></p>
                            <?php } else { ?>
                                <p>Giá: <span style="font-weight: bold;color: green"><?php echo number_format($product['price']); ?> VNĐ</span></p> <?php
                                                                                                                                                }
                                                                                                                                                    ?>
                            <p>Size hiện có:
                                <?php
                                foreach ($size_array as $size) {
                                ?>
                                    <span><?php echo $size['quantity'] ?> - <?php echo $size['size_name']; ?> ; </span>
                                <?php } ?>

                                <?php if (sizeof($size_array) == 0) { ?>
                                    <span>Sản phẩm đã hết hàng</span>
                                <?php } ?>
                            </p>
                            <p>Số lượt xem: <?php echo $product['view']; ?></p>
                            <p> Đánh giá &nbsp;
                                <?php $raty_tb = $product['rate_total'] / $product['rate_count']; ?>
                                <span> <?php echo round($raty_tb, 2); ?>/</span><b class='rate_count'><?php echo $product['rate_count']; ?></b>
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
                            <form action="cart_edit.php" method="get">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <label for="size_id">Chọn size</label>
                                <select name="size_id" id="size_id" class="form-control" style="margin-bottom: 10px;">
                                    <?php foreach ($size_array as $size) : ?>
                                        <option value="<?= $size['size_id'] ?>"><?= $size['size_name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <button type="submit" class="btn btn-info"> Thêm vào giỏ hàng</a>
                            </form>
                        </div>
                    </div>
                </div>