<?php
session_start();
?>

<?php
session_unset();
session_destroy();
if(isset($_SESSION["current_user"])){
    header("Location: /apteczka/apteczkaGlowna.php");
    exit();
} else {
    header("Location: /apteczka/apteczkaLogowanie.php");
    exit();
}
?>

