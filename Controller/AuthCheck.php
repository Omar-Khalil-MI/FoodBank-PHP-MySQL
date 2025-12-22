<?php

/**
 * AuthCheck class for verifying donor authentication
 * Redirects to Home with error message if not authenticated
 */
class AuthCheck
{
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
}
