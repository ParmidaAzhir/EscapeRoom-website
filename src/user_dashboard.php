<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


require('DBconnection.php');



// fetch user data if needed
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Welcome to my escape room </title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- bootstrap cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- Link to the Creepster font from Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap"  rel="stylesheet" >

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script src="https://kit.fontawesome.com/0e905df789.js" crossorigin="anonymous"></script>



</head>
<body>
   
<!-- header section starts  -->

<header class="header fixed-top">

   <div class="container">

      <div class="row align-items-center justify-content-between">

         <a href="#home" class="logo">EscapeRoom</a>

         <nav class="nav">
            <a href="#home">home</a>
            <a href="profile.php">profile</a>
            <a href=bookings.php>bookings</a>
            <a href="#about">about</a>
            <a href="#services">services</a>
            <a href="logout.php">Logout</a>
         </nav>

         <a href="#reserve" class="link-btn">make reservation if you DARE</a>

      </div>

   </div>

   </header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

   <div class="container">

      <div class="row min-vh-100 align-items-center">
         <div class="content text-center text-md-left">
            <h3 class="scary-text">  Unlock the Night: Escape Room Adventure</h3>
            <p>The darkness is alive with secrets waiting to be uncovered. Trapped in a nightmare, you must solve the sinister puzzles, escape the cursed room, and survive the terror that lurks within. Will you make it out before the shadows claim you?</p>
         </div>
      </div>

   </div>

</section>

<!-- home section ends -->

<!-- about section starts  -->

<section class="about" id="about">

   <div class="container">

      <div class="row align-items-center">

         <div class="col-md-6 image">
            <img src="images/about-img.jpg" class="w-100" alt="">
         </div>

         <div class="col-md-6 content">
            <span>about us</span>
            <h3>Pure adrenaline for your night</h3>
            <p>We are a group of enthusiastic ghosts, united by one purpose: to hunt as many souls as we can within these walls. Step into our escape house, and let us show you what we’re capable of.</p>
         </div>

      </div>

   </div>

</section>

<!-- about section ends -->

<!-- services section starts  -->

<section class="services" id="services">

   <h1 class="heading">our services</h1>

   <div class="box-container container">

      <div class="box">
         <!--adds icon from font awesome-->
         <i class="fa-solid fa-cake-candles"  style="font-size: 37px; height: 41px;"></i>
         <h3> Ensure Fun</h3>
         <p>Step into a world of excitement and thrills, where every moment is packed with mystery and adventure!</p>
      </div>

      <div class="box">
         <i class="fa-solid fa-gifts" style="font-size: 37px; height: 41px;"></i>
         <h3>Event Hosting</h3>
         <p>Hosting birthday parties, birthdays, or special celebrations with decorations and personalized themes.</p>
      </div>

      <div class="box">
         <i class="fa-solid fa-earth-americas"  style="font-size: 37px; height: 41px;"></i>
         <h3>Virtual Escape Rooms</h3>
         <p>Online or hybrid escape rooms that can be played remotely for those unable to attend in person.</p>
      </div>

      <div class="box">
         <i class="fa-solid fa-martini-glass" style="font-size: 37px; height: 41px;"></i>
         <h3>Food & Beverage Options</h3>
         <p>On-site café or snack bar to enjoy before or after the escape room experience.</p>
      </div>

      <div class="box">
         <i class="fa-solid fa-lock" style="font-size: 37px; height: 41px;"></i>
         <h3>Private reserveings</h3>
         <p>Option for private reserveings for groups or parties, ensuring no interference from other players.</p>
      </div>

      <div class="box">
         <i class="fa-regular fa-clock" style="font-size: 37px; height: 41px;"></i>
         <h3>Time Extensions</h3>
         <p>Option for extending game time for groups who may need a little extra help or wish to continue their experience.</p>
      </div>

   </div>

</section>

<!-- services section ends -->

<!-- process section starts  -->

