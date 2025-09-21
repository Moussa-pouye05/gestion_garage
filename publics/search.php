<?php
require_once __DIR__ . '/../config/mysql.php';

// Récupérer le terme recherché
$search = isset($_GET['q']) ? $_GET['q'] : "";

// Requête SQL
$sql = "SELECT * FROM utilisateurs WHERE nom LIKE :search AND role='employe'";
$stmt = $con->prepare($sql);
$stmt->execute(['search' => "%" . $search . "%"]);
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Générer les lignes du tableau
if ($employes) {
    foreach ($employes as $employe) {
        echo "<tr>
                <td>" . htmlspecialchars($employe['nom']) . "</td>
                <td>" . htmlspecialchars($employe['email']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='2'>Aucun employé trouvé</td></tr>";
}

?>