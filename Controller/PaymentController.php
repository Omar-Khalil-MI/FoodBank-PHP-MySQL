<?php
require_once "AuthCheck.php";
require_once "../Model/FawryPay.php";
require_once "../Model/VisaPay.php";
require_once "../View/PaymentView.php";
require_once "../Model/DonationModel.php";
require_once "../Model/DecOther.php";
require_once "../Model/DecTrans.php";
require_once "../Model/PaymentModel.php";
require_once "../Model/PaymentFactory.php";

class PaymentController
{
    public $payview;

    function __construct()
    {
        $this->payview = new PaymentView();
    }
    public function PaymentOptions($cost)
    {
        $costDonation = new DonationModel();
        $costDonation->setTotalCost($cost);

        if (isset($_POST['tr_add']))
            $costDonation = new DecTrans($costDonation);
        if (isset($_POST['other_add']))
            $costDonation = new DecOther($costDonation);

        $cost = $costDonation->get_TotalCost();
        $this->payview->ShowPaymentOptions($cost);
    }
    public function processPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['paymentmethod'], $_POST['cost'])) {

            try {
                $payment = PaymentFactory::create($_POST['paymentmethod']);
                $result = $payment->pay((float) $_POST['cost']);

                if ($result) {
                    PaymentModel::addDonation($_POST['paymentmethod']);
                    header("Location: DonationDetailsController.php?cmd=receipt");
                    exit();
                }

                $this->payview->PaymentError(0);

            } catch (Exception $e) {
                $this->payview->PaymentError(1);
            }
        }
    }

}

if(!isset($_SESSION)) 
    session_start();

AuthCheck::requireDonorLogin();

$controller = new PaymentController();

$cmd = $_GET['cmd'];
$cost = $_POST['cost'];

if ($cmd == 'paymentoptions')
    $controller->PaymentOptions($cost);
else if ($cmd == 'result')
    $controller->processPayment();
