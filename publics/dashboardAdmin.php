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
    <link rel="icon" type="image/x-icon" href="./images/logo.jpg">
    
     <link rel="stylesheet" href="./../styles/dashboardAdmin.css">
     <link rel="stylesheet" href="./../styles/gestionEmplye.css">
     <link rel="stylesheet" href="./../styles/gestionClient.css">
     <script src="./../script/style.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Gestion garage</title>
</head>
<body>
<nav id="nav">
    <span><h2 class="dashboard">Dashboard</h2><?php echo $_SESSION['utilisateur']['nom'];?></span>
    <div class="nav-left">
        <span><a href="gestionEmploye.php"><i class="fa-solid fa-user-secret"></i>Gestion employes</a></span>
        <span><a href="gestionClient.php"><i class="fa-solid fa-users"></i>Gestion clients</a></span>
        <span><a href=""><i class="fa-solid fa-car"></i>Gestion voitures</a></span>
        <span><a href=""><i class="fa-solid fa-car-burst"></i>Gestion reparations</a></span>
    </div>
    <div class="deconnect">
      <a href="deconnexion.php">Deconnexion</a>
    </div>
</nav>
</body>
</html>