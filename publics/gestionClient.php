<?php
  require_once __DIR__ . '/dashboardAdmin.php';
  require_once __DIR__ . '/../classes/client.php';
  require_once __DIR__ . '/postAddClient.php';
//   require_once __DIR__ . '/../includes/header.php';
?>
<main>
    <header>
        <h2>Sunu garage</h2>
        <div class="menuSide">
         <a onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></a>
        </div>
        <script>
       function toggleMenu(){
       let nav = document.getElementById("nav");
      //  nav.style.width = "80%"
       if(nav.style.width === "80%"){
         nav.style.width = "0%"
       }else{
         nav.style.width = "80%"
       }
    }
    </script>
    </header>
    <section>
        <!-- <h2>Gestion des clients</h2> -->
         <?php
            // session_start();
            $client = new Client($con);
            $nombreClientsToday = $client->nombreClientDays();
            // $nombreClientsMonth = $client->nombreClientMonth();
         ?>

        <div class="cardClient">
            <div class="card-day">
                <div class="icon-day"><i class="fa-solid fa-calendar-days"></i></div>
                <div class="number-day"> 
                  <div class="nombre"><?php echo $nombreClientsToday; ?></div>
                  <p>Clients aujourd'hui</p>
                </div>
            </div>
             
            <?php $nombreClientMonth = $client->nombreClientMonth();?>
            <div class="card-month">
                <div class="icon-month"><i class="fa-solid fa-calendar-week"></i></div>
                <div class="number-month">
                    <div class="nombre"><?php echo $nombreClientMonth ?></div>
                    <p>Clients ce mois-ci</p>
                </div>
            </div>
            
            
        </div>
        
        <?php 
           $search = isset($_GET['search']) ? trim($_GET['search']) : "";
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


            ?>
       
        <div class="bloc-haut">
            <div class="search">
               <i class="fa-solid fa-magnifying-glass"></i> <input type="text" name="search" value="<?= htmlspecialchars($search)?>" id="input" placeholder="Rechercher...">
            </div>
            
            <div class="addClient">
                <button onclick="toggleForm()"><i class="fa-solid fa-plus"></i>Ajouter un client</button>
            </div>
        </div>
          
         <p id="noResults" style="display:none; color:red; font-weight:bold; margin-left:30px;">
           Aucun client trouvé
         </p>
        <script>
         document.getElementById("input").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#resultats .row, #resultats .action");
            let blocLigne = document.getElementById("resultats");
            let noResult = document.getElementById("noResults");
            let visibleCount = 0;

         for (let i = 0; i < rows.length; i += 4) {
        let nom = rows[i].textContent.toLowerCase();
        let tel = rows[i+1].textContent.toLowerCase();
        let adresse = rows[i+2].textContent.toLowerCase();
        let action = rows[i+3]; // boutons

        // Vérifier si le filtre correspond à l'un des champs
        if (nom.includes(filter) || tel.includes(filter) || adresse.includes(filter)) {
            rows[i].style.display = "block";
            rows[i+1].style.display = "block";
            rows[i+2].style.display = "block";
            action.style.display = "block";
            visibleCount++;
        } else {
            rows[i].style.display = "none";
            rows[i+1].style.display = "none";
            rows[i+2].style.display = "none";
            action.style.display = "none";
        }
    }

    // Afficher message si aucun résultat
    if (filter !== "" && visibleCount === 0) {
        noResult.style.display = "block";
    } else {
        noResult.style.display = "none";
    }
});

       </script>
        <?php if(isset($_SESSION['successClient'])): ?>
          <div class="alert alert-success m-4" >
          <?php echo htmlspecialchars($_SESSION['successClient']); 
           unset($_SESSION['successClient']);
          ?>
         </div>
         <?php endif;?>
            <?php 
            // $pagination = $client->pagination($page, 5, $search);
            // $clients = $pagination['data'];
            ?>

         <?php
          $client = new Client($con);
          $clients = $client->listeClient();
         ?>
         
         <?php if(isset($_SESSION['updateClient'])): ?>
            <div class="alert alert-success m-4">
            <?php echo htmlspecialchars($_SESSION['updateClient']); 
             unset($_SESSION['updateClient']);  
            ?>
            </div>
            <?php endif;?>
         <?php if(isset($_SESSION['deleteClient'])): ?>
            <div class="alert alert-success m-4">
            <?php echo htmlspecialchars($_SESSION['deleteClient']); 
             unset($_SESSION['deleteClient']);  
            ?>
            </div>
            <?php endif;?>
        <div class="bloc-table" id="client">
            <div class="nom">Nom complet</div>
            <div class="telephone">Téléphone</div>
            <div class="adresse">Adresse</div>
            <div class="action">Action</div>
        </div>
        <div class="bloc-ligne" id="resultats">
            <?php foreach ($clients as $client): ?>
            <div class="row nom"><?php echo $client['nom']; ?></div>
            <div class="row telephone"><?php echo $client['telephone']?></div>
            <div class="row adresse"><?php echo $client['adresse'] ?></div>
            <div class=" action">
                <a class="edit" href="editClient.php?id=<?php echo $client['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="delete" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) { window.location.href = 'postDeleteClient.php?id=<?php echo $client['id']; ?>'; }"><i class="fa-solid fa-trash"></i></a>
                <a class="details"><i class="fa-solid fa-info-circle"></i></a>
            </div>
            <?php endforeach ;?>
        </div>
        <div>
            
            

    <div class="form" id="forme">
        <form action="postAddClient.php" method="POST">
         <a href="" id="croit" onclick="toggleX()"><i class="fa-solid fa-xmark"></i></a>
         <h2>Ajout employe</h2>
            <?php if(isset($_SESSION['already'])): ?>
          <div class="alert alert-success m-4" >
          <?php echo htmlspecialchars($_SESSION['already']); ?>
          <script>
                  document.addEventListener('DOMContentLoaded',function(){
                     toggleForm();
                  })
                 </script>
         <?php  unset($_SESSION['already']);
          ?>
         </div>
         <?php endif;?>
            <?php if(isset($_SESSION['messageError'])):   ?>
               
                <?php   echo '<p style="color:red;text-align:center;">' .$_SESSION['messageError']. '</p>'; ?> 
                 <script>
                  document.addEventListener('DOMContentLoaded',function(){
                     toggleX();
                  })
                 </script>
                      <?php  unset($_SESSION['messageError']);
                 ?>
            
               <?php endif; ?>
            <div class="inputBox">
                <div>Nom complet</div>
                <div class="input">
                    <input type="text" name="nom" required="required" placeholder="Votre nom">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="inputBox">
                <div>Telephone</div>
                <div class="input">
                    <input type="text" name="telephone" required="required" placeholder="Telephone">
                    <i class="fa-solid fa-phone"></i>
                </div>
            </div>
            <div class="inputBox">
                <div>Adresse</div>
                <div class="input">
                    <input type="text" name="adresse" required="required" placeholder="Adresse">
                    <i class="fa-solid fa-map-marker-alt"></i>
                </div>
            </div>

            <button class="btn" style="background-color: rgba(0, 153, 255, 0.493);">Ajouter</button>
        </form>
    </div>
    </section>
    <?php require_once __DIR__ . "/../includes/footer.php"?>
</main>