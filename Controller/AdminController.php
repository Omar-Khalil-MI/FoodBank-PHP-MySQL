<?php
require_once "../View/AdminLoginView.php";
require_once "../Model/AdminModel.php";

class AdminController
{
    public $adminLoginView;

    function __construct()
    {
        $this->adminLoginView = new AdminLoginView();
    }

    function login()
    {
        $error = ((isset($_SESSION['admin_error'])) ? $_SESSION['admin_error'] : "&nbsp");
        $this->adminLoginView->ShowAdminLogin($error);
        unset($_SESSION['admin_error']);
    }

    function showIndex()
    {
        $error = ((isset($_SESSION['admin_error'])) ? $_SESSION['admin_error'] : "&nbsp");
        $this->adminLoginView->ShowAdminIndex(isset($_SESSION['admin_id']), $error);
        unset($_SESSION['admin_error']);
    }

    function adminLogin()
    {
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        $logged = AdminModel::login($username, $password);
        if ($logged)
            header("Location: AdminController.php");
        else
            header("Location: AdminController.php?cmd=login");
        exit();
    }

    function logout()
    {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
}

if (!isset($_SESSION))
    session_start();
$controller = new AdminController();

if (!isset($_GET['cmd'])) {
    $controller->showIndex();
} 
else {
    $command = $_GET['cmd'];
    if ($command == 'login') {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
            $controller->adminLogin();
        else $controller->login();
    } else if ($command == 'logout') {
        $controller->logout();
    }
}
