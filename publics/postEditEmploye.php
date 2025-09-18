<?php 
require_once __DIR__ .'/../config/mysql.php';
 require_once __DIR__ .'/../classes/employe.php';

    if(!isset($_POST['id']) || !is_numeric($_POST['id']) 
        || empty($_POST['nom']) || empty($_POST['email'])
        || trim($_POST['nom']) === '' || trim($_POST['email']) === ''){
        echo "Il faut un identifiant pour modifier un employé s.";
        return;
    }
    $id_employe = (int)$_POST['id'];
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $employe = new Employe($con);

    $employe->updateEmploye($id_employe,$nom,$email);

?>