<?php
 require __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/dashboardAdmin.php';
 require_once __DIR__ . '/../classes/voiture.php';
 require_once __DIR__ . '/../classes/client.php';

 
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
        $voiture = new Voiture($con);
        $nbTotal = $voiture->totalVoiture();
        $nbEnPanne = $voiture->voitureEnPanne();
        $nbEnReparation  = $voiture->voitureEnReparation();
        $nbTermine = $voiture->voitureTerminer();
        $listeVoitures = $voiture->listeVoiture();
        
        $proprietaire = $_GET['searchVoiture'] ?? null;
        if (empty($proprietaire)) {
            $listeVoitures = $voiture->filtrerVoituresParClient(null);
        } else {
            $listeVoitures = $voiture->filtrerVoituresParClient($proprietaire);
        }
        ?>
        <div class="card-voiture">
            <div class="car total-voiture">
              <div class="icon-car first"><i class="fa-solid fa-car"></i></div>
              <p><span class="text">Total voitures</span><br><span class="number"><?php echo $nbTotal;?></span></p>
            </div>
            <div class="car voiture-enpanne">
                <div class="icon-car"><i class="fa-solid fa-car-burst"></i></div>
                <p><span class="text">Voitures en panne</span><br><span class="number"><?php echo $nbEnPanne?></span></p>
            </div>
            <div class="car voiture-en-reparation">
                <div class="icon-car three"><i class="fa-solid fa-caret-up"></i></div>
                <p><span class="text">Voitures en réparation</span><br><span class="number"><?php echo $nbEnReparation?></span></p>
            </div>
            <div class="car total-termine">
                <div class="icon-car"><i class="fa-solid fa-car-side"></i></div>
                <p><span class="text">Voitures terminées</span><br><span class="number"><?php echo $nbTermine?></span></p>
            </div>
        </div>
        <!-- <form method="GET" action=""> -->
           <div class="searchVoiture">
           <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" name="searchVoiture" placeholder="Recherche par propriétaire" 
               value="<?php echo htmlspecialchars($_GET['searchVoiture'] ?? ''); ?>">
          <!-- <button type="submit">Rechercher</button> -->
          </div>
        <!-- </form> -->
        <script>
            function toggleAddClient(){
                let addClient = document.getElementById("formulaire")
                addClient.classList.toggle("activeClient")
            }
        </script>
            <?php if(isset($_SESSION['successVoiture'])): ?>
            <div class="alert alert-success m-4">
            <?php echo htmlspecialchars($_SESSION['successVoiture']); 
             unset($_SESSION['successVoiture']);  
            ?>
            </div>
            <?php endif;?>
            <?php if(isset($_SESSION['existe'])):   ?>
               
                <?php   echo '<p style="color:red;text-align:center;">' .$_SESSION['existe']. '</p>'; ?> 
                 <script>
                  document.addEventListener('DOMContentLoaded',function(){
                     toggleX();
                  })
                 </script>
                      <?php  unset($_SESSION['existe']);
                 ?>
            
               <?php endif; ?>
               <div class="textListe">
                <p>Listes voiture</p>
               </div>
              <script>
                    const inputSearch = document.getElementById("searchVoiture");
                    const resultats = document.getElementById("resultatsVoitures");
                    let timer = null;

                    function chargerVoitures() {
                        const formData = new FormData();
                        formData.append("proprietaire", inputSearch.value);

                        fetch("filtrerVoitures.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(res => res.text())
                        .then(data => {
                            resultats.innerHTML = data;
                        });
                    }

                    // ⏳ recherche avec un petit délai (évite d’envoyer trop de requêtes)
                    inputSearch.addEventListener("input", () => {
                        clearTimeout(timer);
                        timer = setTimeout(chargerVoitures, 300);
                    });

                    // Charger les voitures au démarrage
                    chargerVoitures();
                    </script>

        <div class="table-voiture">
            <div class="card-head">
                <div class="client">Propriétaire</div>
                <div class="immatricule">Immatriculation</div>
                <div class="marque">Marque</div>
                <div class="model">Modèle</div>
                <div class="annee">Année</div>
                <div class="action">Action</div>
                <div class="status">Status</div>
            </div>
            <div class="card-body" id="resultatsVoitures"></div>
            <?php if (!$listeVoitures): ?>
                  <div class="ligne" style="grid-column: 1 / -1; text-align:center; color:red;">Aucune voiture trouvée</div>;
                   <?php exit;?>
                    <?php   endif;  ?>
            <div class="card-body">
                    <?php foreach ($listeVoitures as $value): ?>
                <div class="ligne client"><?php echo $value['client_nom']?></div>
                <div class="ligne immatricule"><?php echo htmlspecialchars($value['immatriculation'])?></div>
                <div class="ligne marque"><?php echo htmlspecialchars($value['marque'])?></div>
                <div class="ligne model"><?php echo htmlspecialchars($value['modele'])?></div>
                <div class="ligne annee"><?php echo htmlspecialchars($value['annee'])?></div>
                <div class="ligne action">
                    <a class="edit" href="editClient.php?id=<?php echo $value['id']  ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a class="delete" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette voiture ?')) { window.location.href = 'postDeleteVoiture.php?id=<?php echo $value['id']; ?>'; }"><i class="fa-solid fa-trash"></i></a>
                    <a class="details" href="detailVoiture.php?id=<?php echo $value['id'];?>"><i class="fa-solid fa-info-circle"></i></a>
                </div>
                <div class="ligne status">status</div>
                <?php endforeach?>
                    
            </div>
            <!-- <div class="card-body" id="resultatsVoitures"></div> -->
        </div>
        <?php
        
        $clients = $voiture->getClient();
        ?>

    </section>
</main>