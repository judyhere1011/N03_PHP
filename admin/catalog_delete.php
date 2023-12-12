<?php
session_start();
require('../core/database.php');
require('../core/flash.php');
require('./middleware.php');

class CatalogDelete
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function deleteCatalog($id)
    {
        if (!$this->db->getById('catalog', $id)) {
            Flash::set('message_fail', 'Danh mục không tồn tại');
        } else {
            $result = $this->db->delete('catalog', $id);
            if ($result) {
                Flash::set('message_success', 'Xóa danh mục thành công');
            } else {
                Flash::set('message_fail', 'Xóa danh mục thất bại');
            }
        }
    }
}

$catalogDelete = new CatalogDelete($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $catalogDelete->deleteCatalog($id);
    header('location: ./catalog.php');
} else {
    header('location: ./catalog.php');
}
?>