<?php
session_start();

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
  <br><a style="pointer-events: none;" href="wylogowanie.php" onclick="w3_close()" class="w3-button w3-hover-white">Wyloguj się</a> <br><br>
  <a style="pointer-events: none;" href="apteczkaGlowna.php" onclick="w3_close()" class="w3-button w3-hover-white">strona Główna</a>
    <a style="pointer-events: none;" href="apteczkaDodaj.php" onclick="w3_close()" class="w3-button w3-hover-white">Dodaj Lek</a>
    <a style="pointer-events: none;" href="apteczkaLeki.php" onclick="w3_close()" class="w3-button w3-hover-white">Spis Leków</a>
    <a style="pointer-events: none;" href="apteczkaZazyte.php" onclick="w3_close()" class="w3-button w3-hover-white">Zażyte Leki</a>
    <a style="pointer-events: none;" href="apteczkaZutylizowane.php" onclick="w3_close()" class="w3-button w3-hover-white">Zutylizowane</a> 
    <a style="pointer-events: none;" href="apteczkakoszty.php" onclick="w3_close()" class="w3-button w3-hover-white">Wykres kosztów</a>   
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
    <h1 class="w3-jumbo"><b>Aby skorzystać</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Niepoprawne logowanie/rejestracja</b></h1>
    <hr class="w3-round">
  </div>

  <!-- Logowanie -->
  <div class="wrapper" style="margin:0 auto;">
    <div style="margin: auto 125px;">
      <img src="icon60.png" id="icon" alt="User Icon" />
    </div>
    <div class="form-container">
       <div class="slide-controls">
          <input type="radio" name="slide" id="login" checked>
          <input type="radio" name="slide" id="signup">
          <label for="login" class="slide login">Logowanie</label>
          <label for="signup" class="slide signup">Rejestracja</label>
          <div class="slider-tab"></div>
       </div>
       <div class="form-inner">

          <form method="POST" action="logowanie.php" class="login">
             <div class="field">
                <input type="text" placeholder="Login" name="login" required>
             </div>
             <div class="field">
                <input type="password" placeholder="Hasło" name="Password" required>
             </div>
             <div class="field btn">
                <div class="btn-layer"></div>
                <input type="submit" value="Zaloguj">
             </div>
          </form>

          <form method="POST" action="rejestrator.php" class="signup">
             <div class="field">
                <input type="email" placeholder="Email" name="email" required>
             </div>
             <div class="field">
                <input type="login" placeholder="Login" name="Login" required>
             </div>
             <div class="field">
                <input type="password" placeholder="Hasło" name="Password" required>
             </div>
             <div class="field btn">
                <div class="btn-layer"></div>
                <input type="submit" value="Zarejestruj">
             </div>
          </form>

       </div>
    </div>
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

<script>
  const loginText = document.querySelector(".title-text .login");
  const loginForm = document.querySelector("form.login");
  const loginBtn = document.querySelector("label.login");
  const signupBtn = document.querySelector("label.signup");
  const signupLink = document.querySelector("form .signup-link a");
  signupBtn.onclick = (()=>{
    loginForm.style.marginLeft = "-50%";
    loginText.style.marginLeft = "-50%";
  });
  loginBtn.onclick = (()=>{
    loginForm.style.marginLeft = "0%";
    loginText.style.marginLeft = "0%";
  });
  signupLink.onclick = (()=>{
    signupBtn.click();
    return false;
  });
</script>


</body>
</html>
