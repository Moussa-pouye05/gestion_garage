<?php
 require_once __DIR__ .'/../config/mysql.php';
 require_once __DIR__ . '/../classes/client.php';

 if(isset($_GET['id'])){
    $id = $_GET['id'];
    $client = new Client($con);
    $client->getClientById($id);
    
    $client->deleteClient($id);
    header("Location: ./gestionClient.php?delete=1");
    exit;
 }
?>