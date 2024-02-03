<?php


if (isset($_POST['reset-pass-submit'])) {

 
  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $password = $_POST['password'];
  $passwordRepeat = $_POST['password-rpt'];

  if (empty($password) || empty($passwordRepeat)) {
    header("Location: ../account.php?newpwd=empty");
    exit();
  } else if ($password != $passwordRepeat) {
    header("Location: ../account.php?newpwd=pwdnotsame");
    exit();
  }


  $currentDate = date('U');

  
  require '../db.php';


  $sql = "SELECT * FROM pass_reset WHERE reset_selector=? AND reset_expires >= $currentDate";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $selector);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);


    if (!$row = mysqli_fetch_assoc($result)) {
      echo "tokens do not match.";
      echo $validator;
      exit();
    } else {

    
      $tokenBin = hex2bin($validator);


      $tokenCheck = password_verify($tokenBin, $row['reset_token']);

     
      if ($tokenCheck === false) {
        echo "error1!";
      } elseif ($tokenCheck === true) {

     
        $tokenEmail = $row['reset_email'];

 
        $sql = "SELECT * FROM users WHERE userEmail=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "error2!";
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if (!$row = mysqli_fetch_assoc($result)) {
            echo "3!";
            exit();
          } else {


            $sql = "UPDATE users SET userPwd=? WHERE userEmail=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "4!";
              exit();
            } else {
              $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
              mysqli_stmt_execute($stmt);

              $sql = "DELETE FROM pass_reset WHERE reset_email=?";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "5!";
                exit();
              } else {
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);
                header("Location: ../account.php?newpwd=passwordupdated");
              }
            }
          }
        }
      }
    }
  }
} else {
  header("Location: ../account.php");
  exit();
}
