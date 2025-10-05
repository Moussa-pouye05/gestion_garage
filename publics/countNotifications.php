<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/mysql.php'; // connexion PDO

$stmt = $con->query("SELECT COUNT(*) as total FROM notifications WHERE statut = 'non_lu'");
$count = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(["count" => $count['total']]);
