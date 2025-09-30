<?php 
 require_once '../config/mysql.php';

class Client{
    public $nom;
    public $telephone;
    public $adresse;
    public $con;

    public function __construct($con){
        $this->con = $con;
    }

    public function ajouterClient($nom, $telephone, $adresse){
        $req = $this->con->prepare("SELECT * FROM clients WHERE telephone = :telephone");
        $req->execute(['telephone' => $this->telephone]);
        $fetch = $req->fetchALL();

        session_start();
        if(count($fetch) > 0){
            $_SESSION['already'] = "Ce client existe deja";
        }else{
            $sql = "INSERT INTO clients (nom, telephone, adresse) VALUES (:nom, :telephone, :adresse)";
            $stmt = $this->con->prepare($sql);
            $stmt->execute([
                'nom' => $nom,
                'telephone' => $telephone,
                'adresse' => $adresse,
            ]);
            
            session_start();
            $_SESSION['successClient'] = "Client ajouté avec succès";
            header("Location: ./../publics/gestionClient.php?success=".$_SESSION['successClient']);
        }

       
    }
    public function listeClient(){
        $stmt = $this->con->prepare("SELECT * FROM clients");
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $clients;
    }
    public function nombreClientDays(){
    $stmt = $this->con->prepare("SELECT COUNT(*) AS nombre FROM clients WHERE DATE(created_at) = CURDATE()");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['nombre'] : 0;
 }
    public function nombreClientMonth(){
        $stmt = $this->con->prepare("SELECT COUNT(*) AS total 
        FROM clients
        WHERE MONTH(created_at) = MONTH(CURDATE()) 
        AND YEAR(created_at) = YEAR(CURDATE())");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }
    public function getClientById($id): ?array{
        $stmt = $this->con->prepare("SELECT id, nom, telephone, adresse FROM clients WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }
    public function updateClient($id, $nom, $telephone, $adresse){
        $stmt = $this->con->prepare("UPDATE clients SET nom = :nom, telephone = :telephone, adresse = :adresse WHERE id = :id");
        $stmt->execute([
            'nom' => $nom,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'id' => $id
        ]);
        session_start();
        $_SESSION['updateClient'] = "Client modifié avec succès";
        header("Location: ./gestionClient.php?message=".$_SESSION['updateClient']);
        exit;
    }
    public function deleteClient($id){
        $stmt = $this->con->prepare("DELETE FROM clients WHERE id = :id");
        $stmt->execute(['id' => $id]);
        session_start();
        $_SESSION['deleteClient'] = "Client supprimé avec succès";
        header("Location: ./gestionClient.php?delete=".$_SESSION['deleteClient']);
        exit;
    }
    function getClientsPagines(int $page = 1, int $limit = 5): array {
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    // Nombre total de clients
    $total = $this->con->query("SELECT COUNT(*) FROM clients")->fetchColumn();

    // Nombre total de pages
    $totalPages = ceil($total / $limit);

    // Récupérer les clients de la page courante
    $stmt = $this->con->prepare("SELECT * FROM clients LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner toutes les infos utiles
    return [
        'clients' => $clients,
        'total' => $total,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}


public function getEtatVehicule($client_id){
    
    $reqCar = $this->con->prepare("SELECT * FROM vehicules JOIN clients ON clients.id=vehicules.client_id WHERE client_id = :client_id");
    $reqCar->execute([
        'client_id' => $client_id
    ]);
    $fetch = $reqCar->fetchAll(PDO::FETCH_ASSOC);
    return $fetch;
}

}
?>