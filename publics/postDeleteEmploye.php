<?php
   require_once __DIR__ .'/../config/mysql.php';
  require_once __DIR__ . '/../classes/employe.php';

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $employe = new Employe($con);
    $employe->getEmployeById($id);
    
    $employe->deleteEmploye($id);
    header("Location: ./gestionEmploye.php?delete=1");
    exit;
}
?>