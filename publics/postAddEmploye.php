<?php
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ .'/../classes/utilisateur.php';

 if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['mot']) && isset($_POST['role'])){
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot = $_POST['mot'];
    $role = $_POST['role'];

    $inscrire = new Utilisateur($con);
    $inscrire->inscription($nom,$email,$mot,$role);
 }
?>