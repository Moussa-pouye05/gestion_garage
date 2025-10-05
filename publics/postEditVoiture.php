<?php 
require_once __DIR__ .'/../config/mysql.php';
 require_once __DIR__ .'/../classes/voiture.php';

    if(!isset($_POST['id']) && !is_numeric($_POST['id']) 
        && empty($_POST['immatriculation']) && empty($_POST['marque'])
        && empty($_POST['modele']) && empty($_POST['annee'])){

        echo "Il faut un identifiant pour modifier un employé s.";
        return;
    }
    $id_employe = (int)$_POST['id'];
    $immatriculation = trim($_POST['immatriculation']);
    $marque = trim($_POST['marque']);
    $modele = trim($_POST['modele']);
    $annee = trim($_POST['annee']);
    $employe = new Voiture($con);
    var_dump($employe);
    $employe->updateVoiture($id_employe,$immatriculation,$marque,$modele,$annee);

?>