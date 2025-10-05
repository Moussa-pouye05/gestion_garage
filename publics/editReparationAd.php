<?php
require_once __DIR__ . '/../config/mysql.php';
require_once __DIR__ . '/../classes/voiture.php';

if(!isset($_GET['id']) && !is_numeric($_GET['id'])){
    echo "il faut un identifiant";
}
$id = (int)$_GET['id'];
$rep = new Voiture($con);
$reparation = $rep->getReparationById($id);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="postEditReparationAd.php" method="POST">
        <div class="inputBox">
            <div for="">Identifiant</div>
            <input type="hidden" name="id" id="" value="<?php echo $id ?>">
        </div>
        <div class="inputBox">
            <div for="">Description</div>
            <input type="text" name="description" id="" value="<?php echo htmlspecialchars($reparation['description'])  ?>">
        </div>
        <div class="inputBox">
            <div for="">Cout</div>
            <input type="text" name="coup" id="" value="<?php echo !empty($reparation['cout']) ? htmlspecialchars($reparation['cout']) : "0" ?>">
        </div>
        <div class="bas">
         <div class="annuler">
          <a href="gestionVoiture.php">Annuler</a>
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