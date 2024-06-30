<?php
require_once "pdo.php";
require_once "ModifiableAbstModel.php";
require_once "DP_IDonation.php";

class DonationModel extends ModifiableAbstModel implements DP_IDonation
{
    const table = "donations";
    private $donor_id;
    private $total_cost;
    private $donation_date;
    private $method;

    public function __construct($donor_id = "", $total_cost = 0, $donation_date = "", $method = "")
    {
        $this->donor_id = $donor_id;
        $this->total_cost = $total_cost;
        $this->donation_date = $donation_date;
        $this->method = $method;
    }
    public function add()
    {
        $sql = "INSERT INTO " . self::table . " (donor_id, total_cost, donation_date, method)
                VALUES (:donor, :cost, :date, :method)";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(array(
            'donor' => $this->donor_id,
            'cost' => $this->total_cost,
            'date' => $this->donation_date,
            'method' => $this->method
        ));
    }
    public function read()
    {
        $sql = "SELECT * FROM " . self::table . " WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['id' => $this->id]);
        if ($stmt->rowCount() == 0)
            return 0;
        else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->donor_id = $row['donor_id'];
            $this->total_cost = $row['total_cost'];
            $this->donation_date = $row['donation_date'];
            $this->method = $row['method'];
            return 1;
        }
    }
    public function edit()
    {
        $sql = "UPDATE " . self::table . " SET donor_id = :donor, total_cost = :cost, donation_date = :date, 
            method = :method WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute([
            'id' => $this->id,
            'donor' => $this->donor_id,
            'cost' => $this->total_cost,
            'date' => $this->donation_date,
            'method' => $this->method
        ]);
    }
    public static function remove($id)
    {
        $sql = "DELETE FROM " . self::table . " WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    public static function view_all()
    {
        $stmt = Singleton::getpdo()->query("SELECT * FROM " . self::table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function view_all_donor($donor_id)
    {
        $sql = "SELECT * FROM " . self::table . " WHERE donor_id = :donor_id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['donor_id' => $donor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDonorId()
    {
        return $this->donor_id;
    }
    public function setDonorId($donor_id): self
    {
        $this->donor_id = $donor_id;

        return $this;
    }
    public function get_TotalCost()
    {
        return $this->total_cost;
    }
    public function getDonationDate()
    {
        return $this->donation_date;
    }
    public function setTotalCost($cost)
    {
        $this->total_cost = $cost;
    }
    public function setDate($date)
    {
        $this->donation_date = $date;
    }
    public static function getLastInsertedId()
    {
        return Singleton::getpdo()->lastInsertId();
    }
    public function getMethod()
    {
        return $this->method;
    }
    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }
}
