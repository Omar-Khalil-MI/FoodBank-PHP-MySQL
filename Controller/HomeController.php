<?php
require_once "../View/HomeView.php";
require_once "../Model/ProgramModel.php";
require_once "../Model/DonorModel.php";
require_once "../View/ForgotPasswordView.php";
require_once "../View/ResetPasswordView.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // make sure PHPMailer is installed via Composer



class HomeController
{
    public $homeView;
    function __construct()
    {
        $this->homeView = new HomeView();
    }
    function login()
    {
        $error = ((isset($_SESSION['error'])) ? $_SESSION['error'] : "&nbsp");
        $this->homeView->ShowLogin($error);
        unset($_SESSION['error']);
    }
    function logout()
    {
        session_destroy();
        header("Location: ../Controller/HomeController.php");
        exit();
    }

    function signup()
    {
        header("Location: DonorController.php?cmd=add");
        exit();
    }
    function home()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = sha1($_POST['password']);
            $logged = DonorModel::login($username, $password);
            if ($logged)
                header("Location: ../Controller/HomeController.php");
            else
                header("Location: ../Controller/HomeController.php?cmd=login");
            exit();
        } else {
            $stmt = ProgramModel::view_all();
            $error = ((isset($_SESSION['error'])) ? $_SESSION['error'] : "&nbsp");
            if (isset($_SESSION['user_id']))
                $this->homeView->ShowHome(true, $stmt, $_SESSION['username'], $error);
            else
                $this->homeView->ShowHome(false, $stmt, null, $error);
            unset($_SESSION['error']);
        }
        $this->homeView->PrintFooter();
    }
    function forgotPassword() {
    $view = new ForgotPasswordView();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        // Check if donor exists
        $donor = DonorModel::findByEmail($email);

        if ($donor) {
            // Generate token and expiry
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Save token in DB
            DonorModel::saveResetToken($email, $token, $expiry);

            // Prepare reset link
            $link = "http://localhost/FoodBank-PHP-MySQL/Controller/HomeController.php?cmd=reset&token=$token";

            // Send email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'alaay1147@gmail.com'; // your Gmail
                $mail->Password   = 'lteu aewp jdms pzuu'; // your Gmail App Password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('alaay1147@gmail.com', 'FoodBank');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Hello,<br><br>
                                  Click the link below to reset your password:<br>
                                  <a href='$link'>$link</a><br><br>
                                  If you didn't request this, ignore this email.";

                $mail->send();

                // Redirect to login with a success message
                $_SESSION['error'] = "A reset link has been sent. Please check your inbox.";
                header("Location: HomeController.php?cmd=login");
                exit();

            } catch (Exception $e) {
                $view->showForm("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        } else {
            // Always show same message to prevent email enumeration
            $_SESSION['error'] = "Email not Found.";
            header("Location: HomeController.php?cmd=login");
            exit();
        }
    } else {
        $view->showForm();
    }
}



function resetPassword() {
    $token = $_GET['token'] ?? null;
    if (!$token) die("Invalid token");

    $donor = DonorModel::findByResetToken($token);
    if (!$donor) die("Token expired or invalid");

    $view = new ResetPasswordView();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newPassword = sha1($_POST['password']); // keep consistent with system
        DonorModel::updatePassword($donor['id'], $newPassword);

        // Clear token after successful reset
        DonorModel::clearResetToken($donor['id']);

        // Redirect to login page
        header("Location: HomeController.php?cmd=login");
        exit();
    } else {
        $view->showForm($token, "",false); // pass token to form so it submits back
    }
}
}


if (!isset($_SESSION))
    session_start();
$controller = new HomeController();
if (!isset($_GET['cmd'])) {
    $controller->home();
} else {
    $command = $_GET['cmd'];
    if ($command == 'login') {
        $controller->login();
    } else if ($command == 'logout') {
        $controller->logout();
    } else if ($command == 'signup') {
        $controller->signup();
    }
     else if ($command == 'forgot') {
    $controller->forgotPassword();
}
else if ($command == 'reset') {
    $controller->resetPassword();
}
}

$controller->homeView->PrintFooter();
