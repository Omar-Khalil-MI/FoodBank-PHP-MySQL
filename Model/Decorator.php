<?php
require_once "DP_IDonation.php";

abstract class Decorator implements DP_IDonation
{
    abstract function get_TotalCost();
}
