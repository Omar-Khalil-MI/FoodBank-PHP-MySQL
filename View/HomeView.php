<?php
require_once "ViewAbst.php";

class HomeView extends ViewAbst
{
    function ShowHome($logged, $rows, $username = null)
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
                <title>Food Bank</title>
            </head>
            
            <body>
                <header>
                    <h1>Food Bank</h1>
                    <nav>
                        <ul>
        ');
        if ($logged)
            echo ('
                            <a href="../Controller/DonorController.php?cmd=myacc">
                                <li>My Account</li>
                            </a>
                            <a href="../Controller/DonorController.php?cmd=viewdonations">
                                <li>My Donations</li>
                            </a>
                            <a href="../Controller/CartController.php" class="cart">
                                <li><i class="fa-solid fa-cart-shopping"></i> Cart</li>
                            </a>
                            <a href="../Controller/HomeController.php?cmd=logout"><li>Logout</li></a>
            ');
        else echo ('
                            <a href="../Controller/HomeController.php?cmd=login"><li>Login</li></a>
                            <a href="../index.php"><li>Dashboard</li></a>
            ');
        echo ('
                        </ul>
                    </nav>
                </header>
                <div class="container">');
        if ($logged)
            echo ('<h1>Welcome Back ' . $username . '!</h1><br/>');
        echo ('
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead><tr>
                                <th nowrap>Program Name</th>
                                <th>Description</th>'
        );
        if ($logged)
            echo ('<th>Action</th>');
        echo ('</tr></thead>');
        foreach ($rows as $row) {
            echo ('
                            <tr>
                                <td>' . $row['program_name'] . '</td>
                                <td align="left">' . $row['description'] . '</td>
            ');
            if ($logged)
                echo ('<td><a class="btn" href="ProgramController.php?cmd=showtouser&id=' . $row['hash'] . '">Donate</a></td>');
            echo ("</tr>");
        }
    }
    function ShowLogin($error)
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
                <title>Login</title>
            </head>
            
            <body>
                <section class="container">
                    <header>
                        <h1>Login</h1>
                    </header>
                    <form action="../Controller/HomeController.php" method="POST" class="form">
        ');
        if ($error == "Success")
            echo ('<p id="error" style="color: green;">Account Created!</p>');
        else echo ('<p id="error" style="color: red;">' . $error . '</p>');
        echo ('
                        <div class = "input-box">
                            <label>Username:</label>
                            <input type="text" pattern="^[^\s]+$" id="username" name="username" 
                                placeholder="Enter your username" required>
                        </div>
                        <div class = "input-box">
                            <label>Password:</label>
                            <input type="password" pattern="^[^\s]+$" id="password" name="password" 
                                placeholder="Enter your password" required>
                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                        </div>
                        <button>Login</button>
                        <a class="cancel-btn" href="../Controller/HomeController.php">Cancel</a>
                        <p class="login-link">First Time?
                            <a class="btn" href="../Controller/DonorController.php?cmd=signup">Sign Up</a>
                        </p>
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
}
