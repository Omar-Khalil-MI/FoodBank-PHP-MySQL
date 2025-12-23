<?php
class Singleton
{
    private static $pdo; //private instance
    public static function getpdo()// public get methid
    {
        if (self::$pdo == null) //Lazy singleton
            self::$pdo = new PDO('mysql:host=localhost;port=3306;dbname=foodbank', 'root', '');

        return self::$pdo;
    }
}
