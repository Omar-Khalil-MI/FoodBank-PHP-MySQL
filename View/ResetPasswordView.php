<?php
class ResetPasswordView {

    /**
     * Show reset password form
     * @param string $token Reset token
     * @param string $message Optional message
     * @param bool $isAdmin If true → Admin reset, else Donor
     */
    public function showForm($token = "", $message = "", $isAdmin = false) {

        $title = $isAdmin ? "Admin Reset Password" : "Reset Password";

        $action = $isAdmin
            ? "../Controller/AdminController.php?cmd=reset&token=" . urlencode($token)
            : "../Controller/HomeController.php?cmd=reset&token=" . urlencode($token);

        $backLink = $isAdmin
            ? "../Controller/AdminController.php?cmd=login"
            : "../Controller/HomeController.php?cmd=login";

        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../CSS/login.css">
            <link rel="icon" href="../Resources/logo.ico">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
                integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
                crossorigin="anonymous" referrerpolicy="no-referrer" />
            <title>' . $title . '</title>
        </head>
        <body>
            <section class="container">
                <header>
                    <h1>' . $title . '</h1>
                </header>
        ';

        if (!empty($message)) {
            $color = (strpos(strtolower($message), 'error') !== false) ? 'red' : 'green';
            echo '<p id="error" style="color:' . $color . ';">' . htmlspecialchars($message) . '</p>';
        }

        echo '
                <form action="' . $action . '" method="POST" class="form">
                    <div class="input-box">
                        <label>New Password:</label>
                        <input type="password" name="password" placeholder="Enter new password" required>
                        <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                    </div>

                    <button type="submit">Reset Password</button>
                    <a class="cancel-btn" href="' . $backLink . '">Back to Login</a>
                </form>
            </section>

            <script>
                const passwordField = document.querySelector(".input-box input[type=password]");
                const togglePassword = document.querySelector(".password-toggle-icon i");

                togglePassword.addEventListener("click", function () {
                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        togglePassword.classList.remove("fa-eye");
                        togglePassword.classList.add("fa-eye-slash");
                    } else {
                        passwordField.type = "password";
                        togglePassword.classList.remove("fa-eye-slash");
                        togglePassword.classList.add("fa-eye");
                    }
                });
            </script>
        </body>
        </html>';
    }
}
