<?php
require_once "Ipay.php";

class FawryPay implements Ipay
{
    function pay($amount)
    {
        return 1;
    }
}
