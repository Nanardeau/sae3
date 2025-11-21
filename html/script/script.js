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

window.onclick = function(event) {
  const overlay = document.getElementById("overlayMenuCatMob");
  if (event.target === overlay) {
    closeOverlayMobile();
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

let lastScroll = 0;
const header = document.querySelector("header");
const navbar = document.getElementsByClassName("nav-cat");

window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > lastScroll) {
        // Scroll vers le bas → cacher le header
        header.style.transform = "translateY(-100%)";
        //navbar.style.transform = "translateY(-100%)";
    } else {
        // Scroll vers le haut → montrer le header
        header.style.transform = "translateY(0)";
        //navbar.style.transform = "translateY(0)";
    }

    lastScroll = currentScroll;
});



