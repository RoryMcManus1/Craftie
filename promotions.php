<?php
include("db.php");
session_start();
$read = "SELECT * FROM allbeers";
$result = $conn->query($read);
if (!isset($_COOKIE["ageV"])) {
    header("location: ageGate.php");
}

$sqlread2 = "SELECT  ratings.rating
FROM allbeers
INNER JOIN ratings ON allbeers.id=ratings.rating_id;";
$result2 = $conn->query($sqlread2);

?>
<?php

include("db.php");

$sqlread1 = "SELECT * FROM allbeers";

$result1 = $conn->query($sqlread1);

if (!$result1) {
    echo $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylepromo.css">
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
           
            <img src="img/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>

    </div>
    <div class='promotion'>
        <div class='small_container'>
            <div class="row">

                <?php
                $count = 0;

                while ($row = $result->fetch_assoc()) {
                    if ($count !== 1) {
                        // echo "<p class=''>{$row['product']}</p>";
                        $beer_name = $row['beerName'];
                        $description = $row['review'];
                        $images = $row['images'];

                        $overall_rating = $row['overall'];
                        $iddata = $row['id'];

                        $count++;


                        echo "
                        
                        <div class='col-2'>
                        <a href='productdetails.php?rowid=$iddata'>
                    <img src=$images class='promo-image'>
                </div>
                
                <div class='col-2'>
                    <h1>$beer_name</h1>
                    <a href='productdetails.php?rowid=$iddata' class='btn'>View Details</a>
                    <h3>Product Details <i class='fa fa-indent' style = colour:#ff523b></i></h3>
                    <small>$description...</small>
                    </div>
            
                    ";
                    }
                }



                ?>
            </div>
        </div>
    </div>





    <h2 class='title'>Latest Products</h2>
    <div class="small_container">
        <div class='row'>


            <?php
            $count1 = 0;

            while ($row = $result1->fetch_assoc()) {
                if ($count1 !== 3) {
                    // echo "<p class=''>{$row['product']}</p>";
                    $beer_name = $row['beerName'];
                    $description = $row['review'];
                    $images = $row['images'];

                    $overall_rating = $row['overall'];



                    $iddata = $row['id'];

                    $row = mysqli_fetch_array($result2);
                    $ratings = $row['rating'];

                    $count1++;


                    echo "
                    <a href='productdetails.php?rowid=$iddata'>
                     <div class='card1 float-left mr-2 mb-2' style='width: 198.5px;height:80%;'>
                     <img src=$images class='card-img-top'>
                     
                     <h4 style='text-align:center'>$beer_name</h4>
                     $ratings
                     <br>
                     <br>
                     <br>
                     
                     </div> 
                    </a>";
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