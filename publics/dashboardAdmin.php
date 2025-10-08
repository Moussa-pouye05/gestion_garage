<?php
 session_start();
 require_once __DIR__ .'/../config/mysql.php';
 require_once __DIR__ .'/../classes/utilisateur.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.jpg">
    
     <link rel="stylesheet" href="./../styles/dashboardAdmin.css">
     <link rel="stylesheet" href="./../styles/gestionEmplye.css">
     <link rel="stylesheet" href="./../styles/gestionClient.css">
     <link rel="stylesheet" href="./../styles/detailClient.css">
     <link rel="stylesheet" href="./../styles/detailVoiture.css">
     <link rel="stylesheet" href="./../styles/gestionVoiture.css">
     <script src="./../script/style.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Gestion garage</title>
</head>
<body>
<nav id="nav">
    <span><h2 class="dashboard">Dashboard<span class="role">/admin</span></h2><strong class="nomUser"><?php echo $_SESSION['utilisateur']['nom'];?></strong></span>
    <div class="nav-left">
        <span><a href="gestionEmploye.php"><i class="fa-solid fa-user-secret"></i>Gestion employes</a></span>
        <span><a href="gestionClient.php"><i class="fa-solid fa-users"></i>Gestion clients</a></span>
        <span><a href="gestionVoiture.php"><i class="fa-solid fa-car"></i>Gestion voitures</a></span>
        <div class="notification-bell">
          <i class="fa-solid fa-bell"></i>
          <span id="notif-count">0</span>
        </div>
    </div>
    <div class="deconnect">
      <a href="deconnexion.php">Deconnexion</a>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
setInterval(function() {
    fetch('checkNotifications.php')
        .then(response => response.json())
        .then(data => {
            if (data.new) {
                Swal.fire({
                    icon: 'info',
                    title: 'Nouvelle réparation',
                    text: data.message,
                    timer: 4000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => console.error('Erreur AJAX:', error));
}, 5000); // Vérifie toutes les 5 secondes
</script>
<script>
function checkNotifCount() {
    fetch('countNotifications.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById("notif-count").innerText = data.count;
        });
}

// Vérifie toutes les 5 secondes
setInterval(checkNotifCount, 8000);

// Vérifie au chargement
checkNotifCount();
</script>
<script>
document.querySelector('.notification-bell').addEventListener('click', () => {
    fetch('listNotifications.php')
        .then(res => res.text())
        .then(html => {
            Swal.fire({
                title: "Notifications",
                html: html,
                width: 400
            });
        });
});
</script>

</body>
</html>