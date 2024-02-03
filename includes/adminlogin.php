<?php


include("../db.php");

if (isset($_POST['adminsubmit1'])) {
    $adminusername = mysqli_real_escape_string($conn, $_POST["adminusername1"]);
    $adminpassword = mysqli_real_escape_string($conn, $_POST["adminpassword1"]);

    require_once '../db.php';
    require_once 'functions.php';

    if (nonadmin($conn, $adminusername, $isAdmin) == false) {
        header("location: ../adminloginpage.php?error=nonadmin");
        exit();
    }
    if (emptyInputLogin($adminusername, $adminpassword) !== false) {
        header("location: ../adminloginpage.php?error=emptyinputadmin");
        exit();
    }
    if (invalidusername($adminusername) !== false) {
        header("location: ../adminloginpage.php?error=incorrectusernameadmin");
        exit();
    }
    loginAdmin($conn, $adminusername, $adminpassword);


    
    
} else {
    header("location: ../adminloginpage.php?error=skipped");
}
