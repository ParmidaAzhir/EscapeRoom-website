<?php
ob_start(); //ensures that all output is stored in a buffer and not sent to the browser immediately
session_start();
require('DBconnection.php'); 

// clean user input
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    //check if its an admin
    $admin_query = "SELECT * FROM admin WHERE email = ?";
    if ($admin_stmt = $conn->prepare($admin_query)) {
        $admin_stmt->bind_param("s", $email);
        $admin_stmt->execute();
        $admin_result = $admin_stmt->get_result();

        if ($admin_result->num_rows > 0) {
            $admin_row = $admin_result->fetch_assoc(); //fetch a row as an associative array

            if ($password === $admin_row['password']) { 
                $_SESSION['admin_id'] = $admin_row['id'];
                $_SESSION['admin_email'] = $admin_row['email'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<script>alert('Incorrect admin password.')</script>";
            }
        } else {
            // If admin not found, check for user credentials
            $user_query = "SELECT * FROM users WHERE email = ?";
            if ($user_stmt = $conn->prepare($user_query)) {
                $user_stmt->bind_param("s", $email);
                $user_stmt->execute();
                $user_result = $user_stmt->get_result();

                if ($user_result->num_rows > 0) { // if exist
                    $user_row = $user_result->fetch_assoc(); 

                    if (password_verify($password, $user_row['password'])) {
                        // check if $password, $user_row['password'] are the same
                        // Record the login time in the user_logins table
                        $login_time = date('Y-m-d H:i:s');
                        $login_query = "INSERT INTO user_logins (user_id, login_time) VALUES (?, ?)";
                        if ($login_stmt = $conn->prepare($login_query)) {
                            $login_stmt->bind_param("is", $user_row['id'], $login_time);
                            $login_stmt->execute();
                            $login_stmt->close();
                        }

                        $_SESSION['user_id'] = $user_row['id'];
                        $_SESSION['username'] = $user_row['firstname'] . ' ' . $user_row['lastname'];
                        $_SESSION['email'] = $user_row['email'];
                        header("Location: user_dashboard.php");
                        exit();
                    } else {
                        echo "<script>alert('Incorrect user password.')</script>";
                    }
                } else {
                    echo "<script>alert('User not found.')</script>";
                }

                $user_stmt->close();
            } else {
                error_log("Error preparing user statement: " . $conn->error);
            }
        }

        $admin_stmt->close();
    } else {
        error_log("Error preparing admin statement: " . $conn->error);
    }
}

$conn->close();
ob_end_flush(); // Flush output buffer and send output to the browser
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EscapeRoom</title>
    <link rel="stylesheet" href="css/login.css"> 
</head>
<body>

    <header>
        <h1>EscapeRoom - Login</h1>
        <nav>
            <a href="index.html">Home</a>
        </nav>
    </header>

    <!-- login section starts -->
    <section class="login" id="login">
        <h1 class="heading"> login to your account </h1>

        <div class="login-form">
            <form action="login.php" method="POST">
                <div class="form-parts">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-parts">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>

                <div class="form-parts">
                    <a href="register.php">Register</a>
                </div>
            </form>
        </div>
    </section>
    <!-- login section ends -->

    <script src="js/script.js"></script>


</body>
</html>