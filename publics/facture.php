<?php
  require_once __DIR__ . '/../config/mysql.php';
  require_once __DIR__ . '/../classes/reparation.php';
    $reparation = new Reparation($con);

// Vérifier si un id est passé
if (isset($_GET['id'])) {
    $idReparation = (int)$_GET['id'];
    $reparation->genererFacture($idReparation);
} else {
    echo "ID de réparation manquant !";
}
?>