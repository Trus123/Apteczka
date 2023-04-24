<?php
$user_fullname = $user_email = $user_password = "";

function chgw($dane){
    $dane = trim($dane);
    $dane=stripslashes($dane);
    $dane=htmlspecialchars($dane);
    return $dane;
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = chgw($_POST["email"]);
    $name = chgw($_POST["Login"]);
    $Upassword = chgw($_POST["Password"]);
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$dbconn = mysqli_connect($servername,$username,$password,$dbname);
$user_fullname = mysqli_real_escape_string($dbconn,$name);
$user_email = mysqli_real_escape_string($dbconn,$email);
$user_password = mysqli_real_escape_string($dbconn,$Upassword);

$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

if (mysqli_query($dbconn, "INSERT INTO uzytkownicy(UserFullname,UserPasswordhash, UserEmail )
    VALUES ('$user_fullname','$user_password_hash','$user_email')"))
    {header("Location: /apteczka/apteczkaLogowanie2.php");
        exit();}
    else {
        header("Location: /apteczka/apteczkaLogowanie3.php");
        exit();}
    ?>

