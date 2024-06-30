<?php
require_once "ViewAbst.php";

class DistributorView extends ViewAbst
{
    function ShowDistributorsTable($rows)
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
                <title>Distributor Database</title>
            </head>
            
            <body>
                <script>
                    function togglePopup() { 
                        const overlay = document.getElementById("popupOverlay"); 
                        overlay.classList.toggle("show"); 
                    } 
                </script>

                <header>
                    <h1>Distributor Database</h1>
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
                                <form action="DistributorController.php?cmd=add" method="post">
                                    <h3>add a new distributor</h3>
                                    <input type="text" placeholder="Distributor Name" name="name" class="box" required>
                                    <input type="text" placeholder="Distributor Address" name="address" class="box" required>
                                    <input type="hidden" name="cmd" value="add">
                                    <input type="submit" class="btn" name="add_distributor" value="Create">
                                    <input type="button" class="btn" name="add_item" value="Cancel" onclick="togglePopup()">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead><tr>
                                <th>Distributor ID</th>
                                <th>Distributor name</th>
                                <th>Distributor address</th>
                                <th>Action</th>
                            </tr></thead>
            ');
        foreach ($rows as $row)
            echo ('
                            <tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['name'] . '</td>
                                <td>' . $row['address'] . '</td>
                                <td>
                                    <a href="DistributorController.php?cmd=edit&id=' . $row['id'] . '" class="btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="DistributorController.php?cmd=delete&id=' . $row['id'] . '" class="btn">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
            ');
    }

    function ChangeDistributor($succ)
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
                            <a href="DistributorController.php"><li>Return</li></a>
                        </ul>
                    </nav>
                </header>
        ');
        $this->PrintMessage($succ);
    }

    function EditDistributor($obj)
    {
        echo ('
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/CRUD.css">
                <link rel="icon" href="../Resources/logo.ico">
                <title>Edit Distributor</title>
            </head>
            
            <body>
                <style> body{background-color: #329443;}</style>
                <div class="container">
                    <div class="admin-object-form-container centered">
                        <form method="post">
                            <h3 class="title">Edit distributor</h3>
                            <input type="text" class="box" name="name" value="' . $obj->getName() . '" 
                                placeholder="Distributor Name" required>
                            <input type="text" min="0" class="box" name="address" value="' . $obj->getAddress() . '"
                                placeholder="Distributor Address" required>
                            <input type="submit" value="Update" name="update_distributor" class="btn">
                            <a href="DistributorController.php" class="btn">Cancel</a>
                        </form>
                    </div>
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
                <title>Delete Distributor</title>
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
                                <form action="../Controller/DistributorController.php?cmd=delete" method="post">
                                    <div class="alert alert-danger fade in">
                                        <input type="hidden" name="id" value="' . trim($_GET["id"]) . '"/>
                                        <p>Are you sure you want to delete this record?</p><br>
                                        <p>
                                            <input type="submit" value="Yes" class="btn btn-danger">
                                            <a href="../Controller/DistributorController.php"
                                                class="btn btn-default">No</a>
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
