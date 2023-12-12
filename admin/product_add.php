<?php
require('../core/database.php');
require('../core/flash.php');
require('../core/upload.php');
require('./middleware.php');

$db = new Database(); // Khởi tạo đối tượng Database
$productAdd = new ProductAdd($db);

class ProductAdd
{
    private $db;
    private $dataForm;

    public function __construct($db)
    {
        $this->db = $db;
        $this->dataForm = [
            'name' => '',
            'image' => '',
            'price' => '',
            'discount' => '',
            'content' => '',
            'catalog_id' => '',
        ];
    }

    public function handleFormSubmission()
    {
        if (isset($_POST['submit'])) {
            $upload = new Upload;

            $image_link = $upload->put($_FILES['image']);
            $image_list = $upload->put_multiple($_FILES['list_image']);
            $image_list = json_encode($image_list);

            $data = [
                'name' => $_POST['name'],
                'image_link' => $image_link,
                'image_list' => $image_list,
                'content' => $_POST['content'],
                'catalog_id' => $_POST['catalog_id'],
                'price' => $_POST['price'],
                'discount' => $_POST['discount'],
            ];

            $kq = $this->db->create('product', $data);

            if ($kq) {
                $this->addSizeDetails();
                Flash::set('message_success', 'Thêm sản phẩm thành công');
                header('location: ./product.php');
            } else {
                Flash::set('message_fail', 'Tạo sản phẩm thất bại');
            }

            $this->dataForm = $data;
        }
    }

    private function addSizeDetails()
    {
        $data1 = [];
        $input = [];
        $sizes = $this->db->getAll("SELECT * from sizes");

        foreach ($sizes as $size) {
            $id_size = $_POST['size_' . $size['id']];
            $quantity = $_POST['quantity_' . $size['id']];

            if ($id_size > 0 && $quantity > 0) {
                $input = [
                    'order' => ['id', 'DESC'],
                    'limit' => ['1', '0']
                ];

                $get_id = $this->db->getLastId('product');
                $id_pro = $get_id['id'];

                $data2 = [
                    'product_id' => $id_pro,
                    'size_id' => $id_size,
                    'quantity' => $quantity,
                ];

                $kq1 = $this->db->create('sizedetail', $data2);
            }
        }
    }

    public function getCatalogs()
    {
        $catalog = $this->db->getAll("SELECT * from catalog where parent_id = 1 order by sort_order asc");

        foreach ($catalog as $key => $value) {
            $subs = $this->db->getAll("SELECT * from catalog where parent_id = {$value['id']}");
            $catalog[$key]['sub'] = $subs;
        }

        return $catalog;
    }

    public function renderForm()
    {
        $catalog = $this->getCatalogs();
        session_write_close();

        include('./layout/head.php'); ?>

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
                        Thêm sản phẩm
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Tên sản phẩm</label>
                                <div class="col-sm-5">
                                <input type="text" name='name' class="form-control" id="inputEmail3" placeholder="" value="<?php echo $this->dataForm['name']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Hình ảnh</label>
                                <div class="col-sm-5">
                                    <input type="file" id="image" name="image" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Hình ảnh kèm theo</label>
                                <div class="col-sm-5">
                                    <input type="file" id="list_image" name="list_image[]" multiple>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Danh mục</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="catalog_id" required>
                                        <option value="">--- Chọn danh mục sản phẩm ---</option>
                                        <?php
                                        foreach ($catalog as $value) {
                                            if (count($value['sub']) > 1) {
                                        ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if ($this->dataForm['catalog_id'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
                                                <?php foreach ($value['sub'] as $val) { ?>
                                                    <option value="<?php echo $val['id']; ?>" <?php if ($this->dataForm['catalog_id'] == $val['id']) echo 'selected'; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['name']; ?></option>
                                                <?php }
                                            } else { ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if ($this->dataForm['catalog_id'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
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
                                    <input type="text" name='price' class="form-control" id="inputEmail3" placeholder="" value="<?php echo $this->dataForm['price']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Giảm giá</label>
                                <div class="col-sm-5">
                                    <input type="text" name='discount' class="form-control" id="inputEmail3" placeholder="" value="<?php echo $this->dataForm['discount']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Chi tiết</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="3" name="content" id='content'><?php echo $this->dataForm['content']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail4" class="col-sm-2 control-label">Chi tiết số lượng</label>
                                <?php
                                $sizes = $this->db->getAll("SELECT * FROM sizes");
                                foreach ($sizes as $size) {
                                ?>
                                    <label for="inputEmail3" class="col-lg-1" style="margin-top: 10px;text-align: right"><?php echo $size['name'] ?></label>
                                    <div class="col-lg-1">
                                        <input type="hidden" name='size_<?php echo $size['id']; ?>' class="form-control" placeholder="" value='<?php echo $size['id'] ?>'>
                                        <input type="text" name='quantity_<?php echo $size['id']; ?>' class="form-control" placeholder="" value="0">
                                    </div>

                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-5">
                                    <button type="submit" name="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include('./layout/footer.php');
        ?>

        <script src="./public/js/ckeditor/ckeditor.js"></script>
        <script src="./public/js/ckeditor/config.js"></script>
        <script src="./public/js/ckeditor/lang/vi.js"></script>
        <script src="./public/js/ckeditor/styles.js"></script>
        <script>
            CKEDITOR.replace('content');
        </script>

        <?php
    }
}

// Sử dụng class ProductAdd
$productAdd = new ProductAdd($db);
$productAdd->handleFormSubmission();
$productAdd->renderForm();

?>