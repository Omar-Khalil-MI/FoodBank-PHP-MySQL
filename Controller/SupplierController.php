<?php
require_once "AuthCheck.php";
require_once "../Model/SupplierModel.php";
require_once "../View/SupplierView.php";

class SupplierController
{
    public $suppView;
    function __construct()
    {
        $this->suppView = new SupplierView();
    }
    public function addController()
    {
        try {
            $suppModel = new SupplierModel(trim($_POST['name']), trim($_POST['address']));
            $this->suppView->ChangeSupplier($suppModel->add());
        } catch (PDOException $e) {
            $this->suppView->ChangeSupplier(0);
        }
    }
    public function deleteController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->suppView->ChangeSupplier(SupplierModel::remove($_POST['id']));
            } catch (PDOException $e) {
                $this->suppView->ChangeSupplier(0);
            }
        } else $this->suppView->deleteRow();
    }
    public function view_allController()
    {
        $stmt = SupplierModel::view_all();
        $this->suppView->ShowSuppliersTable($stmt);
    }

    public function editController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $suppModel = new SupplierModel(trim($_POST['name']), trim($_POST['address']));
                $suppModel->setId($_GET['id']);
                $this->suppView->ChangeSupplier($suppModel->edit());
            } catch (PDOException $e) {
                $this->suppView->ChangeSupplier(0);
            }
        } else {
            $suppModel = new SupplierModel();
            if ($suppModel->getById($_GET['id']) == 0)
                $this->suppView->ChangeSupplier(0);
            else $this->suppView->EditSupplier($suppModel);
        }
    }
}

$controller = new SupplierController();

if (!isset($_SESSION))
    session_start();
AuthCheck::requireAdminLogin();
AuthCheck::requireAdminRole('SupplierController');

if (!isset($_GET['cmd']))
    $controller->view_allController();
else {
    $command = $_GET['cmd'];

    if ($command == 'edit')
        $controller->editController();
    else if ($command == 'add' && $_POST['cmd'] == $command)
        $controller->addController();
    else if ($command == 'delete')
        $controller->deleteController();
}
$controller->suppView->PrintFooter();
