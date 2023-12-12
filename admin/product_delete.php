<?php
require('../core/database.php');
require('../core/upload.php');
require('../core/flash.php');
require('./middleware.php');

class ProductDelete
{
    private $db;
    private $upload;

    public function __construct($db, $upload) {
        $this->db = $db;
        $this->upload = $upload;
    }

    public function deleteProduct($id) {
        if (!$this->db->getById('product', $id)) {
            Flash::set('message_fail', 'Sản phẩm không tồn tại');
        } else {
            $product = $this->db->getById('product', $id);
            $image_link = $product['image_link'];
            $image_list = json_decode($product['image_list']);

            foreach ($image_list as $item) {
                $this->upload->delete($item);
            }

            $this->upload->delete($image_link);
            $kq = $this->db->delete('product', $id);
            $kq1 = $this->db->query("DELETE FROM sizedetail WHERE product_id = {$product['id']}");

            if ($kq && $kq1) {
                Flash::set('message_success', 'Xóa sản phẩm thành công');
            } else {
                Flash::set('message_fail', 'Xóa sản phẩm thất bại');
            }
        }

        header('location: ./product.php');
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productDelete = new ProductDelete($db, new Upload());
    $productDelete->deleteProduct($id);
} else {
    header('location: ./product.php');
}

session_write_close();
?>