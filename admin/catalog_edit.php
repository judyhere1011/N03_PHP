<?php

require('../core/database.php');
require('../core/flash.php');
require('./middleware.php');

class CatalogEdit
{
    private $db;
    private $id;
    private $catalog;
    private $list;

    public function __construct()
    {
        $this->db = new Database();
        $this->initialize();
    }

    private function initialize()
    {
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            if (!$this->db->getById('catalog', $this->id)) {
                Flash::set('message_fail', 'Danh mục không tồn tại');
                header('location: ./catalog.php');
            } else {
                $this->catalog = $this->db->getById('catalog', $this->id);
                $this->list = $this->db->getAll("SELECT * FROM catalog WHERE parent_id < 2 ORDER BY id DESC");
            }
        } else {
            header('location: ./catalog.php');
        }

        if (isset($_POST['submit'])) {
            $this->updateCatalog();
        }

        session_write_close();
    }

    private function updateCatalog()
    {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'parent_id' => $_POST['parent_id'],
            'sort_order' => $_POST['sort_order'],
        ];

        $kq = $this->db->update('catalog', $data, $this->id);

        if ($kq) {
            Flash::set('message_success', 'Cập nhật danh mục thành công');
            header('location: ./catalog.php');
        } else {
            Flash::set('message_fail', 'Cập nhật danh mục thất bại');
        }
    }

    public function displayForm()
    {
        include('./layout/head.php');
        ?>
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Danh mục</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Sửa danh mục
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" name="" method="post">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Tên danh mục</label>
                                <div class="col-sm-5">
                                    <input type="text" name='name' class="form-control" id="inputEmail3" placeholder="" value="<?php echo isset($this->catalog['name']) ? $this->catalog['name'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Mô tả</label>
                                <div class="col-sm-5">
                                    <textarea class="form-control" rows="3" name="description"><?php echo isset($this->catalog['description']) ? $this->catalog['description'] : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Danh mục cha</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="parent_id">
                                        <option value='0' <?php if (isset($this->catalog['parent_id']) && $this->catalog['parent_id'] == '0') echo 'selected'; ?>>Menu gốc</option>
                                        <option value='1' <?php if (isset($this->catalog['parent_id']) && $this->catalog['parent_id'] == '1') echo 'selected'; ?>>Thời trang</option>
                                        <?php foreach ($this->list as $value) {
                                            if ($value['parent_id'] > 0) { ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if (isset($this->catalog['parent_id']) && $this->catalog['parent_id'] == $value['id']) echo 'selected'; ?>>&nbsp;&nbsp;&nbsp;<?php echo $value['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if (isset($this->catalog['parent_id']) && $this->catalog['parent_id'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Thứ tự</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="sort_order">
                                        <?php for ($i = 1; $i < 10; $i++) { ?>
                                            <option value='<?php echo $i; ?>' <?php if (isset($this->catalog['sort_order']) && $this->catalog['sort_order'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
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
        </div>
        <?php
        include('./layout/footer.php');
    }
}

$catalogEditor = new CatalogEdit();
$catalogEditor->displayForm();

?>