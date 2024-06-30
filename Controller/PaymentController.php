<?php
require_once "../Model/FawryPay.php";
require_once "../Model/VisaPay.php";
require_once "../View/PaymentView.php";
require_once "../Model/DonationModel.php";
require_once "../Model/DecOther.php";
require_once "../Model/DecTrans.php";
require_once "../Model/PaymentModel.php";

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
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paymentmethod']) && isset($_POST['cost'])) {
            $paymentMethod = $_POST['paymentmethod'];
            $amount = $_POST['cost'];

            switch ($paymentMethod) {
                case 'Fawry':
                    $FawryPayment = new FawryPay();
                    $result = $FawryPayment->pay($amount);
                    break;
                case 'Visa':
                    $VisaPayment = new VisaPay();
                    $result = $VisaPayment->pay($amount);
                    break;
            }
            if ($result) {
                PaymentModel::addDonation($paymentMethod);
                header("Location: DonationDetailsController.php?cmd=receipt");
                exit();
            } else $this->payview->PaymentError(0);
        }
    }
}

$controller = new PaymentController();

$cmd = $_GET['cmd'];
$cost = $_POST['cost'];

if ($cmd == 'paymentoptions')
    $controller->PaymentOptions($cost);
else if ($cmd == 'result')
    $controller->processPayment();
