<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$dbconn = mysqli_connect($servername,$username,$password,$dbname);

if(isset($_SESSION["current_user"])){}else{header("Location: /apteczka/apteczkaLogowanie.php");
    exit();}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<head>
<title>Domowa Apteczka</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css"> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<style>
body,h1,h3,h5 {font-family: "Poppins"}
body {font-size:16px;}
</style>


</head>
<body>
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:200px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Zamknij Menu</a><br>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>DOMOWA<br>APTECZKA</b></h3>
  </div>
  <div class="w3-bar-block">
  <br><a style="pointer-events: none;" class="w3-button w3-hover-white"><?php echo "Użytkownik: <br>".$_SESSION["current_user"]; ?></a> <br><br>
    <br><a href="wylogowanie.php" onclick="w3_close()" class="w3-button w3-hover-white">Wyloguj się</a> <br><br>
    <a href="apteczkaGlowna.php" onclick="w3_close()" class="w3-button w3-hover-white">strona Główna</a>
    <a href="apteczkaDodaj.php" onclick="w3_close()" class="w3-button w3-hover-white">Dodaj Lek</a>
    <a href="apteczkaLeki.php" onclick="w3_close()" class="w3-button w3-hover-white">Spis Leków</a> 
    <a href="apteczkaZazyte.php" onclick="w3_close()" class="w3-button w3-hover-white">Zażyte Leki</a>
    <a href="apteczkaZutylizowane.php" onclick="w3_close()" class="w3-button w3-hover-white">Zutylizowane</a> 
    <a href="apteczkakoszty.php" onclick="w3_close()" class="w3-button w3-hover-white">Wykres kosztów</a>   
    <a href="apteczkaDokumentacja.php" onclick="w3_close()" class="w3-button w3-hover-white">Dokumentacja</a>   
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Domowa Apteczka</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:20px" id="showcase">
    <h1 class="w3-jumbo"><b>Wybierz, co chcesz zrobić</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Przeterminowane leki:</b></h1>
    <hr class="w3-round">
  </div>

  <!-- Przeterminowane Leki -->
    <?php
        if (!$dbconn){
            die("Connection failed! : ".mysqli_connect_error());
        }

        $sql = "SELECT Leki.Nazwa, DaneLekow.DataWaznosci, DaneLekow.IloscSztuk, DaneLekow.IdOpakowania, DaneLekow.IdLeku, Leki.Cena FROM 
        DaneLekow INNER JOIN Leki ON (DaneLekow.IdLeku = Leki.IdLeku) WHERE DaneLekow.DataWaznosci < CURDATE()";
        $result = mysqli_query($dbconn,$sql);
        if (mysqli_num_rows($result)>0)
        {

            echo '<table id="myTable">
            <tr><th onclick="sortTable(0)">Nazwa Leku</th><th onclick="sortTable(1)">Ilosc</th><th onclick="sortTable(2)">Data Ważności</th><th>Utylizacja</th></tr>' ;


            while($row = mysqli_fetch_assoc($result))
            {
                if( ($row['IloscSztuk']>0)  ) {    
                echo "<tr><td>".$row["Nazwa"]."</td><td>".$row["IloscSztuk"]."</td><td>".$row["DataWaznosci"]."</td>
                <td><a href='utylizacja.php?ajdi=".$row["IdOpakowania"]."&ajdi2=".$row["IdLeku"]."&koszt=".$row["Cena"]."&ile=".$row["IloscSztuk"]."'> Zutylizuj </a></td>
                </tr>";
                
                }
            } 
            echo "</table>";
        }else{
                echo "Brak przeterminowanych leków";
            }
        

        mysqli_close($dbconn);
    ?>

    <!-- Zgodność ilości -->
    <div> <br><br>
    <?php
        if (!$dbconn){
            die("Connection failed! : ".mysqli_connect_error());
        }

        $sql2 = "SELECT SUM(Poczatek) FROM danelekow";
        $sumPoczatek = mysqli_query($dbconn,$sql2);
        $sql3 = "SELECT SUM(Ilosc) FROM zazycia";
        $sumZazycia = mysqli_query($dbconn,$sql3);
        $sql4 = "SELECT SUM(ilosc) FROM utylizacja";
        $sumUtylizacja = mysqli_query($dbconn,$sql4);
        $sql4 = "SELECT SUM(IloscSztuk) FROM danelekow";
        $sumSprawdz = mysqli_query($dbconn,$sql5);
        if ($sumSprawdz = $sumPoczatek - $sumZazycia - $sumUtylizacja)
        {echo "Baza zgodna";}
        else
        {echo "Brak zgodności bazy";}
    ?>
    </div>

    <!-- Ilość unikalnych leków -->
    <div> <br><br>
    <?php
        if (!$dbconn){
            die("Connection failed! : ".mysqli_connect_error());
        }

        $sql5 = "SELECT COUNT(DISTINCT IdLeku) as uniqe FROM danelekow WHERE IloscSztuk >0";
        $unikalne = mysqli_query($dbconn,$sql5);
        while($unikalne2 = mysqli_fetch_array($unikalne))
        {echo "Ilość unikalnych leków w apteczce: ".$unikalne2["uniqe"] ;}
    ?>
    </div>

<!-- End page content -->
</div>


<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

</script>

</body>
</html>