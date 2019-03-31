const   inputs = document.getElementsByTagName('input');
const tbody = document.getElementById('tbody');
function addRow(array) 
{
    while (tbody.firstChild) 
    {
        tbody.removeChild(tbody.firstChild);
    }
    for (let index = 0; index < array.length; index++) 
    {
        let tr = document.createElement('tr');
        tr.id=array[index].id;
        let arr=createRowElement(array[index]);
        arr.forEach((value) => tr.appendChild(value));
        tbody.appendChild(tr);
    }
}

function createRowElement(commande)
{
    let array=[];
    
    let prix = document.createElement('td');
    let prixContent = document.createTextNode(commande.Prix);
    prix.appendChild(prixContent);
    array.push(prix);

    let guichet = document.createElement('td');
    let guichetContent =document.createTextNode('Controlleur') ;
    guichet.appendChild(guichetContent);
    array.push(guichet);

    /*<div class=length"form-group">
    <input type="number"  class="form-control nbreBillet"  placeholder="nombre de billet">
    </div> </div>*/
    let nombreCommande = document.createElement('td');
    let div= document.createElement('div');
    div.classList.add('form-group');
    
    let input= document.createElement('input');
    input.type = 'number';
    input.classList.add('form-control');
    input.id=''+commande.id;
    input.placeholder = 'nombre de billet';
    div.appendChild(input);
    nombreCommande.appendChild(div);
    array.push(nombreCommande);

    return array;
}


 function passerCommande() 
 {
    
    
    for (let i = 0; i < inputs.length; i++) 
    {
        let xhttp=new XMLHttpRequest();
        xhttp.onload = function ()
        {
            if(this.readyState==200)
            {
                console.log(this.responseText);
            }
        }
        let link ="http://localhost:8000/newCommandeTaxe/";
        let params =`${inputs[i].value}`;
       
            xhttp.open("POST",link,true);
            xhttp.send(params);  
        
        
       /* if(i==inputs.length)
        {
            setTimeout(function(){ document.location.href = "http://localhost:8000/commande/taxe/";}
            , index*600); 
        }*/
    } 
    
     
 }
 function getTaxes() 
 {
        let xhttp=new XMLHttpRequest();
        xhttp.onload = function ()
        {
            addRow(JSON.parse(this.responseText));
            console.log(JSON.parse(this.responseText))
        }
        let link ="http://localhost:8000/json/BilletsTaxe/";
        
        
        xhttp.open("GET",link,true);
        xhttp.send();  
        
     
    
     
 }
 getTaxes();
 
          