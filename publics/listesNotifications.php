<?php
require_once __DIR__ . '/../config/mysql.php';

$stmt = $con->query("SELECT * FROM notifications ORDER BY created_at DESC LIMIT 10");
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<ul>
<?php foreach($notifications as $notif): ?>
    <li><?= htmlspecialchars($notif['message']) ?> - <?= $notif['created_at'] ?></li>
<?php endforeach; ?>
</ul>
