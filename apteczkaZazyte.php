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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
        <input type="text" id="search1" placeholder="Szukaj Użytkownika">
        <input type="text" id="search2" placeholder="Szukaj Leku">
        <hr class="w3-round">
    </div>

    <?php
        if (!$dbconn){
            die("Connection failed! : ".mysqli_connect_error());
        }

        $sql = "SELECT Leki.Nazwa, Zazycia.DataZazycia, Zazycia.Ilosc, Zazycia.KosztZazycia, Uzytkownicy.UserFullname FROM ((Zazycia
         INNER JOIN Leki ON Zazycia.IdLeku = Leki.IdLeku)
          INNER JOIN Uzytkownicy ON Zazycia.IdUser = Uzytkownicy.IdUser)";

        $result = mysqli_query($dbconn,$sql);
        if (mysqli_num_rows($result)>0)
        {
            echo '<table id="myTable"><thead>
            <tr><th onclick="sortTable(0)">Nazwa Użytkownika</th><th onclick="sortTable(1)">Nazwa Leku</th><th onclick="sortTable(2)">Kiedy Zażyto</th><th >Ile Zażyto</th></tr></thead>';

            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr><td>".$row["UserFullname"]."</td><td>".$row["Nazwa"]."</td><td>".$row["DataZazycia"]."</td><td>".$row["Ilosc"]."</td></tr>";
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
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}


var $rows = $('#myTable tr').not('thead tr');
$('#search1, #search2').on('input', function() {
    var val1 = $.trim($('#search1').val()).replace(/ +/g, ' ').toLowerCase();
    var val2 = $.trim($('#search2').val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text1 = $(this).find('td:nth-child(1)').text().replace(/\s+/g, ' ').toLowerCase();
        var text2 = $(this).find('td:nth-child(2)').text().replace(/\s+/g, ' ').toLowerCase();
        return !~text1.indexOf(val1) || !~text2.indexOf(val2);
    }).hide();
    
});

</script>



</body>
</html>