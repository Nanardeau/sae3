document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.articlePanier').forEach(Competeur => {
    const compteur = Competeur.querySelector('.compteur');
    if (!compteur) return;
    const moins = compteur.querySelector('.btn-moins');
    const plus = compteur.querySelector('.btn-plus');
    const supp = compteur.querySelector('.btn-supp');
    const idPanier = Competeur.dataset.idpanier;
    const idProd = Competeur.dataset.codeprod;

    if (moins) moins.addEventListener('click', () => modifierQte('moins', idPanier, idProd));
    if (plus) plus.addEventListener('click', () => modifierQte('plus', idPanier, idProd));
    if(supp) supp.addEventListener('click', ()=> suppArticle('supp',idPanier,idProd));
  });
});

async function modifierQte(action, idPanier, idProd) {
    if (!idPanier || !idProd) {
    console.error('idPanier or idProd missing');
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

async function suppArticle(action, idPanier, idProd,){

}