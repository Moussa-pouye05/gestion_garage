<?php
require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../classes/voiture.php';
 require_once __DIR__ . '/../classes/client.php';

 if(isset($_POST['immatricule']) && isset($_POST['marque']) && isset($_POST['modele']) && isset($_POST['annee'])){
      
        $client_id = (int)$_POST['client_id'];
        $immatricule = $_POST['immatricule'];
        $marque = $_POST['marque'];
        $modele = $_POST['modele'];
        $annee = $_POST['annee'];
     }
     
     $voiture = new Voiture($con);
     $voiture->addVoiture($client_id,$immatricule,$marque,$modele,$annee);
?>