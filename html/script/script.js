function openOverlay() {
      document.getElementById("overlayMenuCat").style.display = "flex";
}

function closeOverlay() {
    document.getElementById("overlayMenuCat").style.display = "none";
}

window.onclick = function(event) {
  const overlay = document.getElementById("overlayMenuCat");
  if (event.target === overlay) {
    closeOverlay();
  }
};
