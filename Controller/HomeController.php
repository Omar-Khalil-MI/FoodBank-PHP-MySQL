<?php
require_once "../View/HomeView.php";
require_once "../Model/ProgramModel.php";
require_once "../Model/DonorModel.php";

class HomeController
{
    public $homeView;
    function __construct()
    {
        $this->homeView = new HomeView();
    }
    function login()
    {
        $error = ((isset($_SESSION['error'])) ? $_SESSION['error'] : "&nbsp");
        $this->homeView->ShowLogin($error);
        unset($_SESSION['error']);
    }
    function logout()
    {
        session_destroy();
        header("Location: ../Controller/HomeController.php");
        exit();
    }

    function signup()
    {
        header("Location: DonorController.php?cmd=add");
        exit();
    }
    function home()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = sha1($_POST['password']);
            $logged = DonorModel::login($username, $password);
            if ($logged)
                header("Location: ../Controller/HomeController.php");
            else
                header("Location: ../Controller/HomeController.php?cmd=login");
            exit();
        } else {
            $stmt = ProgramModel::view_all();
            $error = ((isset($_SESSION['error'])) ? $_SESSION['error'] : "&nbsp");
            if (isset($_SESSION['user_id']))
                $this->homeView->ShowHome(true, $stmt, $_SESSION['username'], $error);
            else
                $this->homeView->ShowHome(false, $stmt, null, $error);
            unset($_SESSION['error']);
        }
        $this->homeView->PrintFooter();
    }
}


if (!isset($_SESSION))
    session_start();
$controller = new HomeController();
if (!isset($_GET['cmd'])) {
    $controller->home();
} else {
    $command = $_GET['cmd'];
    if ($command == 'login') {
        $controller->login();
    } else if ($command == 'logout') {
        $controller->logout();
    } else if ($command == 'signup') {
        $controller->signup();
    }
}

$controller->homeView->PrintFooter();
