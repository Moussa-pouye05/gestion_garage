<?php

 declare(strict_types=1);
//  session_start();
 require_once __DIR__ .'/../config/mysql.php';

 class Employe{
      public $con;

    public function __construct($con){
        $this->con = $con;

    }  
    public function listeEmploye(){
        $req = $this->con->prepare("SELECT * FROM utilisateurs WHERE role='employe'");
        $req->execute();
        $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
        return $fetch;
    }
    public function getEmployeById($id): ?array{
        $stmt = $this->con->prepare("SELECT id, nom, email FROM utilisateurs WHERE id = :id AND role = 'employe'");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }
    public function updateEmploye($id,$nom,$email){
        $stmt = $this->con->prepare("UPDATE utilisateurs SET nom = :nom, email = :email WHERE id = :id");
        $stmt->execute([
            'nom' => $nom,
            'email' => $email,
            'id' => $id
        ]);
        session_start();
        $_SESSION['update'] = "Employe modifie avec succes";
        header("Location: ./gestionEmploye.php?message=".$_SESSION['update']);
        exit;
 }
 public function deleteEmploye($id){
    $stmt = $this->con->prepare("DELETE FROM utilisateurs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    session_start();
    $_SESSION['message'] = "Employe supprime avec succes";
    header("Location: ./gestionEmploye.php?message=".$_SESSION['message']);
 }
 
}
?>