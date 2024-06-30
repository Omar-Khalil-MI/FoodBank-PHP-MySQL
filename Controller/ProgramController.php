<?php
require_once "../Model/ProgramModel.php";
require_once "../View/ProgramView.php";
require_once "../Model/pdo.php";
require_once "../Model/ItemModel.php";

class ProgramController
{
    public $ProgView;
    function __construct()
    {
        $this->ProgView = new ProgramView();
    }
    public function addController()
    {
        try {
            $ProgModel = new ProgramModel(trim($_POST['name']), trim($_POST['address']));
            $this->ProgView->ChangeProgram($ProgModel->add());
        } catch (PDOException $e) {
            $this->ProgView->ChangeProgram(0);
        }
    }
    public function deleteController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->ProgView->ChangeProgram(ProgramModel::remove($_POST['id']));
            } catch (PDOException $e) {
                $this->ProgView->ChangeProgram(0);
            }
        } else $this->ProgView->deleteRow();
    }
    public function view_allController()
    {
        $stmt = ProgramModel::view_all();
        $this->ProgView->ShowProgramsTable($stmt);
    }

    public function editController()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $ProgModel = new ProgramModel(trim($_POST['name']), trim($_POST['address']));
                $ProgModel->setId($_GET['id']);
                $this->ProgView->ChangeProgram($ProgModel->edit());
            } catch (PDOException $e) {
                $this->ProgView->ChangeProgram(0);
            }
        } else {
            $ProgModel = new ProgramModel();
            if ($ProgModel->getById($_GET['id']) == 0)
                $this->ProgView->ChangeProgram(0);
            else $this->ProgView->EditProgram($ProgModel);
        }
    }
    public function show_to_user()
    {
        $programModel = new ProgramModel();
        if ($programModel->getByHash($_GET['id']) == 0)
            $this->ProgView->ShowNoProgram();
        else {
            $stmt = ItemModel::view_all_id($programModel->getId());
            $this->ProgView->ShowProgramToUser($programModel, $stmt);
        }
    }
}

$controller = new ProgramController();

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

    else if ($command == 'showtouser')
        $controller->show_to_user();
}
$controller->ProgView->PrintFooter();
