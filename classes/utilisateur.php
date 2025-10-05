<?php
 declare(strict_types=1);
 require_once __DIR__.'/../config/mysql.php';

 class Utilisateur{
    public $nom;
     public $email;
     public $mot;
     public $con;
     public $role;

     public function __construct($con){
        $this->con = $con;
     }
     public function inscription($nom,$email,$mot,$role){
      $req = $this->con->prepare("SELECT * FROM utilisateurs WHERE email = :email");
      $req->execute(['email'=>$email]);
      $fetch = $req->fetch(PDO::FETCH_ASSOC);
      if($req->rowCount()>0){
         $_GET['message'] = "Cet employe existe deja";
      }else{
           $stmt = $this->con->prepare("INSERT INTO utilisateurs (nom,email,mot_de_passe,role) VALUES(:nom, :email, :mot_de_passe, :role)");
            $stmt->execute([
            'nom' => $nom,
            'email' => $email,
            'mot_de_passe' =>password_hash($mot,PASSWORD_BCRYPT) ,
             'role' => $role
         ]);
         session_start();
         $_SESSION['success'] = "Employé ajouté avec succès";
         header("Location: ./../publics/gestionEmploye.php?success=".$_SESSION['success']); 
      }
        

     }
     
     public function connexion($email,$mot): void{
        
        $stmt = $this->con->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($mot,$user['mot_de_passe'])){
          session_start();
          $_SESSION['utilisateur'] = $user;
          if($_SESSION['utilisateur']['role'] === 'admin'){
            header('Location: ./../publics/gestionEmploye.php');
          }else if($_SESSION['utilisateur']['role'] === 'employe'){
            header('Location: ./../publics/gestionClientEmploye.php');
          }else{
             $_SESSION['message'] = "Role invalide";
             header("Location: ../index.php?message=".$_SESSION['message']);
             exit;
          }
        }else{
            $_SESSION['messageError'] = "Email ou mot de passe invalide";
            echo $_SESSION['messageError'];
            header("Location: ../index.php"."?messageError=".$_SESSION['messageError']);
            exit;
        }
        
     }
 }
?>