<?php
require('DBconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']); //Escape special char(sanitize)
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date']);
    $reservation_time = mysqli_real_escape_string($conn, $_POST['reservation_time']);
    $message = !empty($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : '';

    $sql = "INSERT INTO reservations (name, email, phone, reservation_date, reservation_time, message) 
            VALUES ('$name', '$email', '$phone', '$reservation_date', '$reservation_time', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('reservation successfully booked!');
            window.location.href='bookings.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn); // close db connection
}
?>