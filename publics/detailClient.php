<?php
require_once __DIR__ . '/../config/mysql.php';
 require_once __DIR__ . '/../classes/client.php';
 require_once __DIR__ . '/../classes/voiture.php';
 require_once __DIR__ .'/../publics/dashboardAdmin.php';

 if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "Client no trouve";
 }
 $idclient = $_GET['id'];
 $detailClients = new Client($con);
$detailClient = $detailClients->getClientById($idclient);

$statuse = $detailClients->getEtatVehicule($idclient);
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
       if(nav.style.width === "80%"){
         nav.style.width = "0%"
       }else{
         nav.style.width = "80%"
       }
    }
    </script>
    </header>
    <section>
        <p><span class="textClient">Clients</span><span class="textDetail">/details</span></p>

        <div class="card-detail-client">
            <div class="card-detail">
              <div class="arrow">
                <a href="gestionClient.php"><i class="fa-solid fa-arrow-left"></i>Retour</a>
                <a  onclick="toggleAddClient()">Ajouter voiture</a>
                <script>
                  function toggleAddClient(){
                   let addClient = document.getElementById("formulaire")
                   addClient.classList.toggle("activeClient")
                  }
        </script>
            </div>
                <div class="nom-client">
                    <i class="fa-solid fa-user-tie"></i>
                    <span><?php echo $detailClient['nom'];?></span>
                </div>
                <hr>
                <div class="info-client">
                    <div class="telephone-client"><i class="fa-solid fa-phone"></i><?php echo $detailClient['telephone'] ?></div>
                    <div class="adresse-client"><i class="fa-solid fa-map-marker-alt"></i><?php echo $detailClient['adresse'] ?></div>
                     <?php foreach($statuse as $statu): ?>
                    <div class="vehicule-client"><i class="fa-solid fa-car"></i><span>Etat vehicule: </span><?php echo $statu['status'] ?? "Pas de voiture" ?></div>
                    <?php endforeach;?>
                </div>
              <div class="bouton-contact">
                <button>Contacter</button>
                <a href="gestionVoiture.php">Liste voiture</a>
              </div>
            </div>
         <?php
            $client = new Client($con);
        //   $clients = $client->listeClient();
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $pagination = $client->getClientsPagines($page, 7);
            $clients = $pagination['clients'];
            ?>
            <div class="table-client">
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
                        <a class="details" href="detailClient.php?id=<?php echo $client['id'];?>"><i class="fa-solid fa-info-circle"></i></a>
                    </div>
                    <?php endforeach ;?>
                </div>
                <div class="pagination">
                    <?php if ($pagination['currentPage'] > 1): ?>
                        <a href="?page=<?= $pagination['currentPage'] - 1 ?>&id=<?=$client['id'] ?>">⬅️ Précédent</a>
                    <?php endif; ?>

                    <?php if ($pagination['currentPage'] < $pagination['totalPages']): ?>
                        <a href="?page=<?= $pagination['currentPage'] + 1 ?>&id=<?=$client['id'] ?>">Suivant ➡️</a>
                    <?php endif; ?>
                </div>
             </div>
        </div>
        <div>
        <?php $client_id = $_GET['id']?>
        <div class="formulaire" id="formulaire">
            <form action="postAddVoiture.php" method="POST">
                
                <a href="" id="croit" onclick="toggleX()"><i class="fa-solid fa-xmark"></i></a>
                <div class="group">
                    <input type="hidden" name="client_id" value="<?= $client_id ?>">
                </div>
                <div class="group">
                    <div>Immatriculation</div>
                    <input type="text" name="immatricule" id="" required>
                </div>
                <div class="group">
                    <div>Marque</div>
                    <input type="text" name="marque" id="" required>
                </div>
                <div class="group">
                    <div>Modele</div>
                    <input type="text" name="modele" id="" required>
                </div>
                <div class="group">
                    <div>Annee</div>
                    <input type="text" name="annee" id="" required>
                </div>
                <button class="btn" style="background-color: rgba(0, 153, 255, 0.493);">Ajouter</button>
            </form>
        </div>
    </section>
</main>