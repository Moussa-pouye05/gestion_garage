<?php
  require_once __DIR__.'/../config/mysql.php';
  require_once __DIR__.'/../classes/utilisateur.php';

  if(isset($_POST['email']) && isset($_POST['mot'])){
    $email = $_POST['email'];
    $mot = $_POST['mot'];
    
    $connexion = new Utilisateur($con);
    $connexion->connexion($email,$mot);
  }
?>