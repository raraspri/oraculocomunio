/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function soloNumeros(evt){
    //asignamos el valor de la tecla a keynum
    if(window.event){// IE
        keynum = evt.keyCode;
    }else{
        keynum = evt.which;
    }
    //comprobamos si se encuentra en el rango
    if((keynum>=46 && keynum<58) || (keynum==8)){
        return true;
    }else{
        return false;
    }
}

function compruebaCifra(){
    
}

  

