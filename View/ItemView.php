<?php

require_once "../View/ViewAbst.php";
require_once "../Model/ProgramModel.php";

class ItemView extends ViewAbst
{
    function ShowItemsTable($rows)
    {
        echo (' 
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/CRUD.css">
                <link rel="stylesheet" href="../CSS/popup.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
                <link rel="icon" href="../Resources/logo.ico">
                <title>Item Database</title>
            </head>
            
            <body>
                <script> 
                    function togglePopup() { 
                        const overlay = document.getElementById("popupOverlay"); 
                        overlay.classList.toggle("show"); 
                    } 
                </script> 
                
                <header>
                    <h1>Item Database</h1>
                    <nav>
                        <ul>
                            <a href="../index.php"><li>Dashboard</li></a>
                        </ul>
                    </nav>
                </header>
                
                <div class="container">
                    <button onclick="togglePopup()" class="btn">Create New Entry</button>
                    <div id="popupOverlay" class="overlay-container">
                        <div class="popup-box">
                            <div class="admin-object-form-container">
                                <form action="../Controller/ItemController.php?cmd=add" method="post">
                                    <h3>add a new item</h3>
                                    <input type="text" placeholder="Item Name" name="item_name" class="box" required>
                                    <input type="number" placeholder="Item Amount" min="0" max="2000000000" 
                                        name="amount" class="box" required>
                                    <input type="number" step="0.001" min="0" max="3.402823466E+38" 
                                        placeholder="Item Cost" name="item_cost" class="box" required>
                                    <label for="program_id"> Choose Program: </label>
                                    <select id="program_id" name = "program_id">
        ');
        foreach (ProgramModel::get_IDs() as $program)
            echo ('<option value="' . $program['id'] . '">' . ProgramModel::get_ProgramName($program['id']) . '</option>');
        echo ('
                                    </select>
                                    <input type="submit" class="btn" name="add_item" value="Create">
                                    <input type="button" class="btn" name="add_item" value="Cancel" onclick="togglePopup()">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="object-display">
                    <table class="object-display-table">
                    <thead><tr>
                        <th>item ID</th>
                            <th>program name</th>
                            <th>item name</th>
                            <th>item cost</th>
                            <th>item amount</th>
                            <th>action</th>
                    </tr></thead>
        ');
        foreach ($rows as $row)
            echo ('
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . ProgramModel::get_ProgramName($row['program_id']) . '</td>
                    <td>' . $row['item_name'] . '</td>
                    <td>' . $row['item_cost'] . "EGP" . '</td>
                    <td>' . $row['amount'] . '</td>
                    <td>
                        <a href="ItemController.php?cmd=edit&id=' . $row['id'] . '" class="btn"> 
                            <i class="fas fa-edit"></i> Edit
                        </a> 
                        <a href="ItemController.php?cmd=delete&id=' . $row['id'] . '" class="btn">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            ');
    }
    function ChangeItem($succ)
    {
        echo ('
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
                            <a href="ItemController.php"><li>Return</li></a>
                        </ul>
                    </nav>
                </header>
        ');
        $this->PrintMessage($succ);
    }
    function EditItem($obj)
    {
        echo ('
        <!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="../Resources/logo.ico">
            <link rel="stylesheet" href="../CSS/CRUD.css">
            <title>Edit Item</title>
        </head>
        
        <body>
            <style> body{background-color: #329443;}</style>
            <div class="admin-object-form-container centered">
                <form  method="post">
                    <h3 class="title">Edit item</h3>
                    <input type="text" class="box" name="item_name" value="' . $obj->getItemName() . '" 
                        placeholder="Item Name">
                    <input type="number" min="0" max="2000000000" class="box" name="amount" 
                        value="' . $obj->getAmount() . '" placeholder="Item Amount">
                    <input type="number" class="box" step="0.001" min="0" max="3.402823466E+38" name="item_cost" 
                        value="' . $obj->getCost() . '" placeholder="Item Cost">
                    <label for="program_id"> Choose Program: </label>
                    <select id="program_id" name = "program_id">
        ');
        foreach (ProgramModel::get_IDs() as $program)
            echo ('<option value="' . $program['id'] . '">' . ProgramModel::get_ProgramName($program['id']) . '</option>');
        echo ('
                    </select>
                    <input type="submit" value="Update" name="update_item" class="btn">
                    <a href="../Controller/ItemController.php" class="btn">Cancel</a>
                </form>
            </div>
        </body>
        
        </html>
    ');
    }
    function deleteRow()
    {
        echo ('
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Delete Item</title>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
                    <link rel="stylesheet" href="../CSS/CRUD.css">
                    <link rel="icon" href="../Resources/logo.ico">
                    <style type="text/css">
                        .wrapper{
                            width: 500px;
                            margin: 0 auto;
                        }
                    </style>
                </head>
                <body>
                    <div class="wrapper">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header">
                                        <h1>Delete Record</h1>
                                    </div>
                                    <form action="../Controller/ItemController.php?cmd=delete" method="post">
                                        <div class="alert alert-danger fade in">
                                            <input type="hidden" name="id" value="' . trim($_GET["id"]) . '"/>
                                            <p>Are you sure you want to delete this record?</p><br>
                                            <p>
                                                <input type="submit" value="Yes" class="btn btn-danger">
                                                <a href="../Controller/ItemController.php" class="btn btn-default">
                                                    No
                                                </a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>        
                        </div>
                    </div>
                </body>
            </html>
        ');
    }
}
