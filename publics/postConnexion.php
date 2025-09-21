<?php
// session_start();
  require_once __DIR__.'/../config/mysql.php';
  require_once __DIR__.'/../classes/utilisateur.php';
  
  // $_SESSION['utilisateur'] = $user;
  // if(!isset($_SESSION['utilisateur']['id'])){
  //   header("Location: ../index.php");
  //   echo "utilisateur inconnue";
  //   exit();
  // }
  $inactive = 600; // Durée d'inactivité en secondes (10 minutes)
  if (isset($_SESSION['last_activity'])){
    $inactive_duration = time() - $_SESSION['last_activity'] > $inactive;
       if($inactive_duration > $inactive){
        session_unset();
        session_destroy();
        header("Location: deconnexion.php");
      exit();
       }
      
  }

  if(isset($_POST['email']) && isset($_POST['mot'])){
    $email = $_POST['email'];
    $mot = $_POST['mot'];
    
    $connexion = new Utilisateur($con);
    $connexion->connexion($email,$mot);
  }
?>