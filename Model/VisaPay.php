<?php
require_once "Ipay.php";

class VisaPay implements Ipay
{
    function pay($amount)
    {
        return 1;
    }
}
