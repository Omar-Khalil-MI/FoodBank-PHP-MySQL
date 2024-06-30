<?php
require_once "Decorator.php";

class DecOther extends Decorator
{
    private $ref;

    function __construct($ref)
    {
        $this->ref = $ref;
    }
    function get_TotalCost()
    {
        return 10 + $this->ref->get_TotalCost();
    }
}
