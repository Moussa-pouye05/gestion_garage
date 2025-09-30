<?php
declare(Strict_types=1);
require_once __DIR__ . '/../config/mysql.php';

class Reparation{
 public $con;

public function __construct($con){
        $this->con = $con;
    }

 public function getReparation($id){
   $stmt = $this->con->prepare("SELECT v.immatriculation, r.date_reparation FROM vehicules v JOIN reparations r ON v.id=r.vehicule_id where v.id = :id");
   $stmt->execute(['id' => $id]);
   $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $fetch === false ? null : $fetch;
}

public function getDernierCoutReparation($vehicule_id){
   $stmt = $this->con->prepare("SELECT cout FROM reparations WHERE vehicule_id = :vehicule_id ORDER BY date_reparation DESC LIMIT 1");
   $stmt->execute(['vehicule_id' => $vehicule_id]);
   $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
   return $fetch;
}
public function getSommeCoutReparation($vehicule_id){
    $stmt = $this->con->prepare("SELECT SUM(cout) AS total_coup FROM reparations WHERE vehicule_id = :vehicule_id");
    $stmt->execute(['vehicule_id' => $vehicule_id]);
    $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fetch;
}
}
?>