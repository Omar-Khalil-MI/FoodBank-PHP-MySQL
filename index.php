<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="CSS/popup.css">
    <link rel="icon" href="Resources/logo.ico">
    <title>Roles Dashboard</title>
</head>

<body>
    <header>
        <h1>Roles Dashboard</h1>
    </header>

    <div class="row">
        <div class="role">
            <img src="Resources/program.jpg" alt="Program Coordinator">
            <a href="Controller/ProgramController.php">Program Coordinator</a>
        </div>
        <div class="role">
            <img src="Resources/warehouse.jpg" alt="Warehouse Coordinator">
            <a href="Controller/ItemController.php">Warehouse Coordinator</a>
        </div>
        <div class="role">
            <img src="Resources/proc.jpg" alt="Procurement Coordinator">
            <a href="avascript:void(0)" onclick="togglePopup() ">Procurement Coordinator</a>
        </div>
    </div>

    <div class="row">
        <div class="role">
            <img src="Resources/ceo.png" alt="Executive Director">
            <a href="Controller/DonationController.php">Executive Director</a>
        </div>
        <div class="role">
            <img src="Resources/donate.jpg" alt="Donate">
            <a href="Controller/HomeController.php">Donate</a>
        </div>
    </div>

    <div id="popupOverlay" class="overlay-container">
        <div class="popup-box">
            <h1 class="title">Choose Database</h1>
            <form method="get" class="form-container">
                <a href="Controller/SupplierController.php" class="btn">Supplier</a>
                <a href="Controller/DistributorController.php" class="btn">Distributor</a>
                <button class="btn-close-popup" onclick="togglePopup()">Close</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2024 Food Bank</p>
    </footer>

    <script>
        function togglePopup() {
            const overlay = document.getElementById('popupOverlay');
            overlay.classList.toggle('show');
        }
    </script>
</body>

</html>