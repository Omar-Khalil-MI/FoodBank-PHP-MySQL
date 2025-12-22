<?php

/**
 * AuthCheck class for verifying donor authentication and admin role-based access control
 * Redirects to Home with error message if not authenticated
 */
class AuthCheck
{
    /**
     * Role to Controller mapping
     * Maps admin roles to the controllers they can access
     */
    private static $rolePermissions = [
        'admin' => ['ProgramController', 'ItemController', 'SupplierController', 
                    'DistributorController', 'DonationController', 'DonationDetailsController'],
        'program' => ['ProgramController'],
        'warehouse' => ['ItemController'],
        'procurement' => ['SupplierController', 'DistributorController']
    ];

    /**
     * Check if donor is authenticated
     * If not, redirect to Home with error message
     */
    public static function requireDonorLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You must be logged in to access this page.";
            header("Location: ../Controller/HomeController.php");
            exit();
        }
    }
    
    /**
     * Check if admin is authenticated
     * If not, redirect to Admin Login with error message
     */
    public static function requireAdminLogin()
    {
        if (!isset($_SESSION['admin_id'])) {
            $_SESSION['admin_error'] = "You must be logged in as an admin to access this page.";
            header("Location: ../Controller/AdminController.php?cmd=login");
            exit();
        }
    }

    /**
     * Check if admin's role has access to the requested controller
     * If not, redirect to index page with error message
     */
    public static function requireAdminRole($controllerName = null)
    {
        // First check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            $_SESSION['admin_error'] = "You must be logged in as an admin to access this page.";
            header("Location: ../Controller/AdminController.php?cmd=login");
            exit();
        }

        // If no controller specified, try to get it from the current file
        if ($controllerName === null) {
            $controllerName = self::getCurrentControllerName();
        }

        // Check if admin has a role
        if (!isset($_SESSION['admin_role'])) {
            $_SESSION['admin_error'] = "Admin role is not defined.";
            header("Location: ../index.php");
            exit();
        }

        $role = $_SESSION['admin_role'];

        // Check if role exists in permissions
        if (!array_key_exists($role, self::$rolePermissions)) {
            $_SESSION['admin_error'] = "Invalid admin role: " . htmlspecialchars($role);
            header("Location: ../index.php");
            exit();
        }

        // Check if current controller is in the allowed controllers for this role
        if (!in_array($controllerName, self::$rolePermissions[$role])) {
            $_SESSION['admin_error'] = "Access denied. Your role '" . htmlspecialchars($role) . 
                                       "' does not have permission to access " . htmlspecialchars($controllerName) . ".";
            header("Location: AdminController.php");
            exit();
        }
    }

    /**
     * Get the current controller name from the script being executed
     */
    private static function getCurrentControllerName()
    {
        $scriptName = basename($_SERVER['SCRIPT_FILENAME']);
        // Remove .php extension and return
        return str_replace('.php', '', $scriptName);
    }

    /**
     * Check if admin role has a specific permission
     * Can be used for fine-grained permission checks
     */
    public static function hasRolePermission($permission)
    {
        if (!isset($_SESSION['admin_role'])) {
            return false;
        }

        $role = $_SESSION['admin_role'];
        if (!array_key_exists($role, self::$rolePermissions)) {
            return false;
        }

        return in_array($permission, self::$rolePermissions[$role]);
    }

    /**
     * Add a new role or update existing role permissions
     * Useful for dynamic permission management
     */
    public static function addRolePermission($role, $permissions)
    {
        if (!is_array($permissions)) {
            $permissions = [$permissions];
        }
        
        if (!array_key_exists($role, self::$rolePermissions)) {
            self::$rolePermissions[$role] = $permissions;
        } else {
            self::$rolePermissions[$role] = array_merge(self::$rolePermissions[$role], $permissions);
            self::$rolePermissions[$role] = array_unique(self::$rolePermissions[$role]);
        }
    }

    /**
     * Get all permissions for a role
     */
    public static function getRolePermissions($role)
    {
        return array_key_exists($role, self::$rolePermissions) ? self::$rolePermissions[$role] : [];
    }
}
