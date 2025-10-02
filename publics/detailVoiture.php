<?php
 require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../publics/dashboardAdmin.php';
 require_once __DIR__ . '/../classes/voiture.php';
 require_once __DIR__ . '/../classes/reparation.php';

 if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    // echo "Aucun id";
 }
 $id_reparation = (int)$_GET['id'];
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
    <?php
      $id = $_GET['id'];
      $voiture = new Voiture($con);
      $reps = new Reparation($con);
      $details = $voiture->detailClient($id);
      $reparations = $reps->getReparation($id_reparation);
      $coutUnique = $reps->getDernierCoutReparation($id_reparation);
     $totalCout = $reps->getSommeCoutReparation($id_reparation);
    ?>
    <section>
         <p><span class="textClient">Voitures</span><span class="textDetail">/details</span></p>
         <?php if(!empty($coutUnique) || !empty($totalCout)):?>
    <div class="cout">
        <div class="cout-unique">
            <div><i class="fa-solid fa-money-check-dollar"></i></div>
            <div class="textnum">
                <p><span class="text">Prix du dernier réparation</span></p>
               <p><span class="nombre"><?php echo !empty($coutUnique['cout']) ? htmlspecialchars($coutUnique['cout']). " F" : "0 F";?></span></p>
            </div>
            
        </div>
        <div class="cout-unique">
            <div><i class="fa-solid fa-money-check"></i></div>
            <div class="textnum">
                <p><span class="text">Prix total des réparations</span></p>
                <p><span class="nombre"><?php echo !empty($totalCout['total_coup']) ? htmlspecialchars($totalCout['total_coup']). " F" : "0 F";?></span></p>
            </div>
            
        </div>
    </div>
    <?php else:?>
         <p>Aucune réparation trouvée</p>
        <?php endif;?>
        <?php if(isset($_SESSION['successVoitureDetail'])): ?>
            <div class="alert alert-success m-4">
            <?php echo htmlspecialchars($_SESSION['successVoitureDetail']); 
             unset($_SESSION['successVoitureDetail']);  
            ?>
            </div>
            <?php endif;?>
    <div class="detailCarHistorique">
        <div class="detailVoiture">
            <div class="lienFacture">
                <a href="gestionVoiture.php"><i class="fa-solid fa-arrow-left"></i>Retour</a>
                <button onclick="toggleFacture()">Facturer</button>
                <script>
                    function toggleFacture(){
                        let facture = document.getElementById("facture")
                        facture.classList.toggle("activeFacture")
                    }
                </script>
            </div>
            <?php foreach($details as $value):?>
                
                <?php
                    $status = strtolower($value['status']); // mettre en minuscule pour éviter les soucis
                    $statusClass = '';

                    if ($status === 'en panne') {
                        $statusClass = 'status-panne';
                    } elseif ($status === 'en reparation') {
                        $statusClass = 'status-reparation';
                    } elseif ($status === 'termine') {
                        $statusClass = 'status-termine';
                    }
                ?>
            <div class="logoVoiture">
                <i class="fa-solid fa-car-rear"></i>
                <p><?php echo $value['immatriculation'] ?></p>
            </div>
            <div class="hrvoiture"></div>
            <div class="infoDetailVoiture">
                
                <div class="voiture detailPro"><span class="voiture">Proprietaire:</span><?php echo htmlspecialchars($value['nom'])?></div>
                <div class="voiture detailMarque"><span class="voiture">Marque:</span><?php echo htmlspecialchars($value['marque'])?></div>
                <div class="voiture detailModel"><span class="voiture">Modele:</span><?php echo htmlspecialchars($value['modele'])?></div>
                <div class="voiture detailAnnee"><span class="voiture">Annee:</span><?php echo htmlspecialchars($value['annee'])?></div>
                <div class="voiture detailStatus" <?php echo $statusClass; ?>><span class="voiture">Etat:</span> <strong class="
                <?php if ($value['status'] === "en panne"): ?>
                        status-panne
                    <?php elseif ($value['status'] === "en reparation"): ?>
                        status-reparation
                    <?php elseif ($value['status'] === "termine"): ?>
                        status-termine
                    <?php endif; ?>
                "><?php echo htmlspecialchars($value['status'])?></strong></div>
                
            </div>
            <div class="voirClient">
                <div><a href="detailClient?id=<?php echo $value['id'] ?>">Voir proprietaire</a></div>
                <?php endforeach?> 
            </div>
        </div>
        <div class="historique">
            <p>Historique Des reparations</p>
            <?php if(!empty($reparations)):?>
            <?php foreach($reparations as $reparation):?>
                <a href="detailReparation.php?id=<?php echo $id?>">
                <span class="imm"><?php echo $reparation['immatriculation']?></span><span class="date_rep"><?php echo $reparation['date_reparation']?></span>
                </a>
            <?php endforeach;?>

            <?php else: ?>
            <p style="color:red">Historique vide</p>
            <?php endif; ?>
        </div>
     </div>  


        
        <?php $id_voiture = $_GET['id']?>
        
        <div class="factureForm" id="facture">
            <form action="postAddReparation.php" method="POST">
                <a href="" id="croit" onclick="toggleX()"><i class="fa-solid fa-xmark"></i></a>
                <div class="group">
                    <input type="hidden" name="vehicule_id" value=<?php echo htmlspecialchars($id_voiture)?>>
                </div>
                <div class="group">
                    <div>Date de reparation</div>
                    <input type="date" name="date" id="" >
                </div>
                <div class="group">
                    <div>Description</div>
                    <input type="text" name="description" id="" >
                </div>
                <div class="group">
                    <div>Cout</div>
                    <input type="text" name="cout" id="">
                </div>
               <button class="btn" style="background-color: rgba(0, 153, 255, 0.493);">Ajouter</button>
            </form>
        </div>
    </section>
</main>