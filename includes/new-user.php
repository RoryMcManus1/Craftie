<?php


include("../db.php");

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    $username = mysqli_real_escape_string($conn,$_POST["username"]);
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $passwordrpt = mysqli_real_escape_string($conn,$_POST["password-rpt"]);
    $isMem = "no";
    $isAdmin = "no";
    $newsletter = "no";


    require_once '../db.php';
    require_once 'functions.php';


    if (emptyInputSignup($name, $username, $email, $password, $passwordrpt) !== false) {
        header("location: ../account.php?error=emptyinput");
        exit();
    }
    if (invalidusername($username) !== false) {
        header("location: ../account.php?error=invalidusername");
        exit();
    }
    if (invalidemail($email) !== false) {
        header("location: ../account.php?error=invalidemail");
        exit();
    }
    if (passwordmatch($password, $passwordrpt) !== false) {
        header("location: ../account.php?error=passwordmismatch");
        exit();
    }
    if (usernametaken($conn, $username,$email) !== false) {
        header("location: ../account.php?error=usernametaken");
        exit();
    }


    createUser($conn, $name,$username, $email, $password, $isMem, $isAdmin,$newsletter);
} else {
    header("location: ../account.php");
}
