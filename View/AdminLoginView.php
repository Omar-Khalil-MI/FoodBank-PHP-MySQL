<?php
require_once "ViewAbst.php";

class AdminLoginView extends ViewAbst
{
    function ShowAdminLogin($error)
    {
        echo ('
            <!DOCTYPE html>
            <html>
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/login.css">
                <link rel="icon" href="../Resources/logo.ico">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
                    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
                    crossorigin="anonymous" referrerpolicy="no-referrer" />
                <title>Admin Login</title>
            </head>
            
            <body>
                <section class="container">
                    <header>
                        <h1>Admin Login</h1>
                    </header>
                    
                    <form action="../Controller/AdminController.php?cmd=login" method="POST" class="form">
        ');
        if ($error != "&nbsp")
            echo ('<p id="error" style="color: red;">' . $error . '</p>');
        echo ('
                        <div class = "input-box">
                            <label>Username:</label>
                            <input type="text" pattern="^[^\s]+$" id="username" name="username" 
                                placeholder="Enter admin username" required>
                        </div>
                        

                        <div class = "input-box">
                            <label>Password:</label>
                            <input type="password" pattern="^[^\s]+$" id="password" name="password" 
                                placeholder="Enter admin password" required>
                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                        </div>
                        
                        <button>Login</button>
                        <a class="cancel-btn" href="../Controller/AdminController.php">Cancel</a>
                        <a href="../Controller/AdminController.php?cmd=forgot">Forgot password?</a>
                    </form>
                </section>
                
                <script>
                    const passwordField = document.getElementById("password");
                    const togglePassword = document.querySelector(".password-toggle-icon i");

                    togglePassword.addEventListener("click", function () {
                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        togglePassword.classList.remove("fa-eye");
                        togglePassword.classList.add("fa-eye-slash");
                    } 
                    else {
                        passwordField.type = "password";
                        togglePassword.classList.remove("fa-eye-slash");
                        togglePassword.classList.add("fa-eye");
                    }
                    });
                </script>
            </body>
            
            </html>
        ');
    }

    function ShowAdminIndex($logged, $error)
    {
        echo ('
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/dashboard.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
                <link rel="stylesheet" href="../CSS/popup.css">
                <link rel="icon" href="../Resources/logo.ico">
                <title>Roles Dashboard</title>
            </head>

            <body>
                <header>
                    <h1>Food Bank</h1>
                    <nav>
                        <ul>
        ');
        if ($logged)
            echo ('
                            <a href="../Controller/AdminController.php?cmd=logout"><li>Logout</li></a>
            ');
        else echo ('
                            <a href="../Controller/AdminController.php?cmd=login"><li>Login</li></a>
                            <a href="../index.php"><li>Dashboard</li></a>
            ');
        echo ('
                        </ul>
                    </nav>
                </header>
                <div class="container">
            ');
        if ($error != "&nbsp")
            echo ('<p id="error" style="color: red; text-align: center; font-size: 18px; padding: 10px; margin: 10px 0; border: 1px solid red; border-radius: 5px;">' . $error . '</p>');
        echo ('
                <div class="row">
                    <div class="role">
                        <img src="../Resources/program.jpg" alt="Program Coordinator">
                        <a href="../Controller/ProgramController.php">Program Coordinator</a>
                    </div>
                    <div class="role">
                        <img src="../Resources/warehouse.jpg" alt="Warehouse Coordinator">
                        <a href="../Controller/ItemController.php">Warehouse Coordinator</a>
                    </div>
                </div>

                <div class="row">
                    <div class="role">
                        <img src="../Resources/proc.jpg" alt="Procurement Coordinator">
                        <a href="javascript:void(0)" onclick="togglePopup()">Procurement Coordinator</a>
                    </div>    
                    <div class="role">
                        <img src="../Resources/ceo.png" alt="Executive Director">
                        <a href="../Controller/DonationController.php">Executive Director</a>
                    </div>
                </div>

                <div id="popupOverlay" class="overlay-container">
                    <div class="popup-box">
                        <h1 class="title">Choose Database</h1>
                        <form method="get" class="form-container">
                            <a href="../Controller/SupplierController.php" class="btn">Supplier</a>
                            <a href="../Controller/DistributorController.php" class="btn">Distributor</a>
                            <button class="btn-close-popup" onclick="togglePopup()">Close</button>
                        </form>
                    </div>
                </div>

                <footer>
                    <p>© 2024 Food Bank</p>
                </footer>

                <script>
                    function togglePopup() {
                        const overlay = document.getElementById("popupOverlay");
                        overlay.classList.toggle("show");
                    }
                </script>
            </body>

            </html>
        ');
    }
}
