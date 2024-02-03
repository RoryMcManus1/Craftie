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
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/cartsstyling.css">
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

    </div>

    <!----------- CART ITEMS DETIALS --------------->
    <div class=cart-container>
        <div class="cart-page">
            <table style='width:100%'>
                <table>
                    <tr>
                        <th>Product</th>
                        <th></th>
                        <th>Quantity</th>
                    </tr>
                </table>

                <?php
                if (isset($_SESSION["userId"])) {
                    $currentUser = $_SESSION['userId'];
                    //crate table - totalQuantit
                    $sqltotal = "SELECT SUM(quantity)
                    FROM crates WHERE user_id = $currentUser;";
                    $resulttotal = $conn->query($sqltotal);
                    $row1 = mysqli_fetch_array($resulttotal);
                    $quantitytotal = $row1['SUM(quantity)'];

                    $sqlread1 = "SELECT `crates`.*, `users`.`userName`, `allbeers`.`beerName`, `allbeers`.`images`
                FROM `crates` 
                LEFT JOIN `users` ON `crates`.`user_id` = '$currentUser'
                LEFT JOIN `allbeers` ON `crates`.`item_id` = `allbeers`.`id`  WHERE userId = '$currentUser';
             ";
                    $result1 = $conn->query($sqlread1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $userid = $row1['user_id'];
                        $itemid = $row1['item_id'];
                        $quantity = $row1['quantity'];
                        $beername = $row1['beerName'];
                        $images = $row1['images'];
                        $crateid =  $row1['crate_id'];
                        echo "
                    <br>
                    <table style='width:100%'>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><img  class='td' src=$images class='card-img-top'></td>
                      <td>$beername</td>
                      <td>$quantity
                      <form action='includes/removeitemfromcart.php' id='RegForm' method='post'>
                      <input type='hidden' name='crateid' value='$crateid'>
                                    <button type='submit' name='removeitemfromcart' class='btn'> remove </button>
                                </form></td>
                    </tr>
                  </table>
                 ";
                    }
                  
                    if (!isset($_POST['confirmorder'])) {
                        echo "<table>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                        </tr>
                        <tr>
                        <td></td>
                        <td></td>
                        <td>$quantitytotal/24 Beers in this month's Crate</td>
                        </tr>
                    </table>";
        
                        if ($quantitytotal < 24) {
                            echo "Please Continue to add to this crate until it is full!";
                        } else if ($quantitytotal > 24) {
                            echo "Crate contains too many beers, please select a maximum of 24 per crate!";
                        } else {
                            echo "
                        <form action='includes/removeitemfromcart.php' id='RegForm' method='post'>
                        <div class='row3' Crate Full and ready for shipping!>
                <button type='submit' name='confirmorder' class='btn'>Confirm Order</button>
                </div>
                </form>";
                        }
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "noneOP") {
                                echo " <table>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                            <td></td>
                            <td></td>
                            <td>Order Placed!</td>
                            </tr>
                        </table>";
                            }
                        }
                    }
                }



                ?>
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