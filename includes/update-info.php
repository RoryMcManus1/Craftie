<?php


include("../db.php");

if (isset($_POST['submit1'])) {
    $name = mysqli_real_escape_string($conn,$_POST["name1"]);
    $username = mysqli_real_escape_string($conn,$_POST["username1"]);
    $email = mysqli_real_escape_string($conn,$_POST["email1"]);
    $password = mysqli_real_escape_string($conn,$_POST["password1"]);
    $passwordrpt = mysqli_real_escape_string($conn,$_POST["password-rpt1"]);


    require_once '../db.php';
    require_once 'functions.php';


    if (emptyInputSignup($name, $username, $email, $password, $passwordrpt) !== false) {
        header("location: ../profile.php?error=emptyinput");
        exit();
    }
    if (invalidusername($username) !== false) {
        header("location: ../profile.php?error=invalidusername");
        exit();
    }
    if (invalidemail($email) !== false) {
        header("location: ../profile.php?error=invalidemail");
        exit();
    }
    if (passwordmatch($password, $passwordrpt) !== false) {
        header("location: ../profile.php?error=passwordmismatch");
        exit();
    }
    if (usernametaken($conn, $username,$email) !== false) {
        header("location: ../profile.php?error=usernametaken");
        exit();
    }

    updateUser($conn, $name, $username, $email, $password);
    

}
if (isset($_POST['unsubscribemember'])) {
    include("db.php");

session_start();
    $currentUser = $_SESSION['userId'];
    $sql1 = "UPDATE users
    SET isMember='no' WHERE userId ='$currentUser';";
     $result = $conn->query($sql1);
     header("location: ../index.php?memRemoved");
     exit();

}
if (isset($_POST['unsubscribenewsletter'])) {
    include("db.php");
    

session_start();
    $currentUser = $_SESSION['userId'];
    $sql1 = "UPDATE users
    SET newsletter='no' WHERE userId ='$currentUser';";
     $result = $conn->query($sql1);
     header("location: ../index.php?NLRemoved");
     exit();

}


 