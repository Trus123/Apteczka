<!DOCTYPE html>
<html>
    <head><meta charset="UTF-8">
    <style>
table {
  border-spacing: 0;
  width: 50%;
  border: 1px solid #ddd;
}

th {
  cursor: pointer;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2
}
</style>

</head>
<body>


<?php
function chgw($dane){
    $dane = trim($dane);
    $dane=stripslashes($dane);
    $dane=htmlspecialchars($dane);
    return $dane;
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty($_POST["NrLeku"]))
    {$imErr = "musisz podać imię!";}
    else
    {$nrLeku = chgw($_POST["NrLeku"]);}

    if(empty($_POST["NazwaLeku"]))
    {$nazErr = "musisz podać nazwisko!";}
    else
    {$NazwaLeku = chgw($_POST["NazwaLeku"]);}

    if(empty($_POST["Ilosc"]))
    {$wzErr = "musisz podać wzrost!";}
    else
    {$Ilosc = chgw($_POST["Ilosc"]);}
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

$sql = "INSERT INTO LekiTEST (NrLeku, NazwaLeku, Ilosc)
    VALUES ('".$nrLeku."','".$NazwaLeku."','".$Ilosc."')";

if(mysqli_query($conn,$sql))
{
    echo "Dopisano!";
} else{
    echo "Błąd: ".$sql."<br>".mysqli_error($conn);
}
?>

<h1> Wypełnij formularz </h1>
<p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Numer Leku:<input type="text" name="NrLeku"><?php echo $imErr;?><br>
Nazwa:<input type="text" name="NazwaLeku"><?php echo $nazErr;?><br>
Ilość:<input type="text" name="Ilosc"><?php echo $wzErr;?><br>
<input type="submit" value="Wpisz">
<input type="reset" value="Nie wpisuj">
</p></form>

<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

<table id="myTable"><tr><th onclick="sortTable(0)">NrLeku</th><th onclick="sortTable(1)">NazwaLeku</th><th onclick="sortTable(2)">Ilosc</th></tr>
<?php
    if (!$conn){
        die("Connection failed! : ".mysqli_connect_error());
    }

    $sql = "SELECT  `NrLeku`, `NazwaLeku`, `Ilosc` FROM LekiTEST";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo "<tr><td>".$row["NrLeku"]."</td><td>".$row["NazwaLeku"]."</td><td>".$row["Ilosc"]."</td></tr>";
        }
    }else{
            echo "brak wyników!";
        }
    

    mysqli_close($conn);
    echo "</table>";
    ?>








<script>
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



/* wyszukiwanie leku */
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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




</body>
</html>