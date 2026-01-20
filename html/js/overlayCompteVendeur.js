window.onclick = function(event) {
  const overlayCptVdr = document.getElementById("overlayCompteVendeur");
    if (event.target === overlayCptVdr) {
      closeOverlayCompteVendeur();
    }
};

function openOverlayCompteVendeur() {
  const overlayCpt = document.getElementById("overlayCompteVendeur");
  overlayCpt.style.display = "block";
}

function closeOverlayCompteVendeur() {
  const overlayCpt = document.getElementById("overlayCompteVendeur");
  overlayCpt.style.display = "none";
}