<?php
require_once "ViewAbst.php";
require_once  "../Model/ItemModel.php";

class ProgramView extends ViewAbst
{
    function ShowProgramsTable($rows)
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
                <title>Program Database</title>
            </head>
            
            <body>
                <script> 
                    function togglePopup() { 
                        const overlay = document.getElementById("popupOverlay"); 
                        overlay.classList.toggle("show"); 
                    } 
                </script> 
                
                <header>
                    <h1>Program Database</h1>
                    <nav>
                        <ul>
                            <a href="../Controller/AdminController.php"><li>Dashboard</li></a>
                            <a href="../Controller/AdminController.php?cmd=logout"><li>Logout</li></a>
                        </ul>
                    </nav>
                </header>
            
                <div class="container">
                    <button onclick="togglePopup()" class="btn">Create New Entry</button>
                    <div id="popupOverlay" class="overlay-container">
                        <div class="popup-box">
                            <div class="admin-object-form-container">
                                <form action="ProgramController.php?cmd=add" method="post">
                                    <h3>add a new Program</h3>
                                    <input type="text" placeholder="Program Name" name="name" class="box" required>
                                    <textarea style="resize: none" placeholder="Program Description" name="address" 
                                        class="box" required></textarea>
                                    <input type="hidden" name="cmd" value="add">
                                    <input type="submit" class="btn" name="add_Program" value="Create">
                                    <input type="button" class="btn" name="add_item" value="Cancel" onclick="togglePopup()">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead><tr>
                                <th nowrap>Program ID</th>
                                <th nowrap>Program name</th>
                                <th>Program Description</th>
                                <th>Action</th>
                            </tr></thead>
        ');
        foreach ($rows as $row) {
            echo ('
                            <tr><td>' . $row['id'] . '</td>
                            <td>' . $row['program_name'] . '</td>
                            <td align="left">' . $row['description'] . '</td>
                            <td>
                                <a href="ProgramController.php?cmd=edit&id=' . $row['id'] . '" class="btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="ProgramController.php?cmd=delete&id=' . $row['id'] . '" class="btn">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td></tr>
            ');
        }
    }
    function ChangeProgram($succ)
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
                            <a href="ProgramController.php"><li>Return</li></a>
                        </ul>
                    </nav>
                </header>
        ');
        $this->PrintMessage($succ);
    }
    function EditProgram($obj)
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
                <title>Edit Program</title>    
            </head>
            
            <body>
                <style> body{background-color: #329443;}</style>
                <div class="container">
                    <div class="admin-object-form-container centered">
                        <form method="post">
                            <h3 class="title">Edit Program</h3>
                            <input type="text" class="box" name="name" 
                                value="' . $obj->getProgramName() . '" placeholder="Program Name" required>
                            <textarea class="box" name="address" style="resize: none"
                                placeholder="Program Description" required>' . $obj->getProgramDescription() . '</textarea>
                            <input type="submit" value="Update" name="update_Program" class="btn">
                            <a href="ProgramController.php" class="btn">Cancel</a>
                        </form>
                    </div>
                </div>
            </body>
            
            </html>
        ');
    }
    function ShowProgramToUser($program, $stmt)
    {
        echo ('
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
                    <h1>Food Bank</h1>
                    <nav>
                        <ul>
                            <a href="../Controller/HomeController.php"><li>Home</li></a>
                            <a href="../Controller/DonorController.php?cmd=myacc">
                                <li>My Account</li>
                            </a>
                            <a href="../Controller/CartController.php" class="cart">
                                <li><i class="fa-solid fa-cart-shopping"></i> Cart</li>
                            </a>
                        </ul>
                    </nav>
                </header>

                <div class="container">
                    <div class="overlay-container">
                        <div class="admin-object-form-container">
                            <form action="CartController.php?cmd=addToCart&id=' . $program->getId() . '" method="post">
                                <h1>' . $program->getProgramName() . '</h1>
                                <h3>' . $program->getProgramDescription() . '</h3>
                                <label for="item"> Choose item: </label>
                                <select id="item" name = "item">
        ');
        foreach ($stmt as $row) {
            $ItemModel = new ItemModel();
            $ItemModel->getById($row['id']);
            echo ('<option value="' . $ItemModel->getId() . '">' . $ItemModel->getItemName() . '</option>');
        }
        echo ('
                                </select> 
                                <label>Amount: </label>
                                <input type="number" id="quantity" min="1" max="' . $ItemModel->getAmount() .'" name="quantity" value=1 required> 
                                <input type="hidden" name="program_name" value="' . $program->getProgramName() . '">
                                <input type="hidden" name="program_id" value="' . md5($program->getId()) . '">
                                <input type="submit" class="btn" value="Add to Cart">
                                <a class="btn" href="../Controller/HomeController.php">Cancel</a>
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
    function ShowNoProgram()
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
                            <a href="HomeController.php"><li>Return</li></a>
                        </ul>
                    </nav>
                </header>

                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <p style="color: red; text-align: center; font-size:large; font-weight: bold;">
                        Program Does not Exist !
                    </p>
                </div>
        ');
    }
    function deleteRow()
    {
        echo ('
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <title>Delete Program</title>
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
                                <form action="../Controller/ProgramController.php?cmd=delete" method="post">
                                    <div class="alert alert-danger fade in">
                                        <input type="hidden" name="id" value="' . trim($_GET["id"]) . '"/>
                                        <p>Are you sure you want to delete this record?</p><br>
                                        <p>
                                            <input type="submit" value="Yes" class="btn btn-danger">
                                            <a href="../Controller/ProgramController.php" 
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
