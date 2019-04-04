
const tbody = document.getElementById('tbody');
const cmbEtat = document.getElementById('etat');
const start = document.getElementById('start');
const end = document.getElementById('end');
var tab =[];

cmbEtat.addEventListener('change',updateTab);
start.addEventListener('change',updateTab);
end.addEventListener('change',updateTab);

function addRow(array) 
{
    while (tbody.firstChild) 
    {
        tbody.removeChild(tbody.firstChild);
    }

   

    for (let index = 0; index < array.length; index++) 
    {
        if(array[index].etat >=1)
        {
            let tr = document.createElement('tr');
            tr.id=array[index].id;
            let arr=createRowElement(array[index]);
            arr.forEach((value) => tr.appendChild(value));
            tbody.appendChild(tr);
        }

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

function createRowElement(commande)
{
    let array=[];
    
    let guichet = document.createElement('td');
    let guichetContent = document.createTextNode('Controlleur');
    guichet.appendChild(guichetContent);
    array.push(guichet);

    
    let prix = document.createElement('td');
    let prixContent = document.createTextNode(commande.prix);
    prix.appendChild(prixContent);
    array.push(prix);

    let NbreCom = document.createElement('td');
    NbreCom.style.width="140px";
    let NbreComContent = document.createTextNode(commande.nombreDeBilletCommander);
    NbreCom.appendChild(NbreComContent);
    array.push(NbreCom);

    let NbreReal = document.createElement('td');
    NbreReal.style.width="120px";
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
    let realisationContent = document.createTextNode(`${progress.toFixed(2)}%`);
    pdiv2.appendChild(realisationContent);
    pdiv.appendChild(pdiv2)
    realisation.appendChild(pdiv);
    array.push(realisation);
    
    
    
    let DateCommande = document.createElement('td');
    DateCommande.style.width="180px";
    var d = new Date(commande.dateCommande.date);
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    //let DateCommandeContent = document.createTextNode(`${d.toDateString()}`);
    let DateCommandeContent = document.createTextNode(`${d.toLocaleDateString('fr-FR', options)}`);
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
    else if(commande.etat===0)
    {
        button.classList.add('btn-danger');
        button.innerText="Non Validé";
        button.classList.remove('btn-success');
    }
    else if(commande.etat===2)
    {
        button.classList.add('btn-warning');
        button.innerText="en cours traitement";
        button.classList.remove('btn-success');
    }
    else if(commande.etat===3)
    {
        button.classList.add('btn-info');
        button.innerText="traité";
        button.classList.remove('btn-success');
    }
    array.push(button);

    
    

    return array;
}
function DateCompare(date1,date2)
{
    let a=true;
    if(date1.getDate() != date2.getDate())
    {
        return false;
    }
    else if(date1.getMonth() != date2.getMonth())
    {
        return false
    }
    else if(date1.getFullYear() != date2.getFullYear())
    {
        return false;
    }
    return true;
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
            tab = JSON.parse(this.responseText); 
        }
    }
    xhr.open("GET","http://localhost:8000/Json/listCommandeTaxe",true);
    xhr.send();

}

function updateTab()
{
    //let idGuichet = cmbGuichets[selectedrow].options[cmbGuichets[selectedrow].selectedIndex].id;
    //alert(cmbGuichet.options[cmbGuichet.selectedIndex].value);
  /*let dateSelected = cmbDate.selectedIndex;*/
  let etatSelected = cmbEtat.selectedIndex;
  let tab1 = tab;
  if(start.value == '' && end.value == '' && etatSelected ==0)
  {
    getAllCommande();
  }
  
  if(etatSelected !==0)
  {
        
       // alert(etatSelected);
        tab1 = tab1.filter((value)=>
        {
            
            let sss=etatSelected - 1;
            //alert(sss+":::::"+value.etat);
            if (sss == value.etat)
            {
                return true  ;    
            }
            else
            {
                //alert("ssss");
                return false  ;
            }
            
        })
  }
  if(start.value != '' && end.value != '')
  {
    let dstart = new Date(start.value);
    let dend = new Date(end.value);
    tab1 = tab1.filter((value)=>
    {
        var date = new Date(value.dateCommande.date);
        if(DateCompare(date,dstart))
        {
            console.log("true");
            return true;
        }
        else if(DateCompare(date,dend))
        {
            console.log("true");
            return true;
        }
        else if(date > dstart && date < dend)
        {
            console.log("true");
            return true;
        }
        else
        {
            console.log("false");
            return false;
        }
            
    })

  }
  
  addRow(tab1);

}
getAllCommande();