<?php



//this is the email the user recieves when clicking request button
if (isset($_POST["reset-request"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);


    $url = "http://rmcmanus07.lampt.eeecs.qub.ac.uk/craftie_final_phpFix/phpFiles/createnewpass.php?selector=" . $selector . "&validator=" . bin2hex($token);


    //Expires in 15mins
    $expires = date("U") + 900;



    require("../db.php");

    $userEmail = $_POST['userEmail'];


    $sql = "DELETE FROM pass_reset WHERE reset_email=?;";

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
    mysqli_close($conn);


    require_once('../mailer/PHPMailerAutoload.php');

$mail=  new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->SMTPSecure = 'ssl';
$mail->Host ='smtp.gmail.com';
$mail->Port = '465';
$mail->isHTML();
$mail->Username = "craftiereset@gmail.com";
$mail->Password = "40132363";
$mail->SetFrom("craftiereset@gmail.com");
$mail-> $subject = 'Reset Craftie Password';
$mail->Body = 'We recieved a password reset request. 
The link to reset your password is shown below, if you did not make this request, please ignore this email.<br>
<p>Here is your password reset link</p><br>'.
$url;
$mail->addAddress($userEmail);

$mail->send();



    header("location: ../passwordreset.php?emailsent");


} else {
    header("location: ../account.php");
}
