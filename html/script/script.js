function openOverlay() {
  const overlay = document.getElementById("overlayMenuCat");
  overlay.style.display = "block";
  document.body.style.overflow = "hidden"; // bloque le scroll de la page
}

function closeOverlay() {
  const overlay = document.getElementById("overlayMenuCat");
  overlay.style.display = "none";
  document.body.style.overflow = ""; // réactive le scroll
}

function openOverlayMobile() {
  const overlay = document.getElementById("overlayMenuCatMob");
  overlay.style.display = "block";
  document.body.style.overflow = "hidden"; // bloque le scroll de la page
}

function closeOverlayMobile() {
  const overlay = document.getElementById("overlayMenuCatMob");
  overlay.style.display = "none";
  document.body.style.overflow = ""; // réactive le scroll
}


window.onclick = function(event) {
  const overlay = document.getElementById("overlayMenuCat");
  if (event.target === overlay) {
    closeOverlay();
  }
};

document.addEventListener("DOMContentLoaded", () => {
    const selectQte = document.getElementById('qte');
    const priceElement = document.getElementById('price');
    const basePrice = parseFloat(priceElement.dataset.price);

    function updatePrice() {
        const qte = parseInt(selectQte.value);
        const total = (basePrice * qte).toFixed(2);
        priceElement.textContent = total + " €";
    }

    // Maj au changement de quantité
    selectQte.addEventListener('change', updatePrice);
});

const overlay = document.getElementById('overlay-photos-avis');

document.querySelectorAll('.photo-avis').forEach(img => {
    img.addEventListener('click', () => {
        overlay.innerHTML = `<img src="${img.src}" alt="Image agrandie">`;
        overlay.style.display = 'flex';
    });
});

overlay.addEventListener('click', () => {
    overlay.style.display = 'none';
    overlay.innerHTML = '';
});


