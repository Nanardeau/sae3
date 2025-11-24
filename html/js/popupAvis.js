'use strict';

// Récupère le popup (ou null)
const getPopup = () => document.querySelector('#popup-overlay');

// Ouvre/ferme le popup
const togglePopup = () => {
    const popup = getPopup();
    if (!popup) return;
    popup.classList.toggle('open');
};

// Ouvre le popup si l'URL contient ?Avis=1
const openPopupIfAvis = () => {
    const params = new URLSearchParams(window.location.search);
    if (params.get('Avis') === '1') {
        const popup = getPopup();
        if (popup) popup.classList.add('open');
    }
};

// Rendre disponible pour onclick dans le PHP
window.togglePopup = togglePopup;

// Lancer au chargement de la page
document.addEventListener('DOMContentLoaded', openPopupIfAvis);
