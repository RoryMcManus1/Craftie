<?php

include("../db.php");
session_start();


$sqlread = "SELECT `allbeers`.*, `beerstyles`.`style` FROM `allbeers` LEFT JOIN `beerstyles` ON `allbeers`.`beerstyle` = `beerstyles`.`style_id`LEFT JOIN `ratings` ON `allbeers`.`overall` = `ratings`.`rating_id`;";
$result = $conn->query($sqlread);




if (!$result) {
    echo $conn->error;
}
if (!isset($_COOKIE["ageV"])) {
    header("location: ../ageGate.php");
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/styleallproducts.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>


    <div class="container">


    <div class="navbar">
                <div class="nav">
                    <a href="../index.php"> <img src="../img/craftie_logoFinal.png" width="125px"></a>
                </div>
                <nav>
                    <ul id='menuItems'>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../promotions.php">Shop</a></li>
                        <li><a href="../allproducts.php">Products</a></li>
                        <li><a href="../about.php">About</a></li>
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
                                echo "<li><a href='../profile.php'>Profile</a></li>";
                                echo " <li><a href='../includes/logout.php'>Log Out</a></li>";
                                echo "<a href='../cart.php'><img src='../img/cart.png' width='30px' height='30px'></a>";
                            }else{
                                echo "<li><a href='../profile.php'>Profile</a></li>";
                                echo "<li><a href='../membershipinfo.php'>Membership</a></li>";
                                echo " <li><a href='../includes/logout.php'>Log Out</a></li>";
                            }
                           
                        } else {

                            echo " <li><a href='../account.php'>Sign Up/Sign In</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
                
                <img src="../img/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>

    </div>


    <h2 class="title">All Products</h2>

    <div class="small_container">

        <div class="row row-2">
        <form action="../includes/filter.php" method="post">
        <button type="submit" name="azsort" class="btn">Sort by A-Z </button>
            <button type="submit" name="stylesort" class="btn">Sort by Styles </button>
            <button type="submit" name="ratingsort" class="btn">Sort by Rating </button>
            <button type="submit" name="abvsort" class="btn">Sort by ABV% </button>
           
            </form>
            <?php
                        //if the current user is loggedd in
                        if (isset($_SESSION["userId"])) {
                            $currentUser = $_SESSION['userId'];
                            $sqlread = "SELECT * FROM users WHERE userId = $currentUser";
                            $result = $conn->query($sqlread);

                            $row = mysqli_fetch_assoc($result);
                    
                            $isAdmin = $row['isAdmin'];
                           
                            if ($isAdmin == "yes") {
                                echo "<a href='../adminadd.php' class='btn'>Add Product</a>";
                            }
                        } 
                        ?>

        </div>
        <div class="row">
            <?php

            $results_per_page = 16;
            $sql = 'SELECT `allbeers`.*, `beerstyles`.`style` FROM `allbeers` LEFT JOIN `beerstyles` ON `allbeers`.`beerstyle` = `beerstyles`.`style_id`';
            $result = $conn->query($sqlread);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $this_page_first_result = ($page - 1) * $results_per_page;
            $sql = 'SELECT `allbeers`.*, `beerstyles`.`style`, `ratings`.`rating`
            FROM `allbeers` 
                LEFT JOIN `beerstyles` ON `allbeers`.`beerstyle` = `beerstyles`.`style_id` 
                LEFT JOIN `ratings` ON `allbeers`.`overall` = `ratings`.`rating_id` ORDER BY beerABV DESC LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
            $result = $conn->query($sql);
            while ($row = mysqli_fetch_array($result)) {
                $iddata = $row['id'];
                $overall_rating = $row['overall'];
                $beer_name = $row['beerName'];
                $images = $row['images'];
                $ABV =  $row['beerABV'];
                $styles = $row['style'];
                $ratings = $row['rating'];
                echo "
                    <a href='../productdetails.php?rowid=$iddata'>
                    
                     <div class='card1 float-left mr-2 mb-2' style='width: 198.5px;max-height:80%;'>
                     <img src=$images class='card-img-top'>
                     
                     <h4>$beer_name <br>  $ABV%</h4>
                    
                   <h4>$styles</h4>
                   $ratings
                     </div> 
                    </a>";
            }
            $Previous = $page - 1;
            $Next = $page + 1;
            ?>
        </div>
        <div class="row">
            <span class="page-btn">
                <a href="abvsort.php?page=<?= $Previous; ?>" aria-label="Previous">
                    <span aria-hidden="true">Previous &laquo; </span>
                </a>
                <?php
                for ($i = 1; $i <= $page; $i++) : ?>
                    <a class="page-btn" href="abvsort.php?page=<?= $i; ?>"><?= $i; ?></a>
                <?php endfor; ?>

                <a class="page-btn" href="abvsort.php?page=<?= $Next; ?>" aria-label="Next">
                    <span aria-hidden="true"> Next &raquo;</span>
                </a>
                 </span>
        </div>
    </div>
    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <a href="../index.php"> <img src="../img/craftie_logoFinal.png"> </a>
                </div>
                <div class="footer-col-2">
                    <ul>
                        <a href="../about.php">
                            <li>About Us</li>
                        </a>
                        <a href="../promotions.php">
                            <li>Shop</li>
                        </a>
                        <a href="../account.php">
                            <li>Account</li>
                        </a>
                    </ul>
                </div>
                <div class="footer-col-3">
                    <p>Craftie Copyright 2021</p>
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