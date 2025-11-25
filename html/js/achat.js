


function modifier(btn){
    if(!btn){
        return;
    }
    
    let value = 1;
    document.cookie = 'qteprod = '+ value;
    if(btn.classList.contains("btn-plus")){
        value = value + 1;
        console.log(value + 1);
    }else if(btn.classList.contains("btn-moins")){
        if(value > 1){
            value = value - 1;
        }
        
    }
}