<?php
require_once "Ipay.php";
require_once "FawryPay.php";
require_once "VisaPay.php";
class PaymentFactory {
    public static function create(string $method): IPay {
        return match ($method) {
            'Fawry' => new FawryPay(),
            'Visa'  => new VisaPay(),
            default => throw new Exception("Unsupported payment method"),
        };
    }
}
