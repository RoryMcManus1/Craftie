<?php
include("db.php");
session_start();

if (!isset($_COOKIE["ageV"])) {
    header("location: ageGate.php");
}

include("db.php");

$sqlread1 = "SELECT * FROM allbeers";

$result1 = $conn->query($sqlread1);

if (!$result1) {
    echo $conn->error;
}

$sqlreadstyles = "SELECT  beerstyles.style
FROM allbeers
INNER JOIN beerstyles ON allbeers.id=beerstyles.style_id;";
$resultstyles = $conn->query($sqlreadstyles);




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/productdetailstyle.css">
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
    <div class='account-page'>

        <div class='small_container'>
            <div class='row'>
                <div class='col-2'>

                    <?php
                  
                    echo " <div class='row' style= 'padding-bottom: 100px;'>
                        <h2 class='title'>Add Product</h2>
                        </div>
                        <img src='img/beerlogo_heart.png' width='100%'>
                        </div>
                        <div class='col-2'>
                            <form action='includes\adminadditem.php' id='RegForm' method='post'>
                            <h6> Beer Name </h6>
                            <input type='text' name='beername' min='1' max='16' placeholder='beer name...'>
                            <h6> Style </h6>
                            <input type='number' name='style' placeholder='style...'>
                            <h6> ABV </h6>
                            <input type='number' name='ABV' step='.01' placeholder='ABV...'>
                            <h6> Description </h6>
                            <textarea name='desc' placeholder='description...'></textarea>
                            <h6> Overall Rating </h6>
                            <input type='number' name='overall' min='1' max='5' placeholder='overall...'>
                            <h6> Taste Rating </h6>
                            <input type='number' name='taste' min='1' max='5' placeholder='taste...'>
                            <h6> Appearance Rating </h6>
                            <input type='number' name='appearance' min='1' max='5' placeholder='appearance...'>
                            <h6> Aroma Rating </h6>
                            <input type='number' name='aroma' min='1' max='5' placeholder='aroma...'>
                            <h6> Image URL </h6>
                            <input type='url' name='images' placeholder='images...'>
                            <br>
                            <input type='hidden' name='iddata' value='itemid'>
                            <button type='submit' name='submitadminadd' class='btn'> Save Changes </button>"

                    ?>
                </div>
            </div>
        </div>

    </div>



    <!-- Footer -->
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