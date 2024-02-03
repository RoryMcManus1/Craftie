<?php


include("../db.php");

if (isset($_POST['membersubmit'])) {
    $username = mysqli_real_escape_string($conn, $_POST["memberusername"]);
    $password = mysqli_real_escape_string($conn, $_POST["memberpassword"]);
    
    require_once '../db.php';
    require_once 'functions.php';


    if (emptyInputLogin($username, $password) !== false) {
        header("location: ../account.php?error=emptyinput1");
        exit();
    }
    if (invalidusername($username) !== false) {
        header("location: ../account.php?error=incorrectusername");
        exit();
    }
    loginUser($conn,$username,$password);
} else {
    header("location: ../index.php");
}
