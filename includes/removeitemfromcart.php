<?php

session_start();
include_once '../db.php';
$currentUser = $_SESSION['userId'];


if (isset($_POST['removeitemfromcart'])) {

    $crateid = mysqli_real_escape_string($conn, $_POST["crateid"]);


    $sqlread  = "DELETE FROM crates WHERE crate_id=$crateid";
    $result = $conn->query($sqlread);
    if ($sqlread) {

        header("location: ../cart.php");
        exit();
    }
}
if (isset($_POST['confirmorder'])) {
    $sqlcart = "DELETE
    FROM crates WHERE user_id = $currentUser;";
    $resultcart = $conn->query($sqlcart);

    if ($resultcart) {

        header("location: ../cart.php?error=noneOP");
        exit();
    }
}
