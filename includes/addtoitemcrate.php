<?php


include("../db.php");

if (isset($_POST['addtocart'])) {
    $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);
    $userid = mysqli_real_escape_string($conn, $_POST["userid"]);
    $itemid = mysqli_real_escape_string($conn, $_POST["itemid"]);
  
    require_once '../db.php';
    require_once 'functions.php';


    addtocrate($conn,$userid, $itemid, $quantity);
}


