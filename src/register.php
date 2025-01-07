<?php
require('DBconnection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="css/register.css"> 
<!-- connect the HTML document to an external CSS file named register.css-->
</head>
<body>

    <header>
            <h1>EscapeRoom - Registration</h1>
            <nav>
                <a href="index.html">Home</a>
            </nav>
    </header>

    
    <form action="process_register.php" method="post">
        <label>Firstname:</label>
        <input type="text" name="firstname" size="15" required/> <br> <br>
        
        <label>Middlename:</label>
        <input type="text" name="middlename" size="15"/> <br> <br>
        
        <label>Lastname:</label>
        <input type="text" name="lastname" size="15" required/> <br> <br>
        
        <label>Gender:</label> <br>
        <input type="radio" name="gender" value="male" id="male" required/>
        <label for="male">Male</label>
        <input type="radio" name="gender" value="female" id="female" required/>
        <label for="female">Female</label> <br> <br>
        
        <label>Phone:</label>
        <input type="text" name="phone" size="15" required/> <br> <br>
        
        <label>Address:</label> <br>
        <textarea name="address" cols="80" rows="5" required></textarea> <br> <br>
        
        <label>Email:</label>
        <input type="email" name="email" required/> <br> <br>
        
        <label>Password:</label>
        <input type="password" name="password" required> <br> <br>
        
        <label>Re-type password:</label>
        <input type="password" name="repassword" required> <br> <br>
        
        <div class="btn-container">
            <input type="submit" value="Register Now" class="btn"/>
        </div>
    </form>

    <script src="js/script.js"></script>

</body>
</html>