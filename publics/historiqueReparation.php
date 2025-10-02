<?php
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../publics/dashboardAdmin.php';
 require_once __DIR__ . '/../classes/reparation.php';

 if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "Aucun id";
 }
 $id_rep = $_GET['id'];
?>

<main>
    <header>
        <h2>Sunu Garage</h2>
    <div class="menuSide">
      <a onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></a>
      </div>
    <script>
      function toggleMenu(){
       let nav = document.getElementById("nav");
       if(nav.style.width === "80%"){
         nav.style.width = "0%"
       }else{
         nav.style.width = "80%"
       }
    }
    </script>
    </header>
    <section>

    <?php 
    $reparation = new Reparation($con);
    $reparations = $reparation->getReparation($id_rep);
    $coutUnique = $reparation->getDernierCoutReparation($id_rep);
    $totalCout = $reparation->getSommeCoutReparation($id_rep);
    ?>
    
    <div class="big-historique">
         <div class="historique">
        <p>Historique des réparations</p>
        <?php if(!empty($reparations)):?>
          <?php foreach($reparations as $reparation):?>
        <a href="detailReparation.php?id=<?php echo $id_rep?>">
          <span class="imm"><?php echo $reparation['immatriculation']?></span><span class="date_rep"><?php echo $reparation['date_reparation']?></span>
        </a>
    <?php endforeach;?>

     <?php else: ?>
    <p style="color:red">Historique vide</p>
   <?php endif; ?>
     </div>
    </div>
    
    
    </section>
</main>