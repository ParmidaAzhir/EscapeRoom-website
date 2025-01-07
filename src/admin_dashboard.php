<?php
session_start();
require('DBconnection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.html');
    exit();
}

if (isset($_GET['delete_user_id'])) {
    $user_id = $_GET['delete_user_id'];
    $query = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($conn, $query);

    $reservation_query = "DELETE FROM reservations WHERE email = (SELECT email FROM users WHERE id = $user_id)";
    mysqli_query($conn, $reservation_query);

    header('Location: admin_dashboard.php#users');
    exit();
}

if (isset($_GET['delete_reservation_id'])) {
    $reservation_id = $_GET['delete_reservation_id'];
    $query = "DELETE FROM reservations WHERE id = $reservation_id";
    mysqli_query($conn, $query);

    header('Location: admin_dashboard.php#reservations');
    exit();
}

if (isset($_GET['edit_user_id'])) {
    $user_id = $_GET['edit_user_id'];
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);//Fetch a row as an assivociative array from result

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $update_query = "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', phone='$phone', address='$address' WHERE id = $user_id";
        if (mysqli_query($conn, $update_query)) {
            header('Location: admin_dashboard.php#users');
            exit();
        } else {
            echo "Error updating user: " . mysqli_error($conn);
        }
    }
}

if (isset($_GET['edit_reservation_id'])) {
    $reservation_id = $_GET['edit_reservation_id'];
    $query = "SELECT * FROM reservations WHERE id = $reservation_id";
    $result = mysqli_query($conn, $query);
    $reservation = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $reservation_date = $_POST['reservation_date'];
        $reservation_time = $_POST['reservation_time'];

        $update_query = "UPDATE reservations SET name='$name', phone='$phone', reservation_date='$reservation_date', reservation_time='$reservation_time' WHERE id = $reservation_id";
        if (mysqli_query($conn, $update_query)) {
            header('Location: admin_dashboard.php#reservations');
            exit();
        } else {
            echo "Error updating reservation: " . mysqli_error($conn);
        }
    }
}

// Fetches all users.
$user_query = "SELECT * FROM users";
$user_result = mysqli_query($conn, $user_query);

// Fetches reservations with associated user names.
$reservation_query = "
    SELECT reservations.*, CONCAT(users.firstname, ' ', users.middlename, ' ', users.lastname) AS user_name 
    FROM reservations 
    LEFT JOIN users ON reservations.email = users.email";
$reservation_result = mysqli_query($conn, $reservation_query);

// Fetches user login history with associated user names, ordered by most recent login
$login_query = "
    SELECT user_logins.*, CONCAT(users.firstname, ' ', users.middlename, ' ', users.lastname) AS user_name 
    FROM user_logins 
    LEFT JOIN users ON user_logins.user_id = users.id
    ORDER BY login_time DESC";
$login_result = mysqli_query($conn, $login_query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>

<header>
    <h1>Managment section</section></h1>
    <nav class="navbar">
        <a href="#users">Users</a>
        <a href="#reservations">reservations</a>
        <a href="#logins">Login details</a>
        <a href="logout.php" class="logout">Logout</a>
    </nav>
</header>

<!-- Admin Dashboard section starts -->
<section class="admin-dashboard" id="users">
    <h2>Users data</h2>
    <div class="box-container">
        <?php while ($row = mysqli_fetch_assoc($user_result)): ?>
        <div class="box user-box">
            <h3><?php echo $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']; ?></h3>
            <p>Email: <?php echo $row['email']; ?></p>
            <p>Phone: <?php echo $row['phone']; ?></p>
            <p>Address: <?php echo $row['address']; ?></p>
            <a href="admin_dashboard.php?edit_user_id=<?php echo $row['id']; ?>#edit-section" class="btn">Edit</a>
            <!-- set edit_user_id to $row['id] -->
            <a href="admin_dashboard.php?delete_user_id=<?php echo $row['id']; ?>" class="btn delete-btn">Delete</a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<section class="admin-dashboard" id="reservations">
    <h2>reservations</h2>
    <div class="box-container">
        <?php while ($row = mysqli_fetch_assoc($reservation_result)): ?>
        <div class="box reservation-box">
            <h3>reservation NO: <?php echo $row['id']; ?></h3>
            <p>Name: <?php echo $row['name']; ?></p>
            <p>Email: <?php echo $row['email']; ?></p>
            <p>Phone: <?php echo $row['phone']; ?></p>
            <p>reservation Date: <?php echo $row['reservation_date']; ?></p>
            <p>reservation Time: <?php echo $row['reservation_time'] ; ?></p>
            <p>User: <?php echo isset($row['user_name']) ? $row['user_name'] : 'Unknown'; ?></p>
            <!--if $row['user_name'] is not empty or null show $row['user_name']-->
            <!-- else: unknown-->
            <a href="admin_dashboard.php?edit_reservation_id=<?php echo $row['id']; ?>#edit-section" class="btn">Edit</a>
            <a href="admin_dashboard.php?delete_reservation_id=<?php echo $row['id']; ?>" class="btn delete-btn">Cancel</a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<section class="admin-dashboard" id="logins">
    <h2>Login History</h2>
    <div class="box-container">
        <?php while ($row = mysqli_fetch_assoc($login_result)): ?>
        <div class="box login-box">
            <h3><?php echo $row['user_name']; ?></h3>
            <p>Login Time: <?php echo $row['login_time']; ?></p>
        </div>
        <?php endwhile; ?>
    </div>


<!-- Edit User or reservation Form -->
<section class="admin-dashboard" id="edit-section">
    <?php if (isset($_GET['edit_user_id'])): ?>
    <h2>Edit User</h2>
    <form action="" method="POST">
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" required>
        <label for="middlename">Middle Name:</label>
        <input type="text" name="middlename" value="<?php echo $user['middlename']; ?>">
        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" readonly>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $user['address']; ?>" required>
        <button type="submit" class="btn">Update</button>
    </form>
    <?php endif; ?>

    <?php if (isset($_GET['edit_reservation_id'])): ?>
    <h2>Edit reservation</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $reservation['name']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $reservation['email']; ?>" readonly>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo $reservation['phone']; ?>" required>
        <label for="reservation_date">reservation Date:</label>
        <input type="date" name="reservation_date" value="<?php echo $reservation['reservation_date']; ?>" required>
        <label for="reservation_time">reservation Time:</label>
        <input type="time" name="reservation_time" value="<?php echo $reservation['reservation_time']; ?>">
        <button type="submit" class="btn">Update</button>
    </form>
    <?php endif; ?>
</section>


<script src="js/script.js"></script>

<!-- Add this new JavaScript to limit the number input length -->

</body>
</html>