<?php
require_once "ViewAbst.php";
require_once "../Model/ProgramModel.php";
require_once "../Model/ItemModel.php";

class CartView extends ViewAbst
{
    function ShowCart()
    {
        echo ('
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/CRUD.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
                <link rel="icon" href="../Resources/logo.ico">
                <title>My Cart</title>
            </head>
            
            <body>
                <header>
                    <h1>My Cart</h1>
                    <nav>
                        <ul>
                            <a href="../Controller/HomeController.php"><li>Home</li></a>
                        </ul>
                    </nav>
                </header>
        ');
        if (empty($_SESSION['cart']))
            echo ('<div class="message">Cart is empty</div>');
        else {
            echo ('
                <div class="container">
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead><tr>
                                <th>Item Name</th>
                                <th>Program Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr></thead>
            ');
            $total = 0;
            foreach ($_SESSION['cart'] as $item => $quantity) {
                $itemModel = new ItemModel();
                $programModel = new ProgramModel();
                $itemModel->getById($item);
                $programModel->getById($itemModel->getProgramID());
                $total += $quantity * $itemModel->getCost();
                echo ('
                            <tr>
                                <td>' . $itemModel->getItemName() . '</td>
                                <td>' . $programModel->getProgramName() . '</td>
                                <td>' . $quantity . '</td>
                                <td>' . $itemModel->getCost() . 'EGP</td>
                                <td>' . $quantity * $itemModel->getCost() . 'EGP</td>
                                <td>
                                    <a href="CartController.php?cmd=removeitem&item=' . $item . '" class="btn"> 
                                        <i class="fas fa-edit"></i> Remove
                                    </a>
                                </td>    
                            </tr>
                ');
            }
            echo ('
                        </table>
                        <div class="message">Grand Total: ' . $total . 'EGP</div>
                        
                        <form id="cart-form" action="../Controller/PaymentController.php?cmd=paymentoptions" method="post">
                            <h1 style="font-size: 20px">Increase My Impact</h1>
                            <p style="font-size: 14px">
                                <input type="checkbox" id="tr_add" name="tr_add">
                                Add 5EGP to help cover our transaction fees.<br>
                                <input type="checkbox" id="other_add" name="other_add">
                                Add 10EGP to help cover other fees associated with the donation.
                            </p>
                            <input type="hidden" id="cost" name="cost" value="' . $total . '"><br>
                            <button class="btn" type="submit" value="pay" >Proceed to Payment</button>
                            <a href="CartController.php?cmd=removeall" class="btn"> Remove All </a>
                        </form>
            ');
        }
    }
}
