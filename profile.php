<?php

include("db.php");
session_start();

if (!isset($_COOKIE["ageV"])) {
    header("location: ageGate.php");
}

$currentUser = $_SESSION['userId'];
$sqlread = "SELECT * FROM users WHERE userId = $currentUser";



$result = $conn->query($sqlread);

if ($row = mysqli_fetch_assoc($result)) {
    $name = $row['userName'];
    $userName = $row['userUsername'];
    $usersemail = $row['userEmail'];
    $newsletter = $row['newsletter'];
    $ismember = $row['isMember'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/profilesstyling.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>


    <div class="container">


        <div class="navbar">
            <div class="logo">
                <a href="index.php"> <img src="img/craftie_logoFinal.png" width="125px"></a>
            </div>
            <nav>
                <ul id='menuItems'>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="promotions.php">Shop</a></li>
                    <li><a href="allproducts.php">Products</a></li>
                    <li><a href="about.php">About</a></li>
                    <?php
                    if (isset($_SESSION["userId"])) {
                        echo "<li><a href='profile.php'>Profile</a></li>";
                        echo "<li><a href='wishlist.php'>WishList</a></li>";
                        echo " <li><a href='includes/logout.php'>Log Out</a></li>";
                    } else {
                        echo " <li><a href='account.php'>Sign Up/Sign In</a></li>";
                    }
                    ?>


                </ul>
            </nav>
            <a href="cart.php"><img src="img/cart.png" width="30px" height="30px"></a>
            <img src="img/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>

    </div>
    <!---------------------------- Account Page ------------------------------------------------>

    <div class="account-page">
        <h2 class="title">Your Details</h2>
        <div class="container">
            <div class="row">

                <?php
                if (!isset($_SESSION["userId"])) {
                    header("location: index.php");
                    exit();
                }  ?>
                <div class='form-container' style='top:75px'>
                    <div class='form-btn'>
                    </div>
                    <!-------------------------- NEW USERS ------------------------------>

                    <?php
                    echo "
                    <form action='includes\update-info.php' id='RegForm' method='post'>
                        <input type='text' name='name1' placeholder='$name...'>
                        <input type='text' name='username1' placeholder='$userName...'>
                        <input type='Email' name='email1' placeholder='$usersemail...'>
                        <input type='password' name='password1' placeholder='Password...'>
                        <input type='password' name='password-rpt1' placeholder='Confirm Password...'>
                        <button type='submit' name='submit1' class='btn'> Save Changes </button>
                        <a class='btn' href='accountdeletion.php' >Delete Account</a></button>";
                        if($ismember=='no' && $newsletter =='no'){
                     echo " <a class='btn' href='membershipinfo.php' >Become A Member</a></button>";
                        }else if($ismember=='yes' && $newsletter =='no'){
                      echo "<button type='submit' name='unsubscribemember' class='btn'> Cancel Membership </button>";
                    }else if($ismember=='yes' && $newsletter =='yes'){
                        echo "<button type='submit' name='unsubscribemember' class='btn'> Cancel Membership </button>";
                     echo " <button type='submit' name='unsubscribenewsletter' class='btn'> Unsubscribe From Newsletter </button>
                        ";
                    }




                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo "<p>All Fields required!</p>";
                        } else if ($_GET["error"] == "invalidusername") {
                            echo "<p>Invalid Username, Please try again!</p>";
                        } else if ($_GET["error"] == "invalidemail") {
                            echo "<p>Invalid Email, Please try again!</p>";
                        } else if ($_GET["error"] == "passwordmismatch") {
                            echo "<p>Passwords did not match, Please try again!</p>";
                        } else if ($_GET["error"] == "stmtfail1") {
                            echo "<p>Something went wrong, Please try again!</p>";
                        } else if ($_GET["error"] == "stmtfail2") {
                            echo "<p>Something went wrong, Please try again!</p>";
                        } else if ($_GET["error"] == "none") {
                            echo "<p>Account Update successful!</p>";
                        }else if ($_GET["error"] == "usernametaken") {
                            echo "<p>Username Or Email Already taken!</p>";
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