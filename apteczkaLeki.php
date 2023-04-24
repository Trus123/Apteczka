<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apteczka";

$dbconn = mysqli_connect($servername,$username,$password,$dbname);

$sql = "SELECT * FROM Leki";
$all_categories = mysqli_query($dbconn,$sql);

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
<div class="w3-main" style="margin-left:250px;margin-right:40px;margin-top:50px;">

    <div class="w3-container" style="margin-top:20px" id="showcase">
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Szukaj leku ..." title="Type in a name">
        <hr class="w3-round">
    </div>



    <table id="myTable">
    <tr><th onclick="sortTable(0)">Nazwa Leku</th><th onclick="sortTable(1)">Ilosc</th><th onclick="sortTable(2)">Data Ważności</th><th >Zażywanie</th><th>Utylizacja</th></tr>
    <?php
        if (!$dbconn){
            die("Connection failed! : ".mysqli_connect_error());
        }

        $sql = "SELECT Leki.Nazwa, DaneLekow.DataWaznosci, DaneLekow.IloscSztuk, DaneLekow.IdOpakowania, DaneLekow.IdLeku, Leki.Cena FROM 
        DaneLekow INNER JOIN Leki ON (DaneLekow.IdLeku = Leki.IdLeku)";
        $result = mysqli_query($dbconn,$sql);
        if (mysqli_num_rows($result)>0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                if($row['IloscSztuk']>0){
                echo "<tr><td>".$row["Nazwa"]."</td><td>".$row["IloscSztuk"]."</td><td>".$row["DataWaznosci"]."</td>
                <td><a href='apteczkaZazycie.php?ajdi=".$row["IdOpakowania"]."&ajdi2=".$row["IdLeku"]."&koszt=".$row["Cena"]."&ile=".$row["IloscSztuk"]."&nazwa=".$row["Nazwa"]."'> Zażyj </a></td>
                <td><a href='utylizacja.php?ajdi=".$row["IdOpakowania"]."&ajdi2=".$row["IdLeku"]."&koszt=".$row["Cena"]."&ile=".$row["IloscSztuk"]."'> Zutylizuj </a></td>
                </tr>";
                }
            } 
            echo "</table>";
        }else{
                echo "brak wyników!";
            }
        
        mysqli_close($dbconn);
    
    ?>
</div>
<!-- End page content -->


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




function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  dir = "asc"; 
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }}}
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;      
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }}}
}

/* wyszukiwanie leku */
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}





</script>

</body>
</html>