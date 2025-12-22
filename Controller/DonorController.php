<?php
require_once "AuthCheck.php";
require_once "../Model/DonorModel.php";
require_once "../View/DonorView.php";
require_once "../Model/DonationDetailsModel.php";

class DonorController
{
  public $donorView;
  function __construct()
  {
    $this->donorView = new DonorView();
  }
  function signup()
  {
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : "&nbsp";
    $this->donorView->signup($error);
    unset($_SESSION['error']);
  }
  function updateAccount($id)
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $donorModel = new DonorModel(
        $_SESSION['username'],
        $_POST['birthdate'],
        trim(strtolower($_POST['email'])),
        "",
        trim($_POST['phone']),
        $_POST['gender'],
        $id
      );
      if (!$donorModel->exists())
        $donorModel->edit();
      $this->myaccount($id);
    }
  }
  function myaccount($id)
  {
    $error = ((isset($_SESSION['error'])) ? $_SESSION['error'] : "&nbsp");
    $donor = new DonorModel();
    $donor->getById($id);
    $this->donorView->ShowDonorDetails($donor, $error);
    unset($_SESSION['error']);
  }
  function viewAll()
  {
    $stmt = DonorModel::view_all();
    $this->donorView->ShowDonorsTable($stmt);
  }
  function view_donations()
  {
    $stmt = DonationDetailsModel::view_all_donor($_SESSION['user_id']);
    $this->donorView->ShowMyDD($stmt);
  }
  function signupValid()
  {
    $username = trim($_POST['username']);
    $password = sha1($_POST['password']);
    $email = trim(strtolower($_POST['email']));
    $phone = trim($_POST['phone']);
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];

    $donormodel = new DonorModel($username, $birthdate, $email, $password, $phone, $gender);
    if ($donormodel->exists()) {
      header("Location: ../Controller/DonorController.php?cmd=signup");
      exit();
    } else {
      $donormodel->add();
      header("Location: ../Controller/HomeController.php?cmd=login");
      exit();
    }
  }
}

$controller = new DonorController();
session_start();

if (!isset($_GET['cmd']))
  $controller->viewAll();
else {
  $command = $_GET['cmd'];
  if ($command == 'signup') {

    if ($_SERVER["REQUEST_METHOD"] == "POST")
      $controller->signupValid();
    else $controller->signup();
  } else if ($command == 'myacc') {
    AuthCheck::requireDonorLogin();
    if ($_SERVER["REQUEST_METHOD"] == "POST")
      $controller->updateAccount($_SESSION['user_id']);
    else $controller->myaccount($_SESSION['user_id']);
  } else if ($command == 'viewdonations') {
    AuthCheck::requireDonorLogin();
    $controller->view_donations();
  }
}
