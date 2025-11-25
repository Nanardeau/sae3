function sendGet(url, onSuccess, onError) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (typeof onSuccess === 'function') onSuccess(xhr);
        } else {
            if (typeof onError === 'function') onError(xhr);
        }
    };
    xhr.onerror = function() {
        if (typeof onError === 'function') onError(xhr);
    };
    xhr.send();
}
function ajouterCatalogue(idProd){
        if(confirm("Voulez vous ajouter cet article au catalogue?")){
        url = "/backoffice/statut.php?Action=ajouter&Produit=" + encodeURIComponent(idProd);
        url2 = "/backoffice/ficheProduit.php?Produit=" + encodeURIComponent(idProd);
        sendGet(url,function() { 
            location.replace(url2); 
        },
        function() { 
            alert('Erreur côté serveur.');
         }
        );
    }                       
}
function retirerCatalogue(idProd){
        if(confirm("Voulez vous retirer cet article du catalogue?")){
        url = "/backoffice/statut.php?Action=retirer&Produit=" + encodeURIComponent(idProd);
        url2 = "/backoffice/ficheProduit.php?Produit=" + encodeURIComponent(idProd);
        sendGet(url,function() {
            location.replace(url2); 
        },
        function() { 
            alert('Erreur côté serveur.');
         }
        );
    }                       
}