<?php

// First we check if the form was submitted.
if (isset($_POST['stylesort'])) {
  header("location: ../allproductssorting.php/stylesort.php");
  exit();
}

if (isset($_POST['abvsort'])) {

  header("location: ../allproductssorting.php/abvsort.php");
  exit();
}

if (isset($_POST['ratingsort'])) {

  header("location: ../allproductssorting.php/ratingsort.php");
  exit();
}
if (isset($_POST['azsort'])) {

  header("location: ../allproducts.php");
  exit();
}