<section class="process">


   <div class="box-container container">

      <div class="box">
         <img src="images/process-1.png" alt="">
         <h3>First: Make a group</h3>
         <p> you can come with your own group of friends or request so we match you with others</p>
      </div>

      <div class="box">
         <img src="images/process-2.png" alt="">
         <h3>Second: Choose which story to play</h3>
         <p> Each of our story has a different theme from escaping hospitals to haunted houses</p>
      </div>

      <div class="box">
         <img src="images/process-3.png" alt="">
         <h3>Third: Do as much as you can</h3>
         <p> Delve into the story, be part of it, and solve as many puzzles as you can so that you dont get stuck here forever! </p>
      </div>

   </div>

</section>



<!-- process section ends -->

<!-- Scenario section starts  -->

<section class="scenarios" id="scenarios">

   <h1 class="heading"> Scenario </h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <h3>Insane</h3>
         <p>Ahmad, Khatun, and their daughter Gisou, members of a family in the village of Dowlatabad.
            Ahmad had heard from past generations that an ancient treasure was hidden beneath their house, but it was sealed with a powerful curse, and no one should go searching for it.
            In 1378 (1999), due to a severe drought, he felt forced to search for the treasure. However, bad events began to unfold.
            Without any illness, Khatun dies. A week later, Gisou, Ahmad and Khatun's daughter, contracts cholera and dies as well. Ahmad loses his sanity and, after that day, never returns to the house again.
            You are a treasure-hunting team who has heard this story and now, you enter Ahmad and Khatun's house in search of the treasure.
            But little do you know, Ahmad is not the only madman in this tale, and he will not be the last.</p>
        
         
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <h3>Paranoia</h3>
         <p>The story began when my close friend, after separating from his wife, consulted a psychiatrist. 
            After a while, he informed me that, following the doctor's advice, he had decided to stay at a psychiatric treatment center for a month. But everything seemed very strange and suspicious. 
            I tried hard to convince him to change his mind, but my efforts were in vain. He had completely become a different person. In a very strange way, after several months, I hadn't heard anything from him or received any contact.
            Finally, I had no choice but to go to his office and search through his files. I found the admission form for a mental asylum... Immediately, I searched the name, and to my utter disbelief, I discovered that this asylum had been closed for almost fifty years, and only an abandoned building remained on the outskirts of the city!</p>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <h3>Gambler</h3>
         <p>You enter William's Chess School to learn chess with your friends.
            William greets you warmly and talks about the accomplishments he has gained over the years.
            He asks you to explore the facility and see the different rooms while he gets a drink for you...
            Once William leaves, you uncover strange truths about him.
            The memory of a defeat that torments William's soul has turned him into a madman.
            Now, you have one hour to survive the game that William has prepared for you.</p>

   </div>

</section>

<!-- Scenario section ends -->

<!-- reserveing section starts   -->
<section class="reserve" id="reserve">
   <div class="row">
      <form action="book_reservation.php" method="POST">
         <h3 class="heading">Make Reservation</h3>
         <input type="text" name="name" placeholder="Your Name" class="box" required>
         <input type="text" name="phone" placeholder="Your Number" class="box" required>
         <input type="email" name="email" placeholder="Your Email" class="box" required>
         <input type="date" name="reservation_date" class="box" required>
         <input type="time" name="reservation_time" class="box" required>
         <textarea name="message" placeholder="Service of choice (Optional)" class="box"></textarea>
         <input type="submit" name="book_reservation" value="Reserve Now" class="btn">
      </form>
   </div>
</section>
<!-- reserveing section ends -->

<!-- footer section starts  -->

<section class="footer">

   <div class="box-container container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>phone number</h3>
         <p>+39-456-7890</p>
         <p>+39-225-3033</p>
      </div>
      
      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>our address</h3>
         <p>Italy, Messina - Via Garibaldi</p>
      </div>

      <div class="box">
         <i class="fas fa-clock"></i>
         <h3>opening hours</h3>
         <p>8:00am to 2:00am</p>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>email address</h3>
         <p>EscapeRoom.messina@gmail.com</p>
         <p>EscapeRoom.italy@gmail.com</p>
      </div>

   </div>


</section>

<!-- footer section ends -->








<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>



</body>
</html>