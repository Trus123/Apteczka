<?php

$lekname=$lekilosc=$datawazn="";

function chgw($dane){
    $dane = trim($dane);
    $dane=stripslashes($dane);
    $dane=htmlspecialchars($dane);
    return $dane;
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $lekname = chgw($_POST["lek"]);
    $lekilosc = chgw($_POST["ilosc"]);
    $datawazn = chgw($_POST["data"]);
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$dbconn = mysqli_connect($servername,$username,$password,$dbname);
$dataZakup = date("Y-m-d");

$sql1 = "SELECT `Cena` FROM `leki` WHERE `IdLeku` =" .$lekname; 
$result = mysqli_query($dbconn,$sql1);

if (mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result))
    {
        $kosztZakupu = $row["Cena"]*$lekilosc;
    }
}

  

$sql2 = "INSERT INTO DaneLekow (IdLeku, DataWaznosci, IloscSztuk,DataZakupu,KosztOpakowania,Poczatek)
        VALUES ('$lekname','$datawazn','$lekilosc','$dataZakup','$kosztZakupu','$lekilosc')";

if(mysqli_query($dbconn,$sql2)){
        $_SESSION['status'] = "dopisane";
        header("Location: /apteczka/apteczkaDodaj2.php");
        exit();
    } 
    else {
        $_SESSION['status'] = "niedopisane";
        header("Location: /apteczka/apteczkaDodaj2.php");
        exit();
    }
?>
