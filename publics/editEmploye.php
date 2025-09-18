<?php
  
  require_once __DIR__ .'/../config/mysql.php';
  require_once __DIR__ . '/../classes/employe.php';
    
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
        echo "Il faut un identifiant pour modifier un employé.";
        return;
    }
          $id_employe = (int)$_GET['id'];    
          $employe = new Employe($con);
          $row = $employe->getEmployeById($id_employe);
          if($row === null){
            echo "Employé non trouvé.";
            return;
          }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="../styles/gestionEmplye.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="postEditEmploye.php" method="POST">
        <div class="inputBox">
            <div for="">Identifiant</div>
            <input type="hidden" name="id" id="" value="<?php echo ($id_employe);?>">
        </div>
        <div class="inputBox">
            <div for="">Nom</div>
            <input type="text" name="nom" id="" value="<?php echo (htmlspecialchars($row['nom'])) ?>">
        </div>
        <div class="inputBox">
            <div for="">Email</div>
            <input type="email" name="email" id="" value="<?php echo (htmlspecialchars($row['email'])) ?>">
        </div>
        <div class="bas">
         <div class="annuler">
          <a href="gestionEmploye.php">Annuler</a>
         </div>
        <button class="btn" name="modifier">Modifier</button>
        </div>

    </form>
    
    <style>
        body{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        form{
            width: 30%;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color:white;
        }
        input{
            width: 95%;
            padding:10px;
            outline:none;
            border:1px solid rgba(0,0,0,0.2);
            border-radius:10px;
            margin:5px;
        }
        .inputBox{
            margin-top:10px;
        }
        .btn{
            width: 40%;
            padding: 10px;
            margin-top:10px;
            background-color:rgba(0,0,0,0.2);
            border:none;
            border-radius:10px;
            cursor: pointer;
        }
        .annuler a{
            text-decoration: none;
            color:white;
            font-weight: bold;
            padding:8px;
            background-color:red;
            display:block; 
            border-radius:10px;
            text-align:center;
        }
        .annuler{
          width: 40%; 
          margin-top:7px;
        }
        .bas{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        @media screen and (max-width:600px){
            form{
                width: 80%;
            }
            
        }
    </style>
</body>
</html>