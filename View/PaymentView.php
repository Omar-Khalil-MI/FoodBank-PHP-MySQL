<?php
require_once "../View/ViewAbst.php";

class PaymentView extends ViewAbst
{
    function ShowPaymentOptions($cost)
    {
        session_start();
        echo ('
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/donate.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
                <link rel="icon" href="../Resources/logo.ico">
                <title>Food Bank</title>
            </head>
            
            <body>
                <header>
                    <h1>Payment</h1>
                    <nav>
                        <ul>
                            <a href="../Controller/CartController.php" class="cart">
                                <li><i class="fa-solid fa-cart-shopping"></i> Cart</li>
                            </a>
                        </ul>
                    </nav>
                </header>

                <div class="container">
                    <div class="overlay-container">
                        <div class="admin-object-form-container centered">
                            <form action="PaymentController.php?cmd=result" method="post">
                                <h1>Payment</h1>
                                <h2>Total cost: ' . $cost . ' EGP<h2><br>
                                <input type="hidden" name="cost" value="' . $cost . '"> 
                                <label for="paymentmethod"> Choose Payment Method </label>
                                <select id="paymentmethod" name = "paymentmethod">
                                    <option value="Fawry">Fawry</option>
                                    <option value="Visa">Visa</option>
                                </select>
                                <br><br><input type="submit" class="btn" value="Pay Now" >
                                <a class="btn" href="../Controller/CartController.php">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
                
                <footer>
                    <p>© 2024 Food Bank</p>
                </footer>
            </body>
            
            </html>
        ');
    }
    function PaymentError($result)
    {
        echo ('
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/CRUD.css">
                <link rel="icon" href="../Resources/logo.ico">
                <title>Food Bank</title>
            </head>
            
            <body>
                <header>
                    <h1>Food Bank</h1>
                    <nav>
                        <ul>
                            <a href="HomeController.php"><li>Home</li></a>
                        </ul>
                    </nav>
                </header>
        ');
        $this->PrintMessage($result);
        $this->PrintFooter();
    }
}
