<?php
require_once "../Model/DistributorModel.php";
require_once "../View/DistributorView.php";

class DistributorController
{
    public $distView;
    function __construct()
    {
        $this->distView = new DistributorView();
    }
    public function addController()
    {
        try {
            $distModel = new DistributorModel(trim($_POST['name']), trim($_POST['address']));
            $this->distView->ChangeDistributor($distModel->add());
        } catch (PDOException $e) {
            $this->distView->ChangeDistributor(0);
        }
    }
    public function deleteController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->distView->ChangeDistributor(DistributorModel::remove($_POST['id']));
            } catch (PDOException $e) {
                $this->distView->ChangeDistributor(0);
            }
        } else $this->distView->deleteRow();
    }
    public function view_allController()
    {
        $stmt = DistributorModel::view_all();
        $this->distView->ShowDistributorsTable($stmt);
    }

    public function editController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $distModel = new DistributorModel(trim($_POST['name']), trim($_POST['address']));
                $distModel->setId($_GET['id']);
                $this->distView->ChangeDistributor($distModel->edit());
            } catch (PDOException $e) {
                $this->distView->ChangeDistributor(0);
            }
        } else {
            $distModel = new DistributorModel();
            if ($distModel->getById($_GET['id']) == 0)
                $this->distView->ChangeDistributor(0);
            else $this->distView->EditDistributor($distModel);
        }
    }
}

$controller = new DistributorController();

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
$controller->distView->PrintFooter();
