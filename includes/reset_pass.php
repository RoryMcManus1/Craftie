<?php


//this is what happens if the user selects "forgot password//
if (isset($_POST["reset-request"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);


    $url = "http://rmcmanus07.lampt.eeecs.qub.ac.uk/craftie_final_phpFix/phpFiles/reset-pass.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 900;



    require("../db.php");

    $userEmail = $_POST['userEmail'];


    $sql = "DELETE FROM pass_reset WHERE reset_email=?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error1";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s",  $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pass_reset (reset_email, reset_selector , reset_token , reset_expires) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error1";
        exit();
    } else {

        $hashedtoken= password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss",  $userEmail, $selector, $hashedtoken, $expires);
        mysqli_stmt_execute($stmt);
    }


    mysqli_stmt_close($stmt);

 
   $to = $userEmail;
    $subject = 'Reset Craftie Password';
    $message = '<p> We recieved a password reset request. 
    The link to reset your password is shown below, if you did not make this request, please ignore this email.</p>';
    $message .= '<p>Here is your password reset link</p><br>';
    $message .= '<a href="' . $url . '">' . $url .  '</a></p>';


    $headers = "From: Craftie.com <rorymcmanus272@gmail.com>\r\n";
    $headers = "Reply-to:rorymcmanus272@gmail.com\r\n";
    $headers = "Content-Type:text/html\r\n";


    mail($to,$subject, $message,$headers);

    header("location: resetPass.php");


} else {
    header("location: ../account.php");
}
