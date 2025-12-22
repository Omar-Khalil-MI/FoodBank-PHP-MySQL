<?php
require_once "AuthCheck.php";
require_once "../Model/DonationModel.php";
require_once "../View/DonationView.php";

class DonationController
{
    function view_allController()
    {
        $donationView = new DonationsView();
        $stmt = DonationModel::view_all();
        $donationView->ShowDonationsTable($stmt);
    }
}

$dController = new DonationController();

if (!isset($_SESSION))
    session_start();
AuthCheck::requireAdminLogin();
AuthCheck::requireAdminRole('DonationController');

if (!isset($_GET['cmd']))
    $dController->view_allController();
