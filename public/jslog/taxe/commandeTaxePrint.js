

/**
 * Code design interface row adding 
 * */      

//<button type="button" class="btn btn-success">Success</button>
function addRow(array) 
{
    while (tbody.firstChild) 
    {
        tbody.removeChild(tbody.firstChild);
    }
    for (let index = 0; index < array.length; index++) 
    {
        if(array[index].etat==1)
        {
            let tr = document.createElement('tr');
            tr.id=array[index].id;
            let arr=createRowElement(array[index]);
            arr.forEach((value) => tr.appendChild(value));
            tbody.appendChild(tr);
        }
       
    }
}
function createRowElement(commande)
{
    let array=[];
    
    let prix = document.createElement('td');
    let prixContent = document.createTextNode(commande.prix);
    prix.appendChild(prixContent);
    array.push(prix);

    let guichet = document.createElement('td');
    let guichetContent =document.createTextNode(commande.guichet) ;
    guichet.appendChild(guichetContent);
    array.push(guichet);

    let nombreCommande = document.createElement('td');
    let div= document.createElement('div');
    div.classList.add('form-group');
    
    let NbreCom = document.createElement('td');
    NbreCom.style.width="100px";
    let NbreComContent = document.createTextNode(commande.nombreDeBilletCommander);
    NbreCom.appendChild(NbreComContent);
    array.push(NbreCom);

    let NbreReal = document.createElement('td');
    NbreReal.style.width="100px";
    let NbreRealContent = document.createTextNode(commande.nombreBilletRealiser);
    NbreReal.appendChild(NbreRealContent);
    array.push(NbreReal);

    let realisation = document.createElement('td');
    
    let pdiv =document.getElementById('pdiv').cloneNode(true);
    pdiv.style.display='block';
    
    let pdiv2 =document.getElementById('pdiv2').cloneNode(true);
    let progress =(commande.nombreBilletRealiser
        /commande.nombreDeBilletCommander)*100;
        pdiv2.style.width = `${progress}%`
    pdiv2.style.display = 'block';
    //pdiv2.style.width = '40%'
    let realisationContent = document.createTextNode(`${progress}%`);
    pdiv2.appendChild(realisationContent);
    pdiv.appendChild(pdiv2)
    realisation.appendChild(pdiv);
    array.push(realisation);

    

  

    return array;
}
function getTaxes() 
{
        let xhttp=new XMLHttpRequest();
        xhttp.onload = function ()
        {
            addRow(JSON.parse(this.responseText));
            console.log(JSON.parse(this.responseText))
        }
        let link ="http://localhost:8000/Json/listCommandeTaxe";
        
        
        xhttp.open("GET",link,true);
        xhttp.send();  
        
     
    
     
}

getTaxes();