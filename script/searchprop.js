function filtrerProprietaires(recherche) {
    const lignes = document.querySelectorAll('.ligne-voiture');
    const terme = recherche.toLowerCase().trim();
    
    lignes.forEach(ligne => {
        const nomProprietaire = ligne.getAttribute('data-proprietaire').toLowerCase();
        
        if (terme === '' || nomProprietaire.includes(terme)) {
            ligne.style.display = 'grid';
        } else {
            ligne.style.display = 'none';
        }
    });
    
    // Optionnel : Afficher un message si aucun résultat
    const resultatsVisibles = document.querySelectorAll('.ligne-voiture[style="display: grid"]').length;
    const aucunResultat = document.getElementById('aucunResultat');
    
    if (resultatsVisibles === 0 && terme !== '') {
        if (!aucunResultat) {
            const message = document.createElement('div');
            message.id = 'aucunResultat';
            message.className = 'aucun-resultat';
            message.textContent = 'Aucun véhicule trouvé pour ce propriétaire';
            document.getElementById('listeVoitures').appendChild(message);
        }
    } else if (aucunResultat) {
        aucunResultat.remove();
    }
}

// Optionnel : Vider le champ avec la touche Echap
document.getElementById('searchVoiture').addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        this.value = '';
        filtrerProprietaires('');
        this.blur();
    }
});