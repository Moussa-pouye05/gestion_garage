<?php
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../publics/dashboardAdmin.php';
 require_once __DIR__ . '/../classes/reparation.php';
//  require_once __DIR__ . '/facture.php';
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
        <p><span class="textClient">Reparations</span><span class="textDetail">/details</span></p>
        <?php
        
         $id_rep = $_GET['id'];
         $reparation = new Reparation($con);
         $reparations = $reparation->getReparation($id_rep);
        
        ?>
        <?php foreach($reparations as $value):?>
          <div class="big_detail_rep">
             <div class="detail_rep">
              <a href="detailVoiture?id=<?php echo $id_rep?>"><i class="fa-solid fa-arrow-left"></i>Retour</a>
              <div class="rep"><span class="desc">Date:</span><?php echo $value['date_reparation']?></div>
              <div class="rep"><span class="desc">Description:</span><?php echo $value['description']?></div>
              <div class="rep"><span class="desc">Cout:</span><?php echo $value['cout']?> F</div>
              <a href="facture.php?id=<?php echo $value['reparation_id']; ?>" target="_blank">
              <button class="btn-facture">Générer facture</button>
              </a>
             </div>
             <div class="hrRep"></div>
          </div>
        
        <?php endforeach;?>
    </section>
</main>