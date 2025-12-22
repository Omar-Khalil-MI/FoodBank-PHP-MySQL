<?php
require_once "ViewAbst.php";
require_once "../Model/ProgramModel.php";
require_once "../Model/ItemModel.php";
require_once "../Model/DonorModel.php";

class DonationDetailsView extends ViewAbst
{
    function ShowDonationDetailsTable($rows)
    {
        $itemModel = new ItemModel();
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
                    <title>Donation Details</title>
            </head>
            
            <body>
                <header>
                        <h1>Donation Database</h1>
                        <nav>
                            <ul>
                                <a href="../Controller/AdminController.php"><li>Dashboard</li></a>
                                <a href="../Controller/DonationController.php"><li>Back</li></a>
                            </ul>
                        </nav>
                </header>
                
                <div class="container">
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead>
                            <tr>
                                <th>Donation ID</th>
                                <th>Item Name</th>
                                <th>Program Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
        ');
        foreach ($rows as $row) {
            $itemModel->getById($row['item_id']);
            echo ('
                            <tr>
                                <td>' . $row['donation_id'] . '</td>
                                <td>' . $itemModel->getItemName() . '</td>
                                <td>' . ProgramModel::get_ProgramName($itemModel->getProgramID()) . '</td>
                                <td>' . $row['Qty'] . '</td>
                                <td>' . $row['price'] . 'EGP</td>
                                <td>' . $row['Qty'] * $row['price'] . 'EGP</td>
                            </tr>
            ');
        }
    }

    function ShowReciept($donation, $rows)
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
                <title>Reciept</title>
            </head>
            
            <body>
                <header>
                    <h1>Food Bank</h1>
                </header>

                <div class="container">
                    <h2>Donor Name: ' . $_SESSION['username'] . '</h2><br>
                    <h2>Total Cost: ' . $donation->get_TotalCost() . 'EGP</h2><br>
                    <h2>Donation Date: ' . $donation->getDonationDate() . '</h2><br>
                    <h2>Paid via: ' . $donation->getMethod() . '</h2><br>
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead><tr>
                                <th>Id</th>
                                <th>Item Id</th>
                                <th>Item Name</th>
                                <th>Program Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr></thead>
        ');
        $item = new ItemModel();
        foreach ($rows as $row) {
            $item->getById($row['item_id']);
            echo ('
                            <tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['item_id'] . '</td>
                                <td>' . $item->getItemName() . '</td>
                                <td>' . ProgramModel::get_ProgramName($item->getProgramID()) . '</td>
                                <td>' . $row['price'] . 'EGP</td>
                                <td>' . $row['Qty'] . '</td>
                                <td>' . $row['price'] * $row['Qty'] . 'EGP</td>
                            </tr>
            ');
        }
        echo ('
                        </table>
                    </div>
                    <a class="btn" href="../Controller/HomeController.php">Return Home</a>
                </div>
            </body>
            
            </html>
        ');
    }
}
