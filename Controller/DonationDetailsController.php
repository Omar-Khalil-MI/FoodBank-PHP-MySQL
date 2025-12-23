<?php
require_once "../Model/DonationDetailsModel.php";
require_once "../Model/DonationModel.php";
require_once "../View/DonationDetailsView.php";
require_once "AuthCheck.php";

class DonationDetailsController
{
    function viewController($donationkey)
    {
        $donationDetailsView = new DonationDetailsView();
        $stmt = DonationDetailsModel::view_all_id($donationkey);
        $donationDetailsView->ShowDonationDetailsTable($stmt);
    }
    function receiptController()
    {
        if (!isset($_SESSION))
            session_start();
        $donationkey = $_SESSION['donationkey'];
        $donationDetailsView = new DonationDetailsView();
        $donation = new DonationModel();
        $donation->getById($donationkey);
        $donationDetailsView->ShowReciept($donation, DonationDetailsModel::view_all_id($donationkey));
    }
}

$controller = new DonationDetailsController();

if (!isset($_SESSION))
    session_start();

if (!isset($_GET['cmd'])) {
    AuthCheck::requireAdminLogin();
    AuthCheck::requireAdminRole('DonationDetailsController');
    if (!isset($_GET['id']))
        $donationkey = -1;
    else
        $donationkey = $_GET['id'];
    $controller->viewController($donationkey);
} else {
    AuthCheck::requireDonorLogin();
    $command = $_GET['cmd'];
    if ($command == "receipt")
        $controller->receiptController();
}
