
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
        
        if(array[index].etat>=2)
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
    
    let type = document.createElement('td');
    let typeContent = document.createTextNode(commande.type);
    type.appendChild(typeContent);
    array.push(type);

    let section = document.createElement('td');
    let sectionContent = document.createTextNode(commande.section);
    section.appendChild(sectionContent);
    array.push(section);
    
    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(commande.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);

    let NbreCom = document.createElement('td');
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
    stock.id = 'n'+commande.id;
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

    let resultsaisi = document.createElement('span');
    resultsaisi.classList.add('label');
    resultsaisi.id ="s"+commande.id;

    array.push(resultsaisi);
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
            let link =`http://localhost:8000/addVenteVignette/${idb}/${vente}`;
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
    xhr.open("GET","http://localhost:8000/Json/listCommandeVignette",true);
    xhr.send();

}
function validerVente()
{
    swal({
        title: "Validez",
        text: "souhaitez valider les valeur saisi",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                vente();
            }
        });
}
function vente()
{
    for(let i=0 ;i<inputs.length ;i++)
    {
        let element=inputs[i];
        let idc=element.id.substr(1);
        let stock = document.getElementById("n"+idc).innerText;
        stock = parseInt(stock,10);
        let vente = parseInt(element.value,10); 
        let span = document.getElementById("s"+idc);
        if(element.value != "" && !element.disabled) 
        {
            if (vente<=stock) 
            {
                span.classList.remove('label-danger');
                span.innerText="";
                span.classList.add('label-success');
                let text1 = document.createTextNode("saisi reussi");
                span.appendChild(text1);
                element.disabled = true;
                let xhttp=new XMLHttpRequest();
                xhttp.onload = function ()
                {
                    if(this.readyState==200)
                    {
                        console.log(this.responseText);
                        
                    }
                    else
                    {
                       /*console.log(this.responseText);
                        span.classList.add('label-danger')
                        let text = document.createTextNode("echec")
                        span.appendChild(text);*/
                    }
                }
                let link =`http://localhost:8000/addVenteVignette/${idc}/${vente}`;
                xhttp.open("GET",link,true);
                xhttp.send();
            }
            else
            {
                        console.log(this.responseText);
                        span.classList.add('label-danger');
                        let text = document.createTextNode("echec");
                        span.appendChild(text);
            }
        }
        
        
    };
    swal({
        title: "Vente renseigné",
        text: "cliquez sur annuler pour corriger les potentiels erreurs",
        icon: "info",
        buttons: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                getAllCommande();
            }
        });

   
}
getAllCommande();

