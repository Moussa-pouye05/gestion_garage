<?php
  require_once __DIR__ .'/../config/mysql.php';
  require_once __DIR__ . '/../classes/reparation.php';

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $employe = new Reparation($con);
    $employe->getReparationById($id);
    
    $employe->deleteReparation($id);
    header("Location: ./gestionVoiture.php");
    exit;
}
?>