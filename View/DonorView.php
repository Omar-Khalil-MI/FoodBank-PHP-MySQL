<?php
require_once "ViewAbst.php";
require_once "../Model/ProgramModel.php";
require_once "../Model/ItemModel.php";
require_once "../Model/GenderEnum.php";

class DonorView extends ViewAbst
{
    function signup($error = null)
    {
        echo ('
            <!DOCTYPE html>
            <html>
            
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/signup.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
                    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
                    crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link rel="icon" href="../Resources/logo.ico">
                <title>Sign Up</title>
            </head>
            
            <body>
                <section class="container">
                    <header>
                        <h1>Registration Form</h1>
                    </header>
                    <form action="../Controller/DonorController.php?cmd=signup" method="post" class="form">
                        <p id="error" style="color: red;">' . $error . '</p>
                        <div class = "input-box">
                            <label>Username:</label>
                            <input type="text" pattern="^[^\s]+$" id="username" name="username" 
                                placeholder="Enter your username" required>
                        </div>
                        <div class = "input-box">
                            <label>Password:</label>
                            <input minlength="5" pattern="^[^\s]+$" type="password" id="password" name="password" 
                                placeholder="Enter your password" required>
                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                        </div>
                        <div class = "input-box">
                            <label>Email Address:</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                        </div>   
                        <div class="column">
                            <div class = "input-box">
                                <label>Phone Number:</label>
                                <input type="text" id="phone" name="phone" placeholder="Enter your phone number" 
                                    pattern="\d*" minlength="11" maxlength="11" required>
                            </div> 
                            <div class = "input-box">
                                <label>Birth Date:</label>
                                <input type="date" id="birthdate" name="birthdate" required>
                            </div> 
                        </div>
                        <div class="gender-box">
                            <h3>Gender</h3>
                                <div class="gender-option">
                                    <div class="gender">
                                        <input type="radio" id="male" name="gender" 
                                            value="' . GenderEnum::Male->value . '" required/>
                                        <label for="male">Male</label>
                                    </div> 
                                    <div class="gender">
                                        <input type="radio" id="female" name="gender" 
                                            value="' . GenderEnum::Female->value . '" required/>
                                        <label for="female">Female</label>
                                    </div> 
                                </div>    
                        </div>
                        <button>Submit</button>
                        <p class="login-link">Already have an account?
                            <a class="btn" href="../Controller/HomeController.php?cmd=login">Login</a>
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
    function ShowDonorsTable($rows)
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
                <title>Donors</title>
            </head>
            
            <body>
                <header>
                    <h1>Donor Database</h1>
                    <nav>
                        <ul>
                            <a href="../index.php"><li>Dashboard</li></a>
                            <a href="../Controller/DonationController.php"><li>Back</li></a>
                        </ul>
                    </nav>
                </header>
                <div class="container">
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead><tr>
                                <th>Donor ID</th>
                                <th>User Name</th>
                                <th>Birthdate</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                            </tr></thead>
        ');
        foreach ($rows as $row)
            echo ('
                            <tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['username'] . '</td>
                                <td>' . $row['birthdate'] . '</td>
                                <td>' . $row['email'] . '</td>
                                <td>' . $row['phone_number'] . '</td>
                                <td>' . (($row['gender'] == GenderEnum::Male->value) ? "Male" : "Female") . '</td>
                            </tr>
            ');
    }
    function ShowDonorDetails($donor, $error)
    {
        echo ('
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../CSS/myacc.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
                <link rel="icon" href="../Resources/logo.ico">
                <title>Food Bank</title>
            </head>
            
            <body>
                <section class="container">
                    <header>
                        <h1>My Account</h1>
                    </header>    
                    <form action="../Controller/DonorController.php?cmd=myacc" method="post" class="form">
        ');
        if ($error == "Success")
            echo ('<p id="error" style="color: green;">Account Updated!</p>');
        else echo ('<p id="error" style="color: red;">' . $error . '</p>');
        echo ('
                    <div class = "input-box">
                        <label>Username: </label>
                        <input type="text" id="username" name="username" value="' . $donor->getUserName() . '" readonly>
                    </div>
                    <div class = "input-box">
                        <label>Birthdate: </label>
                        <input type="date" id="birthdate" name="birthdate" value="' . $donor->getBirthdate() . '">
                    </div>
                    <div class = "input-box">
                        <label>Email: </label>
                        <input type="email" id="email" name="email" value="' . $donor->getEmail() . '">
                    </div>
                    <div class = "input-box">
                        <label>Phone Number: </label>
                        <input type="text" pattern="\d*" minlength="11" maxlength="11" id="phone" name="phone" 
                            value="' . $donor->getPhoneNumber() . '">
                    </div>
                    <div class="gender-box">
                        <h3>Gender</h3>
                        <div class="gender-option">
                            <div class="gender">
                                <input type="radio" id="male" name="gender" value="' . GenderEnum::Male->value . '" required
            ');
        if ($donor->getGender() == GenderEnum::Male->value)
            echo (' checked');
        echo ('/>
                                <label for="male">Male</label>
                            </div>   
                            <div class="gender">
                                <input type="radio" id="female" name="gender" value="' . GenderEnum::Female->value . '" required
            ');
        if ($donor->getGender() == GenderEnum::Female->value)
            echo (' checked');
        echo ('/>
                                <label for="female">Female</label>
                            </div>   
                        </div>    
                    </div>
                    <button>Update</button>
                    <a class="cancel-btn" href="../Controller/HomeController.php">Cancel</a>
                    </form>
                </section>
            </body>

            </html>
        ');
    }
    function ShowMyDD($rows)
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
                <title>Donation CRUD</title>
            </head>
            
            <body>
                <header>
                    <h1>Donation Database</h1>
                    <nav>
                        <ul>
                            <a href="../Controller/HomeController.php"><li>Home</li></a>
                            <a href="../Controller/DonorController.php?cmd=myacc">
                                <li>My Account</li>
                            </a>
                            <a href="../Controller/CartController.php" class="cart">
                                <li><i class="fa-solid fa-cart-shopping"></i> Cart</li>
                            </a>
                            <a href="../Controller/HomeController.php?cmd=logout"><li>Logout</li></a>
                        </ul>
                    </nav>
                </header>
                <div class="container">
                    <div class="object-display">
                        <table class="object-display-table">
                            <thead><tr>
                                <th>Donation ID</th>
                                <th>Item Name</th>
                                <th>Program Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr></thead>
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
}
