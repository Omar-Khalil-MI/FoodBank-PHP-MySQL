<?php
require_once "pdo.php";
require_once "ModifiableAbstModel.php";

class DonorModel extends ModifiableAbstModel
{
    const table = "donor";
    private $username;
    private $birthdate;
    private $email;
    private $password;
    private $phone_number;
    private $gender;

    public function __construct(
        $username = "",
        $birthdate = "",
        $email = "",
        $password = "",
        $phone_number = "",
        $gender = 0,
        $id = 0
    ) {
        $this->username = $username;
        $this->birthdate = $birthdate;
        $this->email = $email;
        $this->password = $password;
        $this->phone_number = $phone_number;
        $this->gender = $gender;
        $this->id = $id;
    }
    public function add()
    {
        $sql = "INSERT INTO " . self::table . " (username, birthdate, email, password, phone_number, gender) 
        VALUES (:username, :birthdate, :email, :password, :phonenumber, :gender)";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(array(
            ':username' => $this->username,
            ':birthdate' => $this->birthdate,
            ':email' => $this->email,
            ':password' => $this->password,
            ':phonenumber' => $this->phone_number,
            ':gender' => $this->gender
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
            $this->username = $row['username'];
            $this->birthdate = $row['birthdate'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->phone_number = $row['phone_number'];
            $this->gender = $row['gender'];
            return 1;
        }
    }
    public function edit()
    {
        $sql = "UPDATE " . self::table . " SET birthdate = :birthdate,
        email = :email, phone_number = :phonenumber,
        gender = :gender WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute([
            'id' => $this->id,
            'birthdate' => $this->birthdate,
            'email' => $this->email,
            'phonenumber' => $this->phone_number,
            'gender' => $this->gender
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
    public function exists()
    {
        $sql = "SELECT COUNT(id) AS num_rows FROM " . self::table . " WHERE BINARY email = :email AND id != :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute([
            'id' => $this->id,
            'email' => $this->email
        ]);
        $result = $stmt->fetch();
        if ($result['num_rows'] > 0) {
            $_SESSION['error'] = 'Email already exists';
            return 1; // Email exists
        }

        $sql = "SELECT COUNT(id) AS num_rows FROM " . self::table . " WHERE BINARY username = :username AND id != :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->execute([
            'username' => $this->username,
            'id' => $this->id
        ]);
        $result = $stmt->fetch();
        if ($result['num_rows'] > 0) {
            $_SESSION['error'] = 'Username already exists';
            return 1; // Username exists
        }
        $_SESSION['error'] = 'Success';
        return 0; // User does not exist
    }
    static function login($Username, $Password)
    {
        try {
            $stmt = Singleton::getpdo()->prepare('SELECT * FROM donor WHERE BINARY username = :username;');
            $stmt->execute(['username' => $Username]);

            $donor = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($donor) {
                $pass = ($donor['password']);
                if ($pass === $Password) {
                    $_SESSION['user_id'] = $donor['id'];
                    $_SESSION['username'] = $donor['username'];
                    return 1;
                } else
                    $_SESSION['error'] = 'Invalid password!';
            } else
                $_SESSION['error'] = 'User not found!';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        }
        return 0;
    }
    public function getUserName()
    {
        return $this->username;
    }
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Set the value of gender
     */
    public function setGender($gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Set the value of phone_number
     */
    public function setPhoneNumber($phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of birthdate
     */
    public function setBirthdate($birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Set the value of username
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }
}
