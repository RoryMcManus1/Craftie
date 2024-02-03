<?php

include("db.php");

session_start();

if(!isset($_COOKIE["ageV"])){
    header("location: ageGate.php");
}
//this allows the user to request a password reset email
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
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
    <!---------------------------- reset email request Page ------------------------------------------------>

    <div class="account-page">
        <h2 class="title">Password Reset</h2>
       

        <div class="container">
            <div class="row">

               
                <div class='form-container' style='top:75px'>
                    <div class='form-btn'>
                    </div>
                    <!-------------------------- NEW USERS ------------------------------>
                    <form action='includes\reset_pass_request.php' id='RegForm' method='post'>
                    <h4>An e-mail will be sent to you with instructions on how to reset your password.</h4>
                        <input type='Email' name='userEmail' placeholder='Email...'>
                        <button type='submit' name='reset-request' class='btn'> Request Reset Email </button>
                        <?php

                        if(isset($_GET["reset"])){
                            if($_GET["reset"]== "success"){
                                echo "<p class='resetsuccess'>Email Sent!</p>";
                            }
                        }

                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "emptyinput") {
                                echo "<p>All Fields required!</p>";
                            } else if ($_GET["error"] == "invalidemail") {
                                echo "<p>Invalid Email, Please try again!</p>";
                            }  else if ($_GET["error"] == "stmtfail1") {
                                echo "<p>Something went wrong, Please try again!</p>";
                            } else if ($_GET["error"] == "stmtfail2") {
                                echo "<p>Something went wrong, Please try again!</p>";
                            } else if ($_GET["error"] == "none") {
                                echo "<p>Email Sent!</p>";
                            }
                        }
                        ?>
                    </form>
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