<?php
require_once "ItemModel.php";
require_once "DonationModel.php";
require_once "DonationDetailsModel.php";

class PaymentModel
{
    static function addDonationDetails()
    {
        $donationkey = $_SESSION['donationkey'];
        foreach ($_SESSION['cart'] as $item => $quantity) {
            $itemModel = new ItemModel();
            $itemModel->getById($item);
            $x = new DonationDetailsModel($donationkey, $item, $quantity, $itemModel->getCost());
            $x->add();
        }
        //Empty the cart after the donation
        unset($_SESSION['cart']);
    }
    static function addDonation($paymentMethod)
    {
        session_start();
        $cost = $_POST['cost'];
        $donationModel = new DonationModel($_SESSION['user_id'], $cost, date('y-m-d'), $paymentMethod);
        $donationModel->add();
        //Store donation id for the donation details and avoid sending it in the url
        $_SESSION['donationkey'] = DonationModel::getLastInsertedId();
        PaymentModel::addDonationDetails();
    }
}
