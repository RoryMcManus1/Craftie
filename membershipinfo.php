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
                            } else {
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
                    <h1>Become a member of the Craftie community today!<br></h1>
                    <p>For just £20.95/m you'll have access to over 1700 unique craft beers from breweries across the globe and much more!
                    </p>
                    <?php

                    if (isset($_SESSION["userId"])) {
                        $currentUser = $_SESSION['userId'];
                        $sqlread = "SELECT * FROM users WHERE userId = $currentUser";
                        $result = $conn->query($sqlread);

                        if ($row = mysqli_fetch_assoc($result)) {
                            $name = $row['userName'];
                        }
                        
                        echo "<a href='paymentdetails.php' class='btn'>Become a Member! &#10146;</a>";
                    } else {
                        header("location: index.php");
                        exit();
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
        <h2 class="title">Membersip Benefits!</h2>
        <div class="small_container">
            <div class="row">

                <div class="col-3">
                    <h3 class="title">Routine Delivery!</h3>
                    <img src="img/deliveryicon.jpg" style="width: 100%;" >
                    <p>We deliver a crate full of premium craft beers from across the globe hand picked by you!</p>
                </div>
                <div class="col-3">
                    <h3 class="title">Monthly Newsletter!</h3>
                    <img src="img/newslettericon.png" style="width: 40%; margin: 78px 0px;" >
                    <p>Members will recieve our monthly newsletter informing them of the latest trends inthe craft beer world as well as new promotions and offers from Craftie!</p>
                </div>
                <div class="col-3">
                    <h3 class="title">Wish List!</h3>
                    <img src="img/wishlist icoon.png" style="width: 35%; margin: 84px 0px;" >
                    <p>Craftie Members are able to save their favourite beers to a Wish List to keep a log of beers to try out in future delvieries!</p>
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