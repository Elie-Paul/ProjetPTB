const tbody = document.getElementById('tbody');
//<button type="button" class="btn btn-success">Success</button>
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
    let trajetContent = document.createTextNode(`${commande.depart}
    -${commande.arrivee}`);
    trajet.appendChild(trajetContent);
    array.push(trajet);

    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(commande.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);

    let NbreCom = document.createElement('td');
    let NbreComContent = document.createTextNode(commande.nombreDeBilletCommander);
    NbreCom.appendChild(NbreComContent);
    array.push(NbreCom);

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

    let Validation = document.createElement('td');
    let span = document.createElement('span');
    if(commande.etat===0)
    {
        let spanContent = document.createTextNode('pas encore validé');
        span.classList.add('label');
        span.classList.add('label-warning');
        span.appendChild(spanContent);
        Validation.appendChild(span);
    }
    else
    {
        let spanContent = document.createTextNode('commande deja validé');
        span.classList.add('label');
        span.classList.add('label-success');
        span.appendChild(spanContent);
        Validation.appendChild(span);
    }
    array.push(Validation);

    let button = document.createElement('button');
    let buttonContent = document.createTextNode('Valider');
    button.appendChild(buttonContent);
    button.id = ""+commande.id;
    button.type = "button";
    button.classList.add('btn');
    if(commande.etat===0)
    {
        button.classList.add('btn-success');
        button.classList.remove('btn-danger');
        button.innerText="valider";
    }
    else
    {
        button.classList.add('btn-danger');
        button.innerText="Annuler";
        button.classList.remove('btn-success');
    }
    button.addEventListener('click',(e) => validationAction(e.target));
    array.push(button);
    return array;
}
function validationAction(button)
{
    let xhr=new XMLHttpRequest();
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            //console.log(JSON.parse(this.responseText));
            //addRow(JSON.parse(this.responseText));
           console.log(this.responseText);
        }
    }
    xhr.open("POST","http://localhost:8000/ValidationCommandeNavette",true);
    xhr.send(button.id);
    getAllCommande();
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