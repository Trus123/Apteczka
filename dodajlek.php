<!-- plik do dodawania nowych leków do słownika -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>

<body>
<?php

if(isset($_POST['Nazwa']) and $_POST['Nazwa']!="" and $_POST['Cena']) and $_POST['Cena']!="") {
    $Nazwa = $_POST['Nazwa'];
    $Cena = $_POST['Cena'];
    $sql = "INSERT INTO Leki(Nazwa,Cena) VALUES ('$Nazwa','$Cena')";
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if (!$conn)
{
    die("Connection failed! : ".mysqli_connect_error());
}


if(mysqli_query($conn,$sql))
{
    echo "Dopisano!";
    
} else{
    echo "Błąd: ".$sql."<br>".mysqli_error($conn);
}
?>

<h1> DODAJ LEK </h1>
<p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Lek<input type="text" name="Nazwa" autocomplete="off"><?php echo $imErr;?><br>
Cena<input type="number" name="Cena" autocomplete="off"><?php echo $imErr;?><br>
<input type="submit" value="submit">
<input type="reset" value="Nie wpisuj">
</p></form>
<script>history.pushState({}, "", "")</script>

<?php
    if (!$conn){
        die("Connection failed! : ".mysqli_connect_error());
    }

    echo"<table border=1><tr><th>ID</th><th>Nazwa</th></tr>";
    $sql = "SELECT `IdLeku`, `Nazwa` FROM Leki";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo "<tr><td>".$row["IdLeku"]."</td><td>".$row["Nazwa"]."</td></tr>";
        }
    }else{
            echo "brak wyników!";
        }
    
    mysqli_close($conn);
    echo "</table>";
?>
</body>
</html>