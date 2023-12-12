<?php
require('../core/database.php');
require('../core/flash.php');
require('../core/upload.php');
require('./middleware.php');

$db = new Database();

class ProductEdit
{
    private $db;
    private $upload;

    public function __construct($db, $upload)
    {
        $this->db = $db;
        $this->upload = $upload;
    }

    public function editProduct($id)
    {
        $product = $this->db->getById('product', $id);

        if (!$product) {
            Flash::set('message_fail', 'Sản phẩm không tồn tại');
            header('location: ./product.php');
            exit;
        }

        $price = $_POST['price'];
        $discount = $_POST['discount'];

        $data = [
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'catalog_id' => $_POST['catalog_id'],
            'price' => str_replace(',', '', $price),
            'discount' => str_replace(',', '', $discount)
        ];

        $image_link = '';
        $image_link = $this->upload->put($_FILES['image']);

        if ($image_link) {
            $data['image_link'] = $image_link;
            $this->upload->delete($product['image_link']);
        }

        $image_list = $this->upload->put_multiple($_FILES['list_image']);
        $image_list_json = json_encode($image_list);

        if (!empty($image_list)) {
            $data['image_list'] = $image_list_json;
            $existing_image_list = json_decode($product['image_list']);

            if (is_array($existing_image_list)) {
                foreach ($existing_image_list as $value) {
                    $this->upload->delete($value);
                }
            }
        }

        $kq = $this->db->update('product', $data, $id);

        if ($kq) {
            $sizes = $this->db->getAll("SELECT * FROM sizes");

            foreach ($sizes as $size) {
                $id_size = $_POST['size_' . $size['id']];
                $quantity = $_POST['quantity_' . $size['id']];

                if ($id_size > 0 && $quantity > 0) {
                    $get_id = $this->db->getFirst("select * from sizedetail where product_id = $id and size_id = $id_size order by id desc limit 1");

                    if ($get_id) {
                        $id_update_size = $get_id['id'];
                    } else {
                        $id_update_size = 0;
                    }

                    if ($id_update_size != 0) {
                        $data2 = [
                            'product_id' => $id,
                            'size_id' => $id_size,
                            'quantity' => $quantity,
                        ];
                        $this->db->update('sizedetail', $data2, $id_update_size);
                    } else {
                        if ($id_size > 0 && $quantity == 0) {
                            $get_id = $this->db->getFirst("select * from sizedetail where product_id = $id and size_id = $id_size order by id desc limit 1");
                            $id_update_size = $get_id['id'];

                            if ($id_update_size != 0) {
                                $this->db->delete('sizedetail', $id_update_size);
                            }
                        } else {
                            $data2 = [
                                'product_id' => $id,
                                'size_id' => $id_size,
                                'quantity' => $quantity,
                            ];
                            $this->db->create('sizedetail', $data2);
                        }
                    }
                }
            }

            Flash::set('message_success', 'Cập nhật sản phẩm thành công');
            header('location: ./product.php');
            exit;
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productEdit = new ProductEdit($db, new Upload());

    if (isset($_POST['submit'])) {
        $productEdit->editProduct($id);
    } else {
        $id = $_GET['id'];

        if (!$db->getById('product', $id)) {
            Flash::set('message_fail', 'Sản phẩm không tồn tại');
            header('location: ./product.php');
            exit;
        } else {
            $catalog = $db->getAll("SELECT * from catalog where parent_id = 1 order by sort_order asc");

            foreach ($catalog as $key => $value) {
                $subs = $db->getAll("SELECT * from catalog where parent_id = {$value['id']}");
                $catalog[$key]['sub'] = $subs;
            }

            $product = $db->getById('product', $id);
            $sizes = $db->getAll("select * from sizedetail where product_id = $id");
            $str = '';

            foreach ($sizes as $s) {
                $str = $str . ' AND id NOT IN(' . $s['size_id'] . ')';
            }

            $get_size = 'SELECT * FROM sizes WHERE sizes.id ' . $str . ' ';
            $sizes2 = $db->getAll($get_size);
        }
    }
} else {
    header('location: ./product.php');
    exit;
}

session_write_close();
?>

<?php include('./layout/head.php'); ?>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home">
                    <use xlink:href="#stroked-home"></use>
                </svg></a></li>
        <li class="active">Sản phẩm</li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                Chỉnh sửa thông tin sản phẩm
            </div>
            <div class="panel-body">
                <form class="form-horizontal" name="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Tên sản phẩm</label>
                        <div class="col-sm-5">
                            <input type="text" name='name' class="form-control" id="inputEmail3" placeholder="" value="<?php echo $product['name']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Hình ảnh</label>
                        <img src="../public/images/product/<?php echo $product['image_link'] ?>" alt="" style="width: 50px;float:left;margin-left: 15px;">
                        <div class="col-sm-3">
                            <input type="file" id="image" name="image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Hình ảnh kèm theo</label>
                        <?php
                        $image_list = json_decode($product['image_list']);
                        if (is_array($image_list)) {
                            foreach ($image_list as $value) {
                        ?>
                                <img src="../public/images/product/<?php echo $value ?>" alt="" style="width: 50px;float:left;margin-left: 15px;">
                        <?php
                            }
                        }
                        ?>
                        <div class="col-sm-5">
                            <input type="file" id="list_image" name="list_image[]" multiple>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Chi tiết</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="3" name="content" id='content'><?php echo $product['content']; ?></textarea>
                        </div>
                    </div>
                    <script>
                        CKEDITOR.replace('content');
                    </script>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Danh mục</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="catalog_id" required>
                                <option>--- Chọn danh mục sản phẩm ---</option>
                                <?php
                                foreach ($catalog as $value) {
                                    if (count($value['sub']) > 1) {
                                ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if ($product['catalog_id'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
                                        <?php foreach ($value['sub'] as $val) { ?>
                                            <option value="<?php echo $val['id']; ?>" <?php if ($product['catalog_id'] == $val['id']) echo 'selected'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['name']; ?></option>
                                        <?php }
                                        ?>

                                    <?php } else { ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if ($product['catalog_id'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Giá tiền</label>
                        <div class="col-sm-5">
                            <input type="text" name='price' class="form-control" id="inputEmail3" placeholder="" value="<?php echo number_format($product['price']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Giảm giá</label>
                        <div class="col-sm-5">
                            <input type="text" name='discount' class="form-control" id="inputEmail3" placeholder="" value="<?php echo number_format($product['discount']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail4" class="col-sm-2 control-label">Chi tiết số lượng</label>
                        <?php
                        foreach ($sizes as $size) {
                        ?>
                            <label for="inputEmail3" class="col-lg-1" style="margin-top: 10px;text-align: right">
                                <?php $res = $db->getById('sizes', $size['size_id']);
                                echo $res['name']; ?></label>
                            <div class="col-lg-1">
                                <input type="hidden" name='size_<?php echo $size['size_id']; ?>' class="form-control" placeholder="" value='<?php echo $size['size_id'] ?>'>
                                <input type="text" name='quantity_<?php echo $size['size_id']; ?>' class="form-control" placeholder="" value="<?php echo $size['quantity'] ?>">
                            </div>
                        <?php } ?>
                        <?php for ($i = 0; $i < sizeof($sizes2); $i++) { ?>
                            <label for="inputEmail3" class="col-lg-1" style="margin-top: 10px;text-align: right">
                                <?php $res = $db->getById('sizes', $sizes2[$i]['id']);
                                echo $res['name'] ?>
                            </label>
                            <div class="col-lg-1">
                                <input type="hidden" name='size_<?php echo $sizes2[$i]['id']; ?>' class="form-control" placeholder="" value='<?php echo $sizes2[$i]['id'] ?>'>
                                <input type="text" name='quantity_<?php echo $sizes2[$i]['id']; ?>' class="form-control" placeholder="" value="0">
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-5">
                            <button type="submit" name="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--/.row-->
<?php include('./layout/footer.php'); ?>
<script src="./public/js/ckeditor/ckeditor.js"></script>
<script src="./public/js/ckeditor/config.js"></script>
<script src="./public/js/ckeditor/lang/vi.js"></script>
<script src="./public/js/ckeditor/styles.js"></script>
<script>
    CKEDITOR.replace('content');
</script>