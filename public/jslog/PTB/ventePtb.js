
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
    
    let section = document.createElement('td');
    let sectionContent = document.createTextNode(commande.section);
    section.appendChild(sectionContent);
    array.push(section);

    let trajet = document.createElement('td');
    let trajetContent = document.createTextNode(`${commande.depart}-${commande.arrivee}`);
    //trajet.style.width="150px";
    trajet.appendChild(trajetContent);
    array.push(trajet);

    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(commande.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);

    let NbreCom = document.createElement('td');
   // NbreCom.style.width="100px";
    let NbreComContent = document.createTextNode(commande.nombreDeBilletCommander);
    NbreCom.appendChild(NbreComContent);
    array.push(NbreCom);

    let NbreReal = document.createElement('td');
   ////NbreReal.style.width="100px";
    let NbreRealContent = document.createTextNode(commande.nombreBilletRealiser);
    NbreReal.appendChild(NbreRealContent);
    array.push(NbreReal);

    let realisation = document.createElement('td');
    
    let pdiv =document.getElementById('pdiv').cloneNode(true);
    pdiv.style.display='block';
    
    let pdiv2 =document.getElementById('pdiv2').cloneNode(true);
    pdiv2.style.display = 'block';
    let progress =(commande.nombreBilletRealiser
    /commande.nombreDeBilletCommander)*100;
    pdiv2.style.width = `${progress}%`
    let realisationContent = document.createTextNode(`${progress}%`);
    pdiv2.appendChild(realisationContent);
    pdiv.appendChild(pdiv2)
    realisation.appendChild(pdiv);
    array.push(realisation);
    
    let NbreVendu = document.createElement('td');
    //NbreVendu.style.width="100px";
    let NbreVenduContent = document.createTextNode(commande.nombreBilletVendu);
    NbreVendu.appendChild(NbreVenduContent);
    array.push(NbreVendu);
    
    let stock = document.createElement('td');
    let stockContent = document.createTextNode(`${commande.nombreBilletRealiser-commande.nombreBilletVendu}`);
    stock.appendChild(stockContent);
    array.push(stock);
    
    let nombreVente = document.createElement('td');
    let div= document.createElement('div');
    div.classList.add('form-group');
    let input= document.createElement('input');
    input.type = 'number';
    input.classList.add('form-control');
    input.id ="i"+commande.id;
    input.placeholder = 'nombre de Vente';
    //input.style.width='20px';
    div.appendChild(input);
    nombreVente.appendChild(div);
    array.push(nombreVente);

    let button = document.createElement('button');
    let buttonContent = document.createTextNode('Valider');
    button.appendChild(buttonContent);
    button.id = "b"+commande.id;
    button.type = "button";
    button.classList.add('btn');
    button.classList.add('btn-success');
    button.innerText="saisir";
    array.push(button);
    button.addEventListener('click',(e) => ajoutVente(e.target))
    return array;
}

function ajoutVente(element)
{
    
    let idb=element.id.substr(1);
    let input=document.getElementById("i"+idb)
    let xhttp=new XMLHttpRequest();
    let vente = input.value;            
            xhttp.onload = function ()
            {
                if(this.readyState==200)
                {
                    console.log(this.responseText);
                    getAllCommande()
               }
            }
            let link =`http://localhost:8000/addVentePTB/${idb}/${vente}`;
            xhttp.open("GET",link,true);
            xhttp.send();
                
            console.log(link);
            
        
        
         
        
    
}
function getAllCommande()
{
    let xhr=new XMLHttpRequest();
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            console.log(JSON.parse(this.responseText));
            addRow(JSON.parse(this.responseText));
        }
    }
    xhr.open("GET","http://localhost:8000/Json/listCommande",true);
    xhr.send();

}
getAllCommande();

