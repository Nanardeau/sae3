//Preview des images avant upload d'un produit
document.getElementById('photoProd').addEventListener('change', function (e) {
    const preview = document.getElementById('preview');
    preview.innerHTML = ''; // reset

    const file = e.target.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('Le fichier doit être une image');
        e.target.value = '';
        return;
    }

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.onload = () => URL.revokeObjectURL(img.src); // nettoyage mémoire

    preview.appendChild(img);
});

//zone de drag an drop
const dropZone = document.getElementById('dropZone');
const input = document.getElementById('photoProd');
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

    input.files = e.dataTransfer.files; // synchronise avec le input
    handleFile(file);
});

function handleFile(file) {
    if (!file.type.startsWith('image/')) {
        alert('Fichier invalide');
        return;
    }

    preview.innerHTML = ''; // remplace toujours l'image existante

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);

    const removeBtn = document.createElement('button');
    removeBtn.innerHTML = '✕';

    removeBtn.addEventListener('click', () => {
        preview.innerHTML = '';
        input.value = '';
    });

    preview.appendChild(img);
    preview.appendChild(removeBtn);
}
