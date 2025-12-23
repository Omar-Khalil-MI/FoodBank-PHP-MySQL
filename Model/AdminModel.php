<?php
require_once "pdo.php";

class AdminModel
{
    const table = "admin";
    private $username;
    private $email;

    private $password;
    private $role;
    private $id;

    public function __construct($username = "",$email ="", $password = "", $role = "admin", $id = 0)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->id = $id;
    }

    /**
     * Admin login function
     * Returns 1 on successful login, 0 on failure
     */
    static function login($username, $password)
    {
        try {
            $stmt = Singleton::getpdo()->prepare('SELECT * FROM admin WHERE BINARY username = :username;');
            $stmt->execute(['username' => $username]);

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($admin) {
                $pass = ($admin['password']);
                if ($pass === $password) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_role'] = $admin['role'];
                    return 1;
                } else
                    $_SESSION['admin_error'] = 'Invalid password!';
            } else
                $_SESSION['admin_error'] = 'Admin user not found!';
        } catch (PDOException $e) {
            $_SESSION['admin_error'] = 'Database error: ' . $e->getMessage();
        }
        return 0; // Login failed
    }
   public static function findByEmail($email)
{
    $stmt = Singleton::getpdo()->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(); // Returns the admin record as associative array, or false if not found
}

    public static function saveResetToken($email, $token, $expiry) {
    $pdo = Singleton::getpdo();

    // 1. Check if email exists
    $stmtCheck = $pdo->prepare("SELECT id FROM admin WHERE email = ?");
    $stmtCheck->execute([$email]);
    $admin = $stmtCheck->fetch();

    if (!$admin) {
        // Email does not exist
        return false;
    }

    // 2. Save the token
    $stmtUpdate = $pdo->prepare("UPDATE admin SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
    return $stmtUpdate->execute([$token, $expiry, $email]);
}


public static function findByResetToken($token) {
    $stmt = Singleton::getpdo()->prepare(
        "SELECT * FROM admin WHERE reset_token = ? AND reset_token_expiry > UTC_TIMESTAMP()"
    );
    $stmt->execute([$token]);
    return $stmt->fetch();
}

public static function updatePassword($id, $password) {
    $stmt = Singleton::getpdo()->prepare("UPDATE admin SET password = ? WHERE id = ?");
    return $stmt->execute([$password, $id]);
}

public static function clearResetToken($id) {
    $stmt = Singleton::getpdo()->prepare("UPDATE admin SET reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
    return $stmt->execute([$id]);
}

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     */
    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
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
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
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
