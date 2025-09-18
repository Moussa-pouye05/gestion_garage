<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/logo.jpg">
    <link rel="stylesheet" href="./styles/connexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Connexion</title>
</head>
<body>
    <div class="form">
        <form action="./publics/PostConnexion.php" method="POST">
            <h2>Connexion</h2>
            <?php if(isset($_SESSION['messageError'])):   ?>
                <div class="message">
                <?php   echo htmlspecialchars($_SESSION['messageError']);
                        unset($_SESSION['messageError']);
                 ?>
               </div>
               <?php endif; ?>
            <div class="inputBox">
                <div>Email</div>
                <div class="input">
                    <input type="email" name="email" required="required" placeholder="Email">
                    <i class="fa-solid fa-envelope"></i>
                </div>

            </div>
            <div class="inputBox">
                <div>Mot de passe</div>
                <div class="input">
                    <input type="password" name="mot" required="required" placeholder="Mot de passe">
                    <i class="fa-solid fa-lock"></i>
                </div>
            </div>
            <button class="btn">Se connecter</button>
        </form>
    </div>
</body>
</html>