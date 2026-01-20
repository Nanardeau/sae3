//Preview des images avant upload d'un produit
const input = document.getElementById('photoProd');
const dropZone = document.getElementById('dropZone');
const preview = document.getElementById('preview');

// clic = ouverture du sélecteur
dropZone.addEventListener('click', () => input.click());

// sélection classique
input.addEventListener('change', () => {
    if (input.files[0]) handleFile(input.files[0]);
});

// drag over
dropZone.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

// drag leave
dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

// drop
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('dragover');

    const file = e.dataTransfer.files[0];
    if (!file) return;

    // ✅ CORRECTION: utiliser DataTransfer pour remplir input.files
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;

    handleFile(file);
});

function handleFile(file) {
    if (!file.type.startsWith('image/')) {
        alert('Fichier invalide');
        input.value = '';
        return;
    }

    preview.innerHTML = ''; // remplace toujours l'image existante

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);

    const removeBtn = document.createElement('button');
    removeBtn.type = "button";
    removeBtn.innerHTML = '✕';

    removeBtn.addEventListener('click', () => {
        preview.innerHTML = '';
        input.value = '';
    });

    preview.appendChild(img);
    preview.appendChild(removeBtn);
}
