<?php
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../classes/voiture.php';

 if(empty($_POST['description']) && empty($_POST['cout']) && !isset($_POST['id']) && !is_numeric($_POST['id'])){

    echo "Il faut un id";
 }
 $id = (int)$_POST['id'];
 $description = $_POST['description'];
 $cout = $_POST['cout'];
 $rep = new Voiture($con);
 $reparation = $rep->updateReparation($id,$description,$cout);
?>