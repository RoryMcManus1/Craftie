<?php


include("../db.php");

if (isset($_POST['submitadminadd'])) {
    $beername = mysqli_real_escape_string($conn, $_POST["beername"]);
    $style = mysqli_real_escape_string($conn, $_POST["style"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);
    $ABV = mysqli_real_escape_string($conn, $_POST["ABV"]);
    $overall = mysqli_real_escape_string($conn, $_POST["overall"]);
    $taste = mysqli_real_escape_string($conn, $_POST["taste"]);
    $appearance = mysqli_real_escape_string($conn, $_POST["appearance"]);
    $aroma = mysqli_real_escape_string($conn, $_POST["aroma"]);
    $images = mysqli_real_escape_string($conn, $_POST["images"]);
    



    require_once '../db.php';
    require_once 'functions.php';


    adminadd($conn, $beername, $style, $ABV, $desc, $overall, $taste, $appearance, $aroma, $images);
}

