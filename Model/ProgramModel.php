<?php
require_once "pdo.php";
require_once "ModifiableAbstModel.php";

class ProgramModel extends ModifiableAbstModel
{
    const table = "program";
    private $program_name;
    private $description;

    public function __construct($program_name = "", $description = "")
    {
        $this->program_name = $program_name;
        $this->description = $description;
    }
    public function add()
    {
        $sql = "INSERT INTO " . self::table . " (program_name, description, hash) 
        VALUES (:program, :description, :hash)";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(array(
            ':program' => $this->program_name,
            ':description' => $this->description,
            ':hash' => md5($this->program_name)
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
            $this->program_name = $row['program_name'];
            $this->description = $row['description'];
            return 1;
        }
    }
    public function edit()
    {
        $sql = "UPDATE " . self::table . " SET 
        program_name = :program, description = :description WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute([
            'id' => $this->id,
            'program' => $this->program_name,
            'description' => $this->description
        ]);
        return $stmt;
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
    public function getProgramName()
    {
        return $this->program_name;
    }
    public function getProgramDescription()
    {
        return $this->description;
    }
    public function getByHash($hash)
    {
        $sql = "SELECT id FROM " . self::table . " WHERE hash = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['id' => $hash]);
        if ($stmt->rowCount() == 0)
            return 0;
        else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->read();
            return 1;
        }
    }
    public static function get_ProgramName($id)
    {
        $sql = "SELECT program_name FROM " . self::table . " WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['program_name'];
    }
    public static function get_IDs()
    {
        $sql = "SELECT id FROM " . self::table;
        $stmt = Singleton::getpdo()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
