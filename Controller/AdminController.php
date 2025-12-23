<?php
require_once "../View/AdminLoginView.php";
require_once "../Model/AdminModel.php";
require_once "../View/ForgotPasswordView.php";
require_once "../View/ResetPasswordView.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // make sure PHPMailer is installed via Composer


class AdminController
{
    public $adminLoginView;

    function __construct()
    {
        $this->adminLoginView = new AdminLoginView();
    }

    function login()
    {
        $error = ((isset($_SESSION['admin_error'])) ? $_SESSION['admin_error'] : "&nbsp");
        $this->adminLoginView->ShowAdminLogin($error);
        unset($_SESSION['admin_error']);
    }

    function showIndex()
    {
        $error = ((isset($_SESSION['admin_error'])) ? $_SESSION['admin_error'] : "&nbsp");
        $this->adminLoginView->ShowAdminIndex(isset($_SESSION['admin_id']), $error);
        unset($_SESSION['admin_error']);
    }

    function adminLogin()
    {
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        $logged = AdminModel::login($username, $password);
        if ($logged)
            header("Location: AdminController.php");
        else
            header("Location: AdminController.php?cmd=login");
        exit();
    }

    function logout()
    {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
    function forgotPassword()
{
    $view = new ForgotPasswordView();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        // Check if admin exists
        $admin = AdminModel::findByEmail($email);

        if ($admin) {
            // Generate token
            $token  = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Save token
            AdminModel::saveResetToken($email, $token, $expiry);

            // Reset link
            $link = "http://localhost/FoodBank-PHP-MySQL/Controller/AdminController.php?cmd=reset&token=$token";

            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'alaay1147@gmail.com';
                $mail->Password   = 'lteu aewp jdms pzuu';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('alaay1147@gmail.com', 'FoodBank Admin');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Admin Password Reset Request';
                $mail->Body    = "Hello,<br><br>
                                  Click the link below to reset your password:<br>
                                  <a href='$link'>$link</a><br><br>
                                  If you didn't request this, ignore this email.";

                $mail->send();

                // Redirect to login with message
                $_SESSION['admin_error'] = "A reset link has been sent. Please check your inbox.";
                header("Location: AdminController.php?cmd=login");
                exit();

            } catch (Exception $e) {
                $view->showForm("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        } else {
            // Same behavior as HomeController
            $_SESSION['admin_error'] = "Email not found.";
            header("Location: AdminController.php?cmd=login");
            exit();
        }
    } else {
        // Show forgot form
        $view->showForm("",true);
    }
}

   function resetPassword()
{
    $token = $_GET['token'] ?? null;
    if (!$token) die("Invalid token");

    $admin = AdminModel::findByResetToken($token);
    if (!$admin) die("Token expired or invalid");

    $view = new ResetPasswordView();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newPassword = sha1($_POST['password']);

        AdminModel::updatePassword($admin['id'], $newPassword);
        AdminModel::clearResetToken($admin['id']);

        $_SESSION['admin_error'] = "Password reset successful. Please login.";
        header("Location: AdminController.php?cmd=login");
        exit();
    } else {
       
        $view->showForm($token, "",true);
    }
}

}

if (!isset($_SESSION))
    session_start();
$controller = new AdminController();

if (!isset($_GET['cmd'])) {
    $controller->showIndex();
} 
else {
    $command = $_GET['cmd'];
    if ($command == 'login') {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
            $controller->adminLogin();
        else $controller->login();
    } else if ($command == 'logout') {
        $controller->logout();
    }
     else if ($command == 'forgot') {
    $controller->forgotPassword();
}
else if ($command == 'reset') {
    $controller->resetPassword();
}
}
