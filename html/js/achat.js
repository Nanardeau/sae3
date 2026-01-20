
document.addEventListener('DOMContentLoaded', () => {
    qteProd = document.getElementById("nbArt");
});

function modifier(btn){
    if(!btn){
        return;
    }
    qteProd = qteProd || document.getElementById("nbArt");
    if(!qteProd){
        
        return;
    }
    let value = +qteProd.textContent || 0;
    if(btn.classList.contains("btn-plus")){
        qteProd.textContent = value + 1;
        console.log(value + 1);
    }else if(btn.classList.contains("btn-moins")){
        if(value > 1){
            qteProd.textContent = value - 1;
        }
        
    }

}
function getQuantite(){
    qteProd = qteProd || document.getElementById("nbArt");
    return parseInt(qteProd?.textContent) || 1;
}