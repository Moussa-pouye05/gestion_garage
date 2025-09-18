<?php
 session_start();

 require_once __DIR__ .'/../config/mysql.php';
 require_once __DIR__ .'/../classes/utilisateur.php';

 echo "Bonjour".$_SESSION['utilisateur']['nom'];

?>
<a href="deconnexion.php">Déconnexion</a>