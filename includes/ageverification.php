<?php


if (isset($_POST["ageVbtn"])) {
    $userAge = $_POST['userAge'];


    if($userAge<18){
        header("location: ../ageGate.php?age=under");
    }else if($userAge>=18){
      setcookie("ageV","$userAge", time() + 1800, "/" );
        header("location: ../index.php");
    }
}


