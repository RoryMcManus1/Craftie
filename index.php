<?php
include("db.php");
session_start();

if (!isset($_COOKIE["ageV"])) {
    header("location: ageGate.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRAFTIE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylingIndex.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>

    <div class="header">
        <div class="container">


            <div class="navbar">
                <div class="nav">
                    <a href="index.php"> <img src="img/craftie_logoFinal.png" width="125px"></a>
                </div>
                <nav>
                    <ul id='menuItems'>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="promotions.php">Shop</a></li>
                        <li><a href="allproducts.php">Products</a></li>
                        <li><a href="about.php">About</a></li>
                        <?php
    //if logged in
                        if (isset($_SESSION["userId"])) {
                            $currentUser = $_SESSION['userId'];
                            $sqlread = "SELECT * FROM users WHERE userId = $currentUser";
                            $result = $conn->query($sqlread);
                            if ($row = mysqli_fetch_assoc($result)) {
                                $ismember = $row['isMember'];
                            }
                            //if member
                            if ($ismember == "yes") {
                                echo "<li><a href='profile.php'>Profile</a></li>";
                                echo "<li><a href='wishlist.php'>WishList</a></li>";
                                echo " <li><a href='includes/logout.php'>Log Out</a></li>";
                                echo "<a href='cart.php'><img src='img/cart.png' width='30px' height='30px'></a>";
                            }else{
                                echo "<li><a href='profile.php'>Profile</a></li>";
                                echo "<li><a href='membershipinfo.php'>Membership</a></li>";
                                echo " <li><a href='includes/logout.php'>Log Out</a></li>";
                            }
                           
                        } else {
                            echo " <li><a href='account.php'>Sign Up/Sign In</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
              
                <img src="img/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
            <div class="row">
                <div class="col-2">
                    <h1>Serious Beer,<br> for Serious Folk</h1>
                    <p>The world's most recent Craft Beer site!
                    </p>
                    <?php
                    //if the current user is loggedd in
                    if (isset($_SESSION["userId"])) {
                        $currentUser = $_SESSION['userId'];
                        $sqlread = "SELECT * FROM users WHERE userId = $currentUser";
                        $result = $conn->query($sqlread);

                       

                        if ($row = mysqli_fetch_assoc($result)) {
                            $name = $row['userName'];
                            $newsletter = $row['newsletter'];

                            $ismember = $row['isMember'];
                            echo "<p>Welcome Back " . $name . "</p>";
                        }
                        if ($ismember == "yes" && $newsletter=="no") {
                            

                            echo "<a href='promotions.php' class='btn'>Shop Now &#10146;</a>";
                            echo "<a href='profile.php' class='btn'>View Profile &#10146;</a>";
                           
                            echo "<a href='newsletter.php' class='btn'>Subscribe to our Newsletter &#10146;</a>";
                        } if ($ismember == "yes" && $newsletter=="yes") {
                            echo "<a href='promotions.php' class='btn'>Shop Now &#10146;</a>";
                            echo "<a href='profile.php' class='btn'>View Profile &#10146;</a>";
                           
                            
                        }
                            else if ($ismember === "no") {
                          

                            echo "<a href='promotions.php' class='btn'>Browse Now &#10146;</a>";
                            echo "<a href='profile.php' class='btn'>View Profile &#10146;</a>";
                            echo "<a href='membershipinfo.php' class='btn'>Become a Member! &#10146;</a>";
                        }
                    } else {
                        echo  "<a href='promotions.php' class='btn'>Shop Now &#10146;</a>";
                        echo " <a href='account.php' class='btn'>Sign Up/Sign In &#10146;</a>";
                    }

                    ?>



                </div>

                <div class="col-2">
                    <img src="img/beerlogo_heart.png" width='100%'>
                </div>

            </div>
        </div>
    </div>



    <!-- TESTIMONIALS -->
    <div class="testimonial">
        <h2 class="title">Testimonials</h2>
        <div class="small_container">
            <div class="row">

                <div class="col-3">
                    <i class="fa fa-quote-left"></i>
                    <p>Fantastic service with knowledgable reps. Very friendly and able to cater the service for my needs. I would happily recommend to a friend. </p>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <img src="img/user-1.png" alt="">
                    <h3>Sean Parker</h3>
                </div>
                <div class="col-3">
                    <i class="fa fa-quote-left"></i>
                    <p> Once signed up, the first delivery arrived within a day or two, containing some very interesting and unusual beers. An excellent service.
                    </p>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <img src="img/user-2.png" alt="">
                    <h3>John Magee</h3>
                </div>
                <div class="col-3">
                    <i class="fa fa-quote-left"></i>
                    <p>Fantastic Customer service, check in on you, no problem they can't solve. Great beer too obviously. Great service and very friendly. </p>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <img src="img/user-3.png" alt="">
                    <h3>Susan Ford</h3>
                </div>


            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <a href="index.php"> <img src="img/craftie_logoFinal.png"> </a>
                </div>
                <div class="footer-col-2">

                    <ul>
                        <a href="about.php">
                            <li>About Us</li>
                        </a>
                        <a href="promotions.php">
                            <li>Shop</li>
                        </a>
                        <a href="account.php">
                            <li>Account</li>
                        </a>
                    </ul>
                </div>
                <div class="footer-col-3">
                    <p>Craftie Copyright 2021</p>
                </div>


            </div>
        </div>
    </div>
    <!-- JS FOR TOGGLE MENU -->
    <script>
        var menuItems = document.getElementById("menuItems");

        menuItems.style.maxHeight = "0px";

        function menutoggle() {
            if (menuItems.style.maxHeight == "0px") {
                menuItems.style.maxHeight = "200px";
            } else {
                menuItems.style.maxHeight = "0px";
            }

        }
    </script>
    <script type="text/javascript">
        function confirmAge() {
            var d = new Date();
            //var time_stmp = Math.round(d.getTime()/1000);
            var now_us = d.getTime();


            var myDate = document.getElementById('day').value + "-" + document.getElementById('mon').value + "-" + document.getElementById('yer').value;
            myDate = myDate.split("-");
            var newDate = myDate[1] + "/" + myDate[0] + "/" + myDate[2];
            var date_us = new Date(newDate).getTime();

            var age_us = (now_us - date_us) / (1000 * 356 * 24 * 3600);


            if (age_us < 18) {
                alert("You must be 18 years of age to see this site.");
                return false;
            } else
                document.getElementById('ac-wrapper').style.display = "none";

        }
    </script>


</body>

</html>