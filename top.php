<!DOCTYPE html>
<meta charset="UTF-8">
<head>
<title>Domowa Apteczka</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styleLogowanie.css"> 
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
    <br><a href="apteczkaLogowanie.php" onclick="w3_close()" class="w3-button w3-hover-white">Wyloguj się</a> <br><br>
    <a href="apteczkaDodaj.php" onclick="w3_close()" class="w3-button w3-hover-white">Dodaj Lek</a> 
    <a href="apteczkaZazyj.php" onclick="w3_close()" class="w3-button w3-hover-white">Zażyj Lek</a> 
    <a href="apteczkaUsun.php" onclick="w3_close()" class="w3-button w3-hover-white">Usuń Lek</a> 
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Domowa Apteczka</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>