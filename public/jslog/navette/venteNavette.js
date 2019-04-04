
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
        
        $("table").tableExport().remove();
          
        $("table").tableExport({
            headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
            footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
            formats: ["xls", "csv", "txt"],    // (String[]), filetypes for the export
            fileName: "idghg",                    // (id, String), filename for the downloaded file
            bootstrap: true,                   // (Boolean), style buttons using bootstrap
            position: "top",               // (top, bottom), position of the caption element relative to table
            ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file(s)
            ignoreCols: [7,7],                  // (Number, Number[]), column indices to exclude from the exported file(s)
            ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
            emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
            trimWhitespace: false              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
        });
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
    stock.id = 'n'+commande.id;
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
            let link =`http://localhost:8000/addVenteNavette/${idb}/${vente}`;
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
    xhr.open("GET","http://localhost:8000/Json/listCommandeNavette",true);
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
        console.log(stock);
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
                       
                    }
                }
                let link =`http://localhost:8000/addVenteNavette/${idc}/${vente}`;
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

