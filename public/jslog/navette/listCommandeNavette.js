

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
    
    let classe = document.createElement('td');
    let classeContent = document.createTextNode(commande.classe);
    classe.appendChild(classeContent);
    array.push(classe);

    let trajet = document.createElement('td');
    let trajetContent = document.createTextNode(`${commande.depart}-${commande.arrivee}`);
    trajet.style.width="150px";
    trajet.appendChild(trajetContent);
    array.push(trajet);

    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(commande.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);

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
    NbreVendu.style.width="100px";
    let NbreVenduContent = document.createTextNode(commande.nombreBilletVendu);
    NbreVendu.appendChild(NbreVenduContent);
    array.push(NbreVendu);
    
    
    

    let DateCommande = document.createElement('td');
    DateCommande.style.width="100px";
    var d = new Date(commande.dateCommande.date);
    let DateCommandeContent = document.createTextNode(`${d.getDay()}/${d.getMonth()}/${d.getFullYear()}`);
    DateCommande.appendChild(DateCommandeContent);
    
    array.push(DateCommande);

    let button = document.createElement('button');
    let buttonContent = document.createTextNode('Valider');
    button.appendChild(buttonContent);
    button.id = ""+commande.id;
    button.type = "button";
    button.disabled = false;
    button.classList.add('btn');
    if(commande.etat===1)
    {
        button.classList.add('btn-success');
        button.classList.remove('btn-danger');
        button.innerText="validé";
    }
    else
    {
        button.classList.add('btn-danger');
        button.innerText="Non Validé";
        button.classList.remove('btn-success');
    }
    array.push(button);
    

    return array;
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
    xhr.open("GET","http://localhost:8000/Json/listCommandeNavette",true);
    xhr.send();

}

getAllCommande();