<?php
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../classes/voiture.php';

 if(isset($_POST['id'], $_POST['status'])){
    $id = $_POST['id'];
    $status = $_POST['status'];
 }
 $state = new Voiture($con);
 $state->updateStatus($id,$status);
?>