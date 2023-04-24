<?php
session_start();
?>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$dbconn = mysqli_connect($servername,$username,$password,$dbname);
$user_password = mysqli_real_escape_string($dbconn,$_POST["Password"]);
$user_login = mysqli_real_escape_string($dbconn,$_POST["login"]);
$query = mysqli_query($dbconn, "SELECT * FROM Uzytkownicy WHERE UserFullname = '$user_login'");

if(mysqli_num_rows($query)>0){
    $record = mysqli_fetch_assoc($query);
    $hash = $record["UserPasswordhash"];

    if (password_verify($user_password,$hash))
    {$_SESSION["current_user"] = $record["UserFullname"];
     $_SESSION["current_id"] = $record["IdUser"]; }
}

if(isset($_SESSION["current_user"])){
    /*echo "zalogowany";*/
    header("Location: /apteczka/apteczkaGlowna.php");
        exit();
    } else {
        /*echo "niezalogowany";*/
        header("Location: /apteczka/apteczkaLogowanie3.php");
        exit();
    }
?>
