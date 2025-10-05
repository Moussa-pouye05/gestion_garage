<?php 
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../classes/Reparation.php';

 if(isset($_POST['date']) && isset($_POST['description']) && isset($_POST['cout'])){

    $vehicule_id = (int)$_POST['vehicule_id'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $cout = $_POST['cout'];

    
    $vehicule = new Reparation($con);
    $vehicule->addReparations($vehicule_id,$date,$description,$cout);
 }
?>