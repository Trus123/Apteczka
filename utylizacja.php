<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$dbconn = mysqli_connect($servername,$username,$password,$dbname);

$idleku = $_GET['ajdi2'];
$idopakowanie = $_GET['ajdi'];
$lekil = $_GET['ile'];
$uzytkownik = $_SESSION["current_id"];
$kosztUty = $_GET['koszt'];

$dataUtylizacji = date("Y/m/d");
$kosztUty *= $lekil;
$reset = 0;

$sql = "INSERT INTO Utylizacja (idLeku, idOpakowania,ilosc,dataUtylizacji,kosztUtylizacji)
        VALUES ('$idleku','$idopakowanie','$lekil','$dataUtylizacji','$kosztUty')";

$sql3 = "UPDATE `DaneLekow` SET `IloscSztuk`=".$reset." WHERE `IdOpakowania` = ".$idopakowanie;

if(mysqli_query($dbconn,$sql3) and mysqli_query($dbconn,$sql))
    {
        $_SESSION['zazycie'] = "Zutylizowano";
        header("Location: /apteczka/apteczkaLeki2.php");
        exit();
    } 
    else 
    {
        $_SESSION['zazycie'] = "Błąd";
        header("Location: /apteczka/apteczkaLeki2.php");
        exit();
    }

?>