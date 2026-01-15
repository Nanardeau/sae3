// function openOverlay() {
//   const overlay = document.getElementById("overlayMenuCat");
//   overlay.style.display = "block";
//   document.body.style.overflow = "hidden"; 
// }

// function closeOverlay() {
//   const overlay = document.getElementById("overlayMenuCat");
//   overlay.style.display = "none";
//   document.body.style.overflow = ""; 
// }

function openOverlayCompte() {
  const overlayCpt = document.getElementById("overlayCompte");
  overlayCpt.style.display = "block";
}


function closeOverlayCompte() {
  const overlayCpt = document.getElementById("overlayCompte");
  overlayCpt.style.display = "none";
}

function openOverlayMobile() {
  const overlay = document.getElementById("overlayMenuCatMob");
  overlay.style.display = "block";
  document.body.style.overflow = "hidden";
}

function closeOverlayMobile() {
  const overlay = document.getElementById("overlayMenuCatMob");
  overlay.style.display = "none";
  document.body.style.overflow = ""; 
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

window.onclick = function(event) {
  const overlayCpt = document.getElementById("overlayCompte");
  if (event.target === overlayCpt) {
    closeOverlayCompte();
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

    selectQte.addEventListener('change', updatePrice);
});

let lastScroll = 0;
let ticking = false;

const header = document.querySelector("header");
const navbar = document.querySelector("nav");

function onScroll() {
    const currentScroll = window.pageYOffset;

    if (currentScroll <= 0) {
        header.style.transform = "translateY(0)";
        navbar.style.transform = "translateY(0)";
        lastScroll = 0;
        return;
    }

    if (Math.abs(currentScroll - lastScroll) < 5) {
        
      return;
    }

    if (currentScroll > lastScroll) {
        header.style.transform = "translateY(-100%)";
        navbar.style.transform = "translateY(-300%)";
        closeOverlayCompte();
    } else {
        header.style.transform = "translateY(0)";
        navbar.style.transform = "translateY(0)";
    }

    lastScroll = currentScroll;
}

window.addEventListener("scroll", () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            onScroll();
            ticking = false;
        });
        ticking = true;
    }
});



const stars = document.querySelectorAll('#stars span');
const noteInput = document.getElementById('noteProd');

function updateStars(note) {
    stars.forEach(s => {
        if (s.dataset.value <= note) {
            s.classList.add('full');
        } else {
            s.classList.remove('full');
        }
    });
}

stars.forEach(star => {

    star.addEventListener('click', () => {
        noteInput.value = star.dataset.value;
        updateStars(noteInput.value);
    });

    star.addEventListener('mouseover', () => {
        updateStars(star.dataset.value);
    });

    star.addEventListener('mouseout', () => {
        updateStars(noteInput.value);
    });
});


const track = document.querySelector('.carousel-track');
const slides = Array.from(track.children);
let index = 0;

function nextSlide() {
    index = (index + 1) % slides.length;
    track.style.transform = `translateX(-${index * 100}%)`;
}

setInterval(nextSlide, 4000);


//photo overlay avis 








