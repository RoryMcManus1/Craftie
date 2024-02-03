<?php


include("../db.php");
session_start();
if (isset($_POST['carddetails'])) {
    $user_id = $_SESSION["userId"];
    $nameOnCard = mysqli_real_escape_string($conn, $_POST["nameOnCard"]);
    $cardtype = mysqli_real_escape_string($conn, $_POST["cardtype"]);
    $accountNum = mysqli_real_escape_string($conn, $_POST["accountNum"]);
    $CVC = mysqli_real_escape_string($conn, $_POST["CVC"]);
    $expiry = mysqli_real_escape_string($conn, $_POST["expiry"]);
    $expiry = date('Y-m-d', strtotime($expiry));

    $housenum = mysqli_real_escape_string($conn, $_POST["housenum"]);
    $streetname = mysqli_real_escape_string($conn, $_POST["streetname"]);
    $townorcity = mysqli_real_escape_string($conn, $_POST["townorcity"]);
    $postcode = mysqli_real_escape_string($conn, $_POST["postcode"]);
    $townorcity = mysqli_real_escape_string($conn, $_POST["townorcity"]);
    $country = mysqli_real_escape_string($conn, $_POST["country"]);
    $deliverydate = mysqli_real_escape_string($conn, $_POST["deliverydate"]);
    require_once '../db.php';
    require_once 'functions.php';

    if (emptyInputSignup($user_id, $nameOnCard, $cardtype, $accountNum, $CVC, $expiry) !== false) {
        header("location: ../paymentdetails.php?error=emptyinput");
        exit();
    }
    if (invalidaccountNum($accountNum) !== false) {
        header("location: ../paymentdetails.php?error=accountnum");
        exit();
    }
  
    addCarddetails($conn,$user_id, $nameOnCard, $cardtype, $accountNum, $CVC, $expiry, $isMember);

    adddeliverydetails($conn,$user_id, $housenum, $streetname, $townorcity, $postcode,$country, $deliverydate);
} else {
    header("location: ../account.php");
}
