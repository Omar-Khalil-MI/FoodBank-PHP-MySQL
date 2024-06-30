<?php
require_once "../Model/DonationDetailsModel.php";
require_once "../Model/DonationModel.php";
require_once "../View/DonationDetailsView.php";

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
        session_start();
        $donationkey = $_SESSION['donationkey'];
        $donationDetailsView = new DonationDetailsView();
        $donation = new DonationModel();
        $donation->getById($donationkey);
        $donationDetailsView->ShowReciept($donation, DonationDetailsModel::view_all_id($donationkey));
    }
}

$controller = new DonationDetailsController();

if (!isset($_GET['cmd'])) {
    $donationkey = $_GET['id'];
    $controller->viewController($donationkey);
} else {
    $command = $_GET['cmd'];
    if ($command == "receipt")
        $controller->receiptController();
}
