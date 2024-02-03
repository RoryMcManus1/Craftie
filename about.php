<?php
include("db.php");
session_start();
if(!isset($_COOKIE["ageV"])){
    header("location: ageGate.php");
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylingIndex.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
                    <h1>Our Mission</h1>
                    <br>
                    <br>
                    <br>
                        <h5>We here at Craftie love beer in all shapes, tastes and flavours, and we think you should too!
                            <br><br>
                            That is why we are dedicated to providing a service allowing beer loving folk to enjoy
                            premium craft beers from around the world!

                        </h5>

                </div>

                <div class="col-2">
                    <img src="img/beerlogo_heart.png" width='100%'>
                </div>

            </div>
        </div>
    </div>



    <!-- TESTIMONIALS -->
    <div class="testimonial">
        <h2 class="title">Our Team!</h2>
        <div class="small_container">


            <div class="row">
            <div class="col-3">
                <h4>Francesca Maker</h4>
                <img src="img/woman4.jpg" style="max-width: 100px;">
                <h3>Founder</h3>
            </div>
            <div class="col-3">
                <h4>Lisa Ferdinand</h4>
                <img src="img/woman2.jpg">
                <h3>Creative Content Producer</h3>
            </div>
            <div class="col-3">
                <h4>Alex Taylor</h4>
                <img src="img/man1.jpg" >
                <br>
                <h3> <br>Chief Commercial Officer</h3>
            </div>
        </div>
        
            <div class="row">
              
                <div class="col-3">
                    <h4>Rory McManus</h4>
                    <img src="img/me.jpg" alt="">
                    <h3>Lead Developer</h3>
                </div>
                <div class="col-3">
                    <h4>Conor O'Brien</h4>
                    <img src="img/man5.png" alt="">
                    <h3>Logistics Manager</h3>
                </div>
                <div class="col-3">
                    <h4>Michelle Smith</h4>
                    <img src="img/woman3.jpg" alt="">
                    <h3>Customer Service Team Leader</h3>
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



</body>

</html>