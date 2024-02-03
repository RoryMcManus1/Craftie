<?php
include("db.php");
session_start();
$itemid = $conn->real_escape_string($_GET["rowid"]);



$sqlread = "SELECT * FROM allbeers WHERE id='$itemid' ";
$result = $conn->query($sqlread);
//-------------------------taste rating ---------------------------------------------//
$overallrate = "SELECT `allbeers`.*, `ratings`.`rating`
FROM `allbeers` 
	LEFT JOIN `ratings` ON `allbeers`.`overall` = `ratings`.`rating_id` WHERE id='$itemid' ";
$resultoverall = $conn->query($overallrate);
//-------------------------taste rating ---------------------------------------------//
$tasterate = "SELECT `allbeers`.*, `ratings`.`rating`
FROM `allbeers` 
	LEFT JOIN `ratings` ON `allbeers`.`taste` = `ratings`.`rating_id` WHERE id='$itemid' ";
$resulttaste = $conn->query($tasterate);
//-------------------------appearance rating ---------------------------------------------//
$appearancerate = "SELECT `allbeers`.*, `ratings`.`rating`
FROM `allbeers` 
	LEFT JOIN `ratings` ON `allbeers`.`appearance` = `ratings`.`rating_id` WHERE id='$itemid' ";
$resultappearance = $conn->query($appearancerate);
//-------------------------aroma rating ---------------------------------------------//
$aromarate = "SELECT `allbeers`.*, `ratings`.`rating`
FROM `allbeers` 
	LEFT JOIN `ratings` ON `allbeers`.`aroma` = `ratings`.`rating_id` WHERE id='$itemid' ";
$resultaroma = $conn->query($aromarate);


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
    <title>Product Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/productdetailstyle.css">
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
            <div class='row'>
                <div class='col-2'>

                    <?php
                    $count = 0;

                    while ($row = $result->fetch_assoc()) {
                        $beer_name = $row['beerName'];
                        $images = $row["images"];
                        $description = $row['review'];
                        $description = substr($description, 0, 150);
                        $tasterating = $row['taste'];

                        $row1 = mysqli_fetch_array($resultoverall);
                        $overallrating = $row1['rating'];

                        $row2 = mysqli_fetch_array($resulttaste);
                        $tatserating = $row2['rating'];


                        $row3 = mysqli_fetch_array($resultappearance);
                        $appearancerating = $row3['rating'];


                        $row4 = mysqli_fetch_array($resultaroma);
                        $aromarating = $row4['rating'];




                        echo "
                        
                            <img src=$images style=max-height:350px>
                        </div>
                        <div class='col-2'>
                            <h1>$beer_name</h1>
                          "

                    ?>

                    <?php
                        //if the current user is loggedd in
                        if (isset($_SESSION["userId"])) {
                            $currentUser = $_SESSION['userId'];
                            $sqlread = "SELECT * FROM users WHERE userId = $currentUser";
                            $result = $conn->query($sqlread);

                            $row = mysqli_fetch_assoc($result);
                            $name = $row['userName'];
                            $isAdmin = $row['isAdmin'];
                            $ismember = $row['isMember'];

                            if ($ismember == "yes") {
                                $currentUser = $_SESSION['userId'];
                                echo "
                                <form action='includes/addtoitemcrate.php' method= post>
                                <select name='quantity'>
                                <option value=''>Select Amount</option>
                                <option value='1'>Single Beer (1)</option>
                                <option value='3'>Half Crate (3)</option>
                                <option value='6'>Half Crate (6)</option>
                                <option value='12'>Half Crate (12)</option>
                                <option value='24'>Full Crate (24)</option>
                            </select>
                            <br>
                         
                            <input type='hidden' name='userid' value='$currentUser'>
                            <input type='hidden' name='itemid' value='$itemid'>
                            <input type='hidden' name='beername' value='$beer_name'>

                            <button type='submit' name='addtocart' class='btn'>Add to crate </button>
                            <a href='cart.php' class='btn'>View Crate </a>
                            </form>
                            
                            <form action='includes/addtowishlist.php' method= post>
                            <input type='hidden' name='userid' value='$currentUser'>
                            <input type='hidden' name='itemid' value='$itemid'>
                            <input type='hidden' name='beername' value='$beer_name'>

                            
                            <button type='submit' name='wishlist' class='btn'>Add to WishList </button>
                            </form>";
                            } else if ($ismember === "no") {
                                echo "<a href='membershipinfo.php' class='btn'>Become A Member</a>";
                            }
                            if ($isAdmin == "yes") {
                                $sql = "SELECT * FROM allbeers WHERE id ='$itemid'";
                                $result = $conn->query($sql);

                                while ($row = mysqli_fetch_array($result)) {
                                    $iddata = $row['id'];
                                }
                                echo " 
                                <a href='admineditpage.php?rowid=$iddata'>
                                <button type='submit' class='btn'>Edit Product</button>
                                </a>
                                ";
                            }
                        } else {
                            echo "<a href='account.php' class='btn'>Sign In/Sign Up</a>";
                        }


                        echo " <h5 style='text-align:center;'>Product Ratings</h5>

                        
                        <div class='rating2'>
                        <h6 class='h6'> Overall</h6>  $overallrating
                        </div>
                        <h6 class='h6'> Taste</h6>
                        <div class='rating2'>
                        $tatserating
                        </div>
                        <h6 class='h6'> Aroma</h6>
                        <div class='rating2'>
                        $aromarating
                        </div>
                        <h6 class='h6'> Appearance</h6>
                        <div class='rating2'>
                        $appearancerating
                        </div>
                            <h3 class='title'>Product Details</h3>
                           
                            <small>$description...</small>
                            
                       
                           
                              ";
                    }



                    ?>
                </div>
            </div>
        </div>

    </div>

    <h2 class='title'>You May Also Like</h2>
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
                     <div class='card1 float-left mr-2 mb-2' style='width: 198.5px;max-height:80%;'>
                     <img src=$images class='card-img-top'>
                     
                     <h4>$beer_name</h4>
                     $ratings
                     
                     
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