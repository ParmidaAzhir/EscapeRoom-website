<?php
ob_start();
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require('DBconnection.php');

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); //Fetch a row as an assi\ociative array from result

// Update user information if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    $sql_update = "UPDATE users SET firstname = ?, middlename = ?, lastname = ?, phone = ?, address = ?, email = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('ssssssi', $firstname, $middlename, $lastname, $phone, $address, $email, $user_id);
    if ($stmt_update->execute()) {
        // Refresh the page to reflect the changes
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (password_verify($current_password, $user['password'])) {
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql_update_password = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_update_password = $conn->prepare($sql_update_password);
            $stmt_update_password->bind_param('si', $hashed_password, $user_id);
            if ($stmt_update_password->execute()) {
                echo "<script>
                        alert('Password changed successfully.');
                        window.location.href = 'profile.php'; // Redirect after popup
                      </script>";
                exit();
            } else {
                echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('New password and confirm password do not match.');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> My Account</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<header>
        <h1>My Account</h1>
        <nav>
            <a href="user_dashboard.php">Home</a>
        </nav>
    </header>

<section class="user-Account">
    <h2>Welcome, <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>!</h2>

    <div class="Account-container">
        <div class="Account-section">
            <h3>Your data</h3>
            <form action="profile.php" method="post">
                <input type="hidden" name="update_profile" value="1"> <!-- this hidden input could be used to show if the form submission is for updating a profile-->
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>

                <label for="middlename">Middle Name:</label>
                <input type="text" id="middlename" name="middlename" value="<?php echo htmlspecialchars($user['middlename']); ?>">

                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <input type="submit" class="btn" value="Update Information">
            </form>
        </div>

        <!-- Change Password Section -->
        <div class="Account-section">
            <h3>Change Password</h3>
            <form action="profile.php" method="post">
                <input type="hidden" name="change_password" value="1">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <input type="submit" class="btn" value="Change Password">
            </form>
        </div>
    </div>
</section>

<!--js link -->
<script src="script.js"></script>
</body>
</html>