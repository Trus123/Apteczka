<?php
session_start();

$lekid=$lekil=$uzytkownik="";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $idleku = $_POST["IDleku"];
    $idopakowanie = $_POST["IDopakowania"];
    $lekil = $_POST["ilosc"];
    $uzytkownik = $_SESSION["current_id"];
    $kosztZazycia = $_POST["kosztZaz"];
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$dbconn = mysqli_connect($servername,$username,$password,$dbname);

$dataZazycia = date("Y/m/d");

$kosztZazycia *= $lekil;

$sql = "INSERT INTO Zazycia (IdLeku, IdOpakowania, IdUser,Ilosc,DataZazycia,KosztZazycia)
        VALUES ('$idleku','$idopakowanie','$uzytkownik','$lekil','$dataZazycia','$kosztZazycia')";

$sql2 = "SELECT `IloscSztuk` FROM `DaneLekow` WHERE `IdOpakowania` =" .$idopakowanie; 
$result2 = mysqli_query($dbconn,$sql2);

if (mysqli_num_rows($result2)>0){
    while($row2 = mysqli_fetch_assoc($result2))
    {
        $zostalo = $row2["IloscSztuk"]-$lekil;
    }
}

$sql3 = "UPDATE `DaneLekow` SET `IloscSztuk`=".$zostalo." WHERE `IdOpakowania` = ".$idopakowanie;

if(mysqli_query($dbconn,$sql3) and mysqli_query($dbconn,$sql))
    {
        $_SESSION['zazycie'] = "Zażyte";
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