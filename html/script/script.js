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


window.onclick = function(event) {
  const overlay = document.getElementById("overlayMenuCat");
  if (event.target === overlay) {
    closeOverlay();
  }
};
