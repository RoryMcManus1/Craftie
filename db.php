<?php
   $passw = "";
       
   $username1 = "";

   $db = "";

   $host = "";


    $conn = new mysqli($host, $username1, $passw, $db);

    if($conn->connect_error){
        echo "not connected".$conn->connect_error;
    }else{
        //echo "connection to DB found.";
    }

    

?>