
<?php
      require_once __DIR__ .'/../config/mysql.php';
      require_once __DIR__ . "/dashboardAdmin.php";
      require_once __DIR__ . '/../classes/employe.php';
      
?>
<main>
<header> 
    <h2>Sunu Garage</h2>
    <div class="menuSide">
      <a onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></a>
    </div>
    <script>
      //  nav.classList.toggle("actife");
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
 <section class="section">
    <h2>Gestion des employés</h2>
    <div class="menu">
       <div class="search">
        <input type="text" name="search" placeholder="Rechercher..." id="searchInput">
        
        <!-- <div id="results"></div> -->
         <p id="noResult" style="display:none; color:red; font-weight:bold;">
          Aucun employé trouvé
        </p>
       </div>
       <script>
         document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#employeTable tbody tr");
            let noResult = document.getElementById("noResult");
            let visibleCount = 0;

         rows.forEach(row => {
          let text = row.textContent.toLowerCase();
          if (text.includes(filter)) {
            row.style.display = ""; // afficher
            visibleCount++;
          } else {
            row.style.display = "none"; // cacher
        }
    });
    if(filter !== "" && visibleCount === 0){
      noResult.style.display = "block";
    }else{
      noResult.style.display = "none";
    }
});

       </script>
       <div class="addEmploye"  >
         <button onclick="toggleForm()"><i class="fa-solid fa-plus"></i>Ajouter un employe</button>
       </div>
    </div>
    <?php
     $employe = new Employe($con);
     $employes = $employe->listeEmploye();?>

   <?php if(isset($_SESSION['success'])): ?>
      <div class="alert alert-success m-4" >
         <?php echo htmlspecialchars($_SESSION['success']); 
          unset($_SESSION['success']);
         ?>
      </div>
   <?php endif; ?>
   <?php if(isset($_SESSION['message'])): ?>
      <div class="alert alert-success m-4" >
         <?php echo htmlspecialchars($_SESSION['message']); 
          unset($_SESSION['message']);
         ?>
      </div>
   <?php endif; ?>
   <?php if(isset($_SESSION['update'])): ?>
      <div class="alert alert-success m-4">
         <?php echo htmlspecialchars($_SESSION['update']); 
          unset($_SESSION['update']);
         ?>
      </div>
      <?php endif?>
    <table class="employeTable" id="employeTable">
      <thead>
         <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Action</th>
         </tr>
         
      </thead>
      <tbody id="resultats">
         <?php foreach($employes as $employe) : ?>
            <tr>
               <td><?php echo htmlspecialchars($employe['nom']);?></td>
               <td><?php echo htmlspecialchars($employe['email']);?></td>
               <td>
                  <a class="btn-edit" href="editEmploye.php?id=<?php echo $employe['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                  <a class="btn-delete" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet employé ?'))
                   window.location.href='postDeleteEmploye.php?id=<?php echo $employe['id']; ?>'; "><i class="fa-solid fa-trash"></i></a>
               </td>
            </tr>
            <?php endforeach; ?>
      </tbody>
    </table>
    <div class="form" id="forme">
        <form action="postAddEmploye.php" method="POST">
         <a href="" id="croit" onclick="toggleX()"><i class="fa-solid fa-xmark"></i></a>
      <h2>Ajout employe</h2>
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
            <div class="role">Role</div>
            <select name="role" id="">
               <option value="admin">admin</option>
               <option value="employe">employe</option>
            </select>
            <button class="btn" style="background-color: rgba(0, 153, 255, 0.493);">Ajouter</button>
        </form>
    </div>
    
    
 </section>
 <?php require_once __DIR__ . "/../includes/footer.php"?>
</main>
