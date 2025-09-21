<?php
  require_once __DIR__ . '/../config/mysql.php';
  require_once __DIR__ .'/../classes/client.php';

  if(isset($_POST['nom']) && isset($_POST['telephone']) && isset($_POST['adresse'])){

    $nom = $_POST['nom'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    $client = new Client($con);
    $client->ajouterClient($nom,$telephone,$adresse);
  }
?>