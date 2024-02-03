<?php

session_start();
include_once '../db.php';


if (isset($_POST['deleteConfirm'])) {
    $currentUser = $_SESSION['userId'];
    $sqlread  = "DELETE FROM users WHERE userId='$currentUser'";
    $result = $conn->query($sqlread);
    if ($sqlread) {

       

        session_unset();

        session_destroy();

        header("location: ../index.php?accountdeleted");
        exit();
      
    }
}
