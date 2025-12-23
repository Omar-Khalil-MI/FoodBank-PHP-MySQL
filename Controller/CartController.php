<?php
require_once "../View/CartView.php";
require_once "AuthCheck.php";

class CartController
{
    public $cartView;
    function __construct()
    {
        $this->cartView = new CartView();
    }
    public function showCartController()
    {
        $this->cartView->ShowCart();
    }
    public function addToCartController()
    {
        if (!isset($_SESSION))
            session_start();
        if (empty($_SESSION['cart']))
            $_SESSION['cart'] = array();
        $_SESSION['cart'][$_POST['item']] = $_POST['quantity'];
        header("Location: CartController.php");
        exit();
    }
    public function removeItemController()
    {
        $item = $_GET['item'];
        unset($_SESSION['cart'][$item]);
        $this->cartView->ShowCart();
    }
    public function removeAllController()
    {
        $_SESSION['cart'] = array();
        header("Location: CartController.php");
        exit();
    }
}

if(!isset($_SESSION)) 
    session_start(); 

AuthCheck::requireDonorLogin();

$controller = new CartController();

if (!isset($_GET['cmd']))
    $controller->showCartController();
else {
    $command = $_GET['cmd'];
    if ($command == 'addToCart')
        $controller->addToCartController();
    else if ($command == 'removeitem')
        $controller->removeItemController();
    else if ($command == 'removeall')
        $controller->removeAllController();
}
$controller->cartView->PrintFooter();
