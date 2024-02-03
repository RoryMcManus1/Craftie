
<?php
if (isset($_POST["newsletter"])) {
    


session_start();

$url1 = "http://rmcmanus07.lampt.eeecs.qub.ac.uk/craftie_final_phpFix/phpFiles/promotions.php";

include("../db.php");

$userEmail = $_POST['email'];
$currentUser = $_SESSION['userId'];
$newsletter = "yes";


$sql1 = "UPDATE users
SET newsletter='yes' WHERE userId ='$currentUser';";
 
 $result = $conn->query($sql1);

require_once('../mailer/PHPMailerAutoload.php');

$mail=  new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->SMTPSecure = 'ssl';
$mail->Host ='smtp.gmail.com';
$mail->Port = '465';
$mail->isHTML();
$mail->Username = "";
$mail->Password = "";
$mail->SetFrom("craftiereset@gmail.com");
$mail-> $subject = 'Monthly newsletter';
$mail->Body = 'This is the Craftie Monthly Newsletter bringing you news of the latest and greatest in craft beer news and products,
follow the links to find out more!'.
$url1;
$mail->addAddress($userEmail);

$mail->send();



header("location: ../newsletter.php?error=noneNLS");


} else {
header("location: ../account.php");
}