
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

function createRowElement(billet)
{
    let array=[];
    
    let section = document.createElement('td');
    let sectionContent = document.createTextNode(billet.section);
    section.appendChild(sectionContent);
    array.push(section);

    let trajet = document.createElement('td');
    let trajetContent = document.createTextNode(`${billet.depart}-${billet.arrivee}`);
    //trajet.style.width="150px";
    trajet.appendChild(trajetContent);
    array.push(trajet);

    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode(billet.guichet);
    guichet.appendChild(guichetContent);
    array.push(guichet);
    
    let stock = document.createElement('td');
    let stockContent = document.createTextNode(`${billet.stock}`);
    stock.id = 'n'+billet.id;
    stock.appendChild(stockContent);
    array.push(stock);
    
    let nombreVente = document.createElement('td');
    let div= document.createElement('div');
    div.classList.add('form-group');
    let input= document.createElement('input');
    input.type = 'number';
    input.classList.add('form-control');
    input.id ="i"+billet.id;
    input.placeholder = 'nombre de Vente';
    input.setAttribute("min",1);
    //input.style.width='20px';
    div.appendChild(input);
    nombreVente.appendChild(div);
    array.push(nombreVente);

    let resultsaisi = document.createElement('span');
    resultsaisi.classList.add('label');
    resultsaisi.id ="s"+billet.id;

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
            let link =`${superLink}/addVentePTB/${idb}/${vente}`;
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
    xhr.open("GET",superLink+"/Json/ptb/billet",true);
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
            if (vente<=stock && vente>=1) 
            {
                
                let xhttp=new XMLHttpRequest();
                xhttp.onload = function ()
                {
                    if(this.status==200)
                    {
                        console.log(this.responseText);
                        span.classList.remove('label-danger');
                        span.innerText="";
                        span.classList.add('label-success');
                        let text1 = document.createTextNode("saisi reussi");
                        span.appendChild(text1);
                        element.disabled = true;
                    }
                    else
                    {
                       console.log(this.responseText);
                       span.classList.remove('label-success');
                        span.innerText="";

                        span.classList.add('label-danger')
                        let text = document.createTextNode("echec")
                        span.appendChild(text);
                    }
                }
                let link =`${superLink}/addVentePTB/${idc}/${vente}`;
                xhttp.open("GET",link,false);
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

