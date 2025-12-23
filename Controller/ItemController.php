<?php
require_once "AuthCheck.php";
require_once "../Model/ItemModel.php";
require_once "../View/ItemView.php";
require_once "../Model/AdminModel.php";

class ItemController
{
    public $itemView;
    function __construct()
    {
        $this->itemView = new ItemView();
    }
    public function addController()
    {
        try {
            $itemModel = new ItemModel(
                trim($_POST['program_id']),
                trim($_POST['item_name']),
                trim($_POST['item_cost']),
                trim($_POST['amount'])
            );
            $this->itemView->ChangeItem($itemModel->add());
        } catch (PDOException $e) {
            $this->itemView->ChangeItem(0);
        }
    }
    public function deleteController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            $this->itemView->ChangeItem(ItemModel::remove($_POST['id']));
        else $this->itemView->deleteRow();
    }
    public function view_allController()
    {
        $stmt = ItemModel::view_all();
        $notifications = NotificationModel::getByAdmin($_SESSION['admin_id']);
        $count = count($notifications);
        $unreadcount = NotificationModel::getUnreadCount($_SESSION['admin_id']);
        $this->itemView->ShowItemsTable($stmt, $notifications, $count, $unreadcount);
    }
    public function editController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $itemModel = new ItemModel(
                    trim($_POST['program_id']),
                    trim($_POST['item_name']),
                    trim($_POST['item_cost']),
                    trim($_POST['amount']),
                );
                $itemModel->setId($_GET['id']);
                $this->itemView->ChangeItem($itemModel->edit());
            } catch (PDOException $e) {
                $this->itemView->ChangeItem(0);
            }
        } else {
            $itemModel = new ItemModel();
            if ($itemModel->getById($_GET['id']) == 0)
                $this->itemView->ChangeItem(0);
            else $this->itemView->EditItem($itemModel);
        }
    }
}

$controller = new ItemController();

if (!isset($_SESSION))
    session_start();
AuthCheck::requireAdminLogin();
AuthCheck::requireAdminRole('ItemController');
if (!isset($_GET['cmd']))
    $controller->view_allController();
else {
    $command = $_GET['cmd'];

    if ($command == 'edit')
        $controller->editController();
    else if ($command == 'add' && $_GET['cmd'] == $command)
        $controller->addController();
    else if ($command == 'delete')
        $controller->deleteController();
}
$controller->itemView->PrintFooter();
