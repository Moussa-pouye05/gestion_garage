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
    public function pagination($page = 1, $limit = 5, $search = "") {
    $offset = ($page - 1) * $limit;

    // Si recherche
    if (!empty($search)) {
        $sqlCount = "SELECT COUNT(*) FROM clients 
                     WHERE nom LIKE :search OR telephone LIKE :search";
        $stmtCount = $this->con->prepare($sqlCount);
        $stmtCount->execute([':search' => "%$search%"]);
        $total = $stmtCount->fetchColumn();

        $sql = "SELECT * FROM clients 
                WHERE nom LIKE :search OR telephone LIKE :search
                LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // Pas de recherche → pagination normale
        $total = $this->con->query("SELECT COUNT(*) FROM clients")->fetchColumn();

        $sql = "SELECT * FROM clients LIMIT :limit OFFSET :offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
    }

    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalPages = ceil($total / $limit);

    return [
        'data' => $clients,
        'total' => $total,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}
}
?>