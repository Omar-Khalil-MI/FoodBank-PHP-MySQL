<?php
class ForgotPasswordView {
    /**
     * Show the forgot password form
     * @param string $message Optional message to display
     * @param bool $isAdmin If true, shows admin version; else donor
     */
    public function showForm($message = "", $isAdmin = false) {
        $title = $isAdmin ? "Admin Forgot Password" : "Forgot Password";
        $action = $isAdmin ? "../Controller/AdminController.php?cmd=forgot" : "../Controller/HomeController.php?cmd=forgot";
        $backLink = $isAdmin ? "../Controller/AdminController.php?cmd=login" : "../Controller/HomeController.php?cmd=login";

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
                
                <form action="' . $action . '" method="POST" class="form">
        ';

        if (!empty($message)) {
            $color = (strpos(strtolower($message), 'error') !== false || strpos(strtolower($message), 'could not') !== false) ? 'red' : 'green';
            echo '<p id="error" style="color: ' . $color . ';">' . htmlspecialchars($message) . '</p>';
        }

        echo '
                    <div class="input-box">
                        <label>Email:</label>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <button type="submit">Send Reset Link</button>
                    <a class="cancel-btn" href="' . $backLink . '">Back to Login</a>
                </form>
            </section>
        </body>
        </html>';
    }
}
