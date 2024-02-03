<?php


include("../db.php");

if (isset($_POST['submitadminedit'])) {
    $beername = mysqli_real_escape_string($conn, $_POST["beername"]);
    $style = mysqli_real_escape_string($conn, $_POST["style"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);
    $ABV = mysqli_real_escape_string($conn, $_POST["ABV"]);
    $overall = mysqli_real_escape_string($conn, $_POST["overall"]);
    $taste = mysqli_real_escape_string($conn, $_POST["taste"]);
    $appearance = mysqli_real_escape_string($conn, $_POST["appearance"]);
    $aroma = mysqli_real_escape_string($conn, $_POST["aroma"]);
    $images = mysqli_real_escape_string($conn, $_POST["images"]);
    $itemid = mysqli_real_escape_string($conn, $_POST["iddata"]);



    require_once '../db.php';
    require_once 'functions.php';


    // if (emptyInputSignup($name, $username, $email, $password, $passwordrpt) !== false) {
    //     header("location: ../profile.php?error=emptyinput");
    //     exit();
    // }
    // if (invalidusername($username) !== false) {
    //     header("location: ../profile.php?error=invalidusername");
    //     exit();
    // }
    // if (invalidemail($email) !== false) {
    //     header("location: ../profile.php?error=invalidemail");
    //     exit();
    // }
    // if (passwordmatch($password, $passwordrpt) !== false) {
    //     header("location: ../profile.php?error=passwordmismatch");
    //     exit();
    // }
    // if (usernametaken($conn, $username,$email) !== false) {
    //     header("location: ../profile.php?error=usernametaken");
    //     exit();
    // }

    adminupdate($conn, $beername, $style, $ABV, $desc, $overall, $taste, $appearance, $aroma, $images, $itemid);
}
if (isset($_POST['adminremove'])) {

    require_once '../db.php';
    require_once 'functions.php';

    $itemid = mysqli_real_escape_string($conn, $_POST["iddata"]);
    adminremove($conn, $itemid);
}
