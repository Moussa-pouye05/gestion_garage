<?php
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../classes/reparation.php';

 $stmt = $con->query("SELECT * FROM notifications WHERE statut = 'non_lu' ORDER BY created_at DESC LIMIT 1");
$notif = $stmt->fetch(PDO::FETCH_ASSOC);

if ($notif) {
    // Marquer comme lu
    $con->prepare("UPDATE notifications SET statut = 'lu' WHERE id = ?")->execute([$notif['id']]);

    echo json_encode([
        "new" => true,
        "message" => $notif['message']
    ]);
} else {
    echo json_encode(["new" => false]);
}
?>