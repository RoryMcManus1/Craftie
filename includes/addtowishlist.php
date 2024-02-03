<?php

include("../db.php");
if (isset($_POST['wishlist'])) {

  $userid = mysqli_real_escape_string($conn, $_POST["userid"]);
  $itemid = mysqli_real_escape_string($conn, $_POST["itemid"]);

  require_once '../db.php';
  require_once 'functions.php';


  wishlist($conn, $userid, $itemid);
}
if (isset($_POST['WLremove'])) {
  $userid = mysqli_real_escape_string($conn, $_POST["userid"]);
  $itemid = mysqli_real_escape_string($conn, $_POST["itemid"]);
  $wishlistid = mysqli_real_escape_string($conn, $_POST["wishlistid"]);

  $sqlread  = "DELETE FROM wishlist WHERE wishlist_id = $wishlistid AND item_id=$itemid";
  $result = $conn->query($sqlread);
  
  header("location: ../wishlist.php?removed");
    exit();
}
