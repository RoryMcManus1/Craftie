<?php

include("db.php");

session_start();
//this page lets the user type in a new password
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/resetstyling.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>


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

    </div>
    <!---------------------------- New Password Page ------------------------------------------------>


    <div class="account-page">
        <h2 class="title">Membership Payment</h2>
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div class="form-container" style="top:75px">
                        <form action="includes\payment.php" id="paymentform" method="post">
                            Card Details
                            <input type="text" name="nameOnCard" placeholder="Name of card holder...">
                            <input type="text" name="cardtype" placeholder="cardtype(Visa,Electro,Maestro)">
                            <input type="password" name="accountNum" placeholder="Account Number...">
                            <input type="password" name="CVC" placeholder="CVC...">
                            <input type="date" name="expiry" placeholder="Expiry Date...(MM/YYYY)">
                            Delivery Details
                            <input type="text" name="housenum" placeholder="House/Apt. Num">
                            <input type="text" name="streetname" placeholder="Street Name">
                            <input type="text" name="townorcity" placeholder="Town/City">
                            <input type="text" name="postcode" placeholder="Postcode/Zipcode">
                            <input type="text" name="country" placeholder="Country">
                           Monthly Delivery Date
                            <input type="number" min="1" max="31" name="deliverydate" placeholder="(DD)...">
                            <input type="hidden" name="currentUser" value="$currentUser">
                            <button type="submit" name="carddetails" class="btn"> Confirm </button>
                            <?php if (isset($_GET["age"])) {
                                if ($_GET["age"] == "under") {
                                    echo "<p>You must be 18 or over to access this site!</p>";
                                }
                        }

                         if (isset($_GET["error"])) {
                            if ($_GET["error"] == "emptyinput") {
                                echo "<p>All Fields required!</p>";
                            }
                    }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---------------------------- Footer --------------------------------->
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