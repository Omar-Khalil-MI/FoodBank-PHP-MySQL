<?php
interface ImodifiableModel
{
    function add();
    static function remove($id);
    function edit();
    function read();
    static function view_all();
}
