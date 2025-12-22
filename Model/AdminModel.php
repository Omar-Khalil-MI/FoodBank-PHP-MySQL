<?php
require_once "pdo.php";

class AdminModel
{
    const table = "admin";
    private $username;
    private $password;
    private $role;
    private $id;

    public function __construct($username = "", $password = "", $role = "admin", $id = 0)
    {
        $this->username = $username;
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
