<?php 
  require_once __DIR__ . '/../config/mysql.php';
  require_once __DIR__ . '/../classes/client.php';

  if(isset($_POST['nom']) && isset($_POST['telephone']) && isset($_POST['adresse'])
     && !empty($_POST['nom']) && !empty($_POST['telephone']) && !empty($_POST['adresse'])
    ){
        $id = (int)$_POST['id'];
        $nom = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];

        $clients = new Client($con);
        $clients->updateClient($id,$nom,$telephone,$adresse);
    }
?>