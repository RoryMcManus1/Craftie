<?php
include("../db.php");

session_start();

function emptyInputSignup($name, $username, $email, $password, $passwordrpt)
{
    $result = false;
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($passwordrpt)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidusername($username)
{
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidemail($email)
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordmatch($password, $passwordrpt)
{
    $result = false;
    if ($password !== $passwordrpt) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function usernametaken($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE userUsername = ? OR userEmail =?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfail1");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}


function createUser($conn, $name, $username, $email, $password, $isMem, $isAdmin,$newsletter)
{
    $sql = "INSERT INTO users (userName,userUsername,userEmail,userPwd,isMember, isAdmin, newsletter) VALUES (?,?,?,?,?,?,?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfail2");
        exit();
    }

    $hashedpass = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $username, $email, $hashedpass, $isMem, $isAdmin, $newsletter);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../account.php?error=none");
    exit();
}

function emptyInputlogin($username, $password)
{
    $result = false;
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $password)
{
    $usernametaken = usernametaken($conn, $username, $username);

    if ($usernametaken === false) {
        header("location: ../account.php?error=invalidusername1");
        exit();
    }

    $passwordHashed = $usernametaken["userPwd"];
    $checkpwd = password_verify($password, $passwordHashed);

    if ($checkpwd === false) {
        header("location: ../account.php?error=incorrectpass");
        exit();
    } else if ($checkpwd === true) {
        session_start();

        $_SESSION["userId"] = $usernametaken["userId"];
        $_SESSION["userUsername"] = $usernametaken["userUsername"];
        header("location: ../index.php");
        exit();
    }
}


function updateUser($conn, $name, $username, $email, $password)
{
    if (isset($_SESSION["userId"])) {
        $hashedpass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users
     SET userName= '$name', userUsername='$username', userEmail = '$email', userPwd='$hashedpass' WHERE userId = '$_SESSION[userId]';";


        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../profile.php?error=stmtfail3");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $email, $hashedpass);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        header("location: ../profile.php?error=none");
        exit();
    } else {
        header("location: ../profile.php");
        exit();
    }
}
function invalidaccountNum($accountNum)
{
    $result = false;
    if (!preg_match("/^[0-9]*$/", $accountNum) && strlen($accountNum) == 16) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidaCVC($CVC)
{
    $result = false;
    if (!preg_match("/^[0-9]*$/", $CVC) && strlen($CVC) == 3) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function userExists($conn, $user_id)
{
    $sql = "SELECT * FROM users WHERE userId =?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfails");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function addCarddetails($conn, $user_id, $nameOnCard, $cardtype, $accountNum, $CVC, $expiry, $isMember)
{
    $hashedaccountNum = password_hash($accountNum, PASSWORD_DEFAULT);
    $hashedCVC = password_hash($CVC, PASSWORD_DEFAULT);
    $sql = "INSERT INTO payments (user_id, nameOnCard, cardtype, accountNum, CVC, expiry) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfail2");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssssss", $user_id, $nameOnCard, $cardtype, $hashedaccountNum, $hashedCVC, $expiry);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);






    
    $sql1 = "UPDATE users
    SET isMember= 'yes' WHERE userId ='$user_id';";
    $stmt1 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt1, $sql1)) {
        header("location: ../paymentdetails.php?error=stmtfailupdateismember");
        exit();
    }

    mysqli_stmt_bind_param($stmt1, "s", $isMember);
    mysqli_stmt_execute($stmt1);

    mysqli_stmt_close($stmt1);
}
function nonadmin($conn, $adminusername, $isAdmin)
{
    $sqlread = "SELECT * FROM users WHERE userUsername = '$adminusername'";

    $result = $conn->query($sqlread);
    $admincheck = false;

    if ($row = mysqli_fetch_assoc($result)) {
        $isAdmin = $row['isAdmin'];
        echo "$isAdmin";

        if ($isAdmin === "yes") {
            $admincheck = true;
            return  $admincheck;
        } else {
            return  $admincheck;
        }
    }
}
function loginAdmin($conn, $adminusername, $adminpassword)
{
    $usernametaken = usernametaken($conn, $adminusername, $adminusername);

    if ($usernametaken === false) {
        header("location: ../account.php?error=invalidAdminUsername1");
        exit();
    }

    $passwordHashed = $usernametaken["userPwd"];
    $checkpwd = password_verify($adminpassword, $passwordHashed);

    if ($checkpwd === false) {
        header("location: ../adminloginpage.php?error=incorrectAdminpass");
        exit();
    } else if ($checkpwd === true) {
        session_start();

        $_SESSION["userId"] = $usernametaken["userId"];
        $_SESSION["userUsername"] = $usernametaken["userUsername"];
        header("location: ../index.php");
        exit();
    }
}

function adminupdate($conn, $beername, $style, $ABV, $desc, $overall, $taste, $appearance, $aroma, $images, $itemid)
{


    $sql = "UPDATE allbeers
     SET beerName= '$beername', beerstyle='$style', beerABV = '$ABV', review='$desc', overall = '$overall', taste = '$taste', appearance = '$appearance', aroma = '$aroma', images = '$images' WHERE id = '$itemid';";


    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=stmtfailedit");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "siisiiiis",  $beername, $style, $ABV, $desc, $overall, $taste, $appearance, $aroma, $images);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../allproducts.php?editsaved");
    exit();
}
function adminremove($conn, $itemid)
{
    $sqlread  = "DELETE FROM allbeers WHERE id=$itemid";
    $result = $conn->query($sqlread);
    header("location: ../allproducts.php?itemremoved");
    exit();
}

function adminadd($conn, $beername, $style, $ABV, $desc, $overall, $taste, $appearance, $aroma, $images)
{
    $sql = "INSERT INTO allbeers(beerName, beerstyle, beerABV, review, overall,taste,appearance,aroma,images )VALUES('$beername', '$style', '$ABV', '$desc', '$overall', '$taste', '$appearance', '$aroma', '$images');";


    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=stmtfailadd");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siisiiiis",  $beername, $style, $ABV, $desc, $overall, $taste, $appearance, $aroma, $images);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../allproducts.php?itemadded");
    exit();
}

function addtocrate($conn, $userid, $itemid, $quantity)
{

    $sql = "INSERT INTO crates(user_id,item_id,quantity) VALUES (?,?,?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailcrate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iii", $userid, $itemid, $quantity);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../allproducts.php?error=addedTC");
   
}
function adddeliverydetails($conn, $user_id, $housenum, $streetname, $townorcity, $postcode, $country, $deliverydate)
{
    $sql = "INSERT INTO addresses(user_id, housenum, streetname, town_city, postcode, country, deliverydate) VALUES (?,?,?,?,?,?,?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfaildeliv");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "isssssi", $user_id, $housenum, $streetname, $townorcity, $postcode, $country, $deliverydate);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../account.php?detailsadded");
    exit();
}
function wishlist($conn, $userid, $itemid)
{

    $sql = "INSERT INTO wishlist(user_id,item_id) VALUES (?,?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailcrate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $userid, $itemid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../wishlist.php?addedWL");
    exit();
}
