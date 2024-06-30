<?php
require_once "Decorator.php";

class DecTrans extends Decorator
{
    private $ref;

    function __construct($ref)
    {
        $this->ref = $ref;
    }
    function get_TotalCost()
    {
        return 5 + $this->ref->get_TotalCost();
    }
}
