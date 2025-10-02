<?php
 declare(strict_types=1);

 require_once __DIR__ . '/../config/mysql.php';

 class Voiture{
    public $con;

    public function __construct($con){
        $this->con = $con;
    }

    public function totalVoiture(){
        $stmt = $this->con->prepare("SELECT COUNT(*) AS total FROM vehicules");
        $stmt->execute();
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fetch ? (int)$fetch['total'] : 0;
    }
 
 public function voitureEnPanne(){
    $stmt = $this->con->prepare("SELECT COUNT(*) AS total FROM vehicules WHERE status='en panne' ");
    $stmt->execute();
    $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fetch ? (int)$fetch['total'] : 0;
 }
 public function voitureEnReparation(){
    $stmt = $this->con->prepare("SELECT COUNT(*) AS total FROM vehicules WHERE status='en reparation' ");
    $stmt->execute();
    $fecht = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fecht ? (int)$fecht['total'] : 0;
 }
 public function voitureTerminer(){
    $stmt = $this->con->prepare("SELECT COUNT(*) AS total FROM vehicules WHERE status='termine' ");
    $stmt->execute();
    $fecht = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fecht ? (int)$fecht['total'] : 0;
 }
 public function getClient(){
    $stmt = $this->con->prepare("SELECT id,nom FROM clients");
    $stmt->execute();
    $fetch  = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $fetch;
 }
 public function addVoiture($client_id,$immatricule,$marque,$modele,$annee){
   $stmt = $this->con->prepare("SELECT COUNT(*) FROM vehicules WHERE immatriculation = :immatriculation");
   $stmt->execute(['immatriculation' => $immatricule]);
   
   session_start();
   if($stmt->fetchColumn() > 0){
      $_SESSION['existe'] = "Cette immatricule existe deja ";
      header("Location: ./../publics/gestionVoiture.php?erreur=".$_SESSION['existe']);
   }else{
      $req = $this->con->prepare("INSERT INTO vehicules (client_id,immatriculation,marque,modele,annee) VALUES (:client_id,:immatriculation,:marque,:modele,:annee)");
      $req->execute([
         'client_id' => (int)$client_id,
         'immatriculation' => $immatricule,
         'marque' => $marque,
         'modele' => $modele,
         'annee' => $annee
      ]);
      
      $_SESSION['successVoiture'] = "Voiture ajoute avec success";
      header("Location: ./../publics/gestionVoiture.php?success=".$_SESSION['successVoiture']);
   }
 }
  public function listeVoiture(){
   $stmt  = $this->con->prepare("SELECT v.id, c.nom,v.immatriculation,v.marque,v.modele,v.annee from vehicules v JOIN clients c ON v.client_id=c.id ");
   $stmt->execute();
   $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $fetch;
  }
  public function getClient_id($client_id){
   $stmt = $this->con->prepare("SELECT * FROM vehicules JOIN clients ON clients.id=vehicules.client_id WHERE client_id=:client_id");
   $stmt->execute(['client_id' => $client_id]);
   $fetch = fetchAll(PDO::FETCH_ASSOC);
   return $fetch;
  }
public function filtrerVoituresParClientId($clientId = null) {
        $where = "";
        $params = [];

        if ($clientId !== null && $clientId !== '') {
            $where = "WHERE v.client_id = :client_id";
            $params[':client_id'] = (int)$clientId;
        }

        $sql = "SELECT v.id AS id, v.immatriculation, v.marque, v.modele, v.annee, v.status,
                       c.id AS client_id, c.nom AS client_nom
                FROM vehicules v
                JOIN clients c ON v.client_id = c.id
                $where
                ORDER BY v.id DESC
                LIMIT 1000"; // ajuster si nécessaire

        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ?: [];
    }


public function detailClient($id){
   $stmt = $this->con->prepare("SELECT c.id, c.nom, v.immatriculation,v.marque,v.modele,v.annee,v.status FROM vehicules v JOIN clients c ON v.client_id=c.id WHERE v.id = :id");
   $stmt->execute(['id' => $id]);
   $fetch = $stmt->FetchAll(PDO::FETCH_ASSOC);
   return $fetch;
}
public function addReparation($voiture_id,$date,$description,$cout){
   $stmt = $this->con->prepare("INSERT INTO reparations (vehicule_id,date_reparation,description,cout) VALUES (:vehicule_id,:date_reparation,:description,:cout)");
   $stmt->execute([
      'vehicule_id' => $voiture_id,
      'date_reparation' => $date,
      'description' => $description,
      'cout' => $cout
   ]);
   session_start();
   $_SESSION['successVoitureDetail'] = "Facturé avec succes";
   header("Location: ./../publics/detailVoiture.php?id=".$voiture_id.$_SESSION['successVoitureDetail']);
}

}
?>