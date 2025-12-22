<?php
require_once "pdo.php";
require_once "ModifiableAbstModel.php";

class DonationDetailsModel extends ModifiableAbstModel
{
    const table = "donation_details";
    private $donation_id;
    private $item_id;
    private $Qty;
    private $price;

    public function __construct($donation_id = 0, $item_id = 0, $Qty = 0, $price = 0)
    {
        $this->donation_id = $donation_id;
        $this->item_id = $item_id;
        $this->Qty = $Qty;
        $this->price = $price;
    }
    public function add()
    {
        $sql = "INSERT INTO " . self::table . " (donation_id, item_id, Qty, price) 
        VALUES (:donation, :item, :qty, :price)";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(array(
            ':donation' => $this->donation_id,
            ':item' => $this->item_id,
            ':qty' => $this->Qty,
            ':price' => $this->price
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
            $this->donation_id = $row['donation_id'];
            $this->item_id = $row['item_id'];
            $this->Qty = $row['Qty'];
            $this->price = $row['price'];
            return 1;
        }
    }
    public function edit()
    {
        $sql = "UPDATE " . self::table . " SET donation_id = :donation, item_id = :item,
        Qty = :qty, price = :price WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute([
            'id' => $this->id, 'donation' => $this->donation_id,
            'item' => $this->item_id, 'qty' => $this->Qty, 'price' => $this->price
        ]);
    }
    public static function remove($id)
    {
        $sql = "DELETE FROM " . self::table . " WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    public static function view_all_id($id)
    {
        $sql = "SELECT * FROM " . self::table . " WHERE donation_id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function view_all()
    {
        $stmt = Singleton::getpdo()->query("SELECT * FROM " . self::table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function view_all_donor($donor_id)
    {
        $sql = "SELECT donation_details.* FROM " . self::table . "
                INNER JOIN donations ON donations.id = donation_details.donation_id
                WHERE donations.donor_id = :donor_id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['donor_id' => $donor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function setDonationId($id)
    {
        $this->donation_id = $id;
    }
    public function setItemId($itemid)
    {
        $this->item_id = $itemid;
    }
    public function setPrice($prc)
    {
        $this->price = $prc;
    }
    public function setQuantity($quantity)
    {
        $this->Qty = $quantity;
    }
    public function getQuantity()
    {
        return $this->Qty;
    }

    /**
     * Get the value of item_id
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of donation_id
     */
    public function getDonationId()
    {
        return $this->donation_id;
    }
}
