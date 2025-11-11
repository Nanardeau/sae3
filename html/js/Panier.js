document.addEventListener('DOMContentLoaded', () => {
  
  const vider = document.querySelector('.btn-vider');
  document.querySelectorAll('.articlePanier').forEach(Compteur => {
    const compteur = Compteur.querySelector('.compteur');
    if (!compteur) return;
    const moins = compteur.querySelector('.btn-moins');
    const plus = compteur.querySelector('.btn-plus');
    const supp = compteur.querySelector('.btn-supp');
    
    let idPanier = Compteur.dataset.idpanier;
    let idProd = Compteur.dataset.codeprod;

    if (moins) moins.addEventListener('click', () => modifierQte('moins', idPanier, idProd));
    if (plus) plus.addEventListener('click', () => modifierQte('plus', idPanier, idProd));
    if (supp) supp.addEventListener('click', ()=> supprimer('supp', idPanier, idProd));
    
  });
  let idPanier = vider.dataset.idpanier;
  if (vider) vider.addEventListener('click',() => supprimerPanier('vider',idPanier));
});

async function modifierQte(action, idPanier, idProd) {
    if (!idPanier || !idProd) {
    console.error('Erreur : idPanier ou idProd non séléctionner');
    return;
  }

  if (action === "moins") {
    try {
      const result = await fetch(
        `http://localhost:3000/update-moins/${idPanier}/${idProd}`,
        { method: "PUT" }
      );
      
      location.reload();
    } catch (err) {
      console.error("Erreur lors de la mise à jour :", err);
    }
  } else if (action === "plus") {
    try {
      
      const result = await fetch(
        `http://localhost:3000/update-plus/${idPanier}/${idProd}`,
        { method: "PUT" }
      );
      
      location.reload();
    } catch (err) {
      console.error("Erreur lors de la mise à jour :", err);
    }
  }
}

async function supprimer(action, idPanier, idProd){
    if (!idPanier || !idProd) {
    console.error('Erreur : idPanier ou idProd non séléctionner');
    return;
  }
  console.log('test');
  if(action === "supp"){
    if(confirm("Voulez vous supprimer l'article de votre panier") == true){
      try{
      const result = await fetch(
        `http://localhost:3000/supprimer/${idPanier}/${idProd}`,{
          method: "PUT"
        }
        
      );
    }catch(err){
      console.error("Erreur lors de la suppression :", err);
    }
    location.reload();
    }

  }
}
async function supprimerPanier(action,idPanier) {
  if(action === "vider"){
    var choix =  confirm("Voulez vous supprimer votre panier");
    if(choix == true){
      try{
          const result = await fetch(
          `http://localhost:3000/supprimerPanier/${idPanier}`,
          { method: "PUT"}
      );
      }catch(err){
        console.error("Erreur lors de la suppression :", err);
      }
      location.reload();
    }
  }
  
}