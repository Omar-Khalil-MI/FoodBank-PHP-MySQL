<?php
class Singleton
{
    private static $pdo;
    public static function getpdo()
    {
        if (self::$pdo == null)
            self::$pdo = new PDO('mysql:host=localhost;port=3306;dbname=foodbank', 'root', '');

        return self::$pdo;
    }
}
