<?php
  require_once __DIR__ .'/../config/mysql.php';
  require_once __DIR__ . '/../classes/voiture.php';

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $employe = new Voiture($con);
    $employe->getVoitureById($id);
    
    $employe->deleteVoiture($id);
    // header("Location: ./gestionVoiture.php");
    // exit;
}
?>