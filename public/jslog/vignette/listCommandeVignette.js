
const tbody = document.getElementById('tbody');
const cmbEtat = document.getElementById('etat');
const cmbGuichet = document.getElementById('guichet');
const today = new Date();
const start = document.getElementById('start');
const end = document.getElementById('end');
var tab =[];
cmbGuichet.addEventListener('change',updateTab);
cmbEtat.addEventListener('change',updateTab);
start.addEventListener('change',updateTab);
end.addEventListener('change',updateTab);
a=false;
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
    if(!a)
        addGuichet();
    a=true;
    
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
    
    let buttonTd = document.createElement('td');
    buttonTd.style.width="20px";
    let button = document.createElement('button');
    let buttonContent = document.createTextNode('Valider');
    button.appendChild(buttonContent);
    
    button.type = "button";
    button.disabled = false;
    button.classList.add('btn');
    let modifierTd = document.createElement('td');
    let modifier = document.createElement('i');
    modifier.classList.add('glyphicon');
    modifier.classList.add('glyphicon-edit');
    modifier.classList.add('popup');
    modifier.id = commande.id;
    modifierTd.style.width="10px"
    modifier.style.fontSize = "25px";
    modifier.style.color = '#5cb85c';
    let popspan = document.createElement('span');
    popspan.classList.add('popuptext');
    popspan.appendChild(document.createTextNode('modifier'));
    modifier.appendChild(popspan);
    if(commande.etat ===0)
    {
        modifier.addEventListener('mouseover',(e)=> 
        {
            e.target.style.transform ='scale(1.5, 1.5)';
            e.target.firstChild.classList.toggle("show");
            e.target.firstChild.style.fontSize="10px";
        }
        
        );
        modifier.addEventListener('mouseout',(e)=> 
        {
            e.target.style.transform ='scale(1, 1)';
            e.target.firstChild.classList.toggle("show");
            
        }
        
        );
        modifier.addEventListener('click',(e)=> modifierCommande(e.target));
    }    
    let removeTd = document.createElement('td');
    ;
    let remove = document.createElement('i');
    remove.classList.add('glyphicon');
    remove.classList.add('glyphicon-remove');
    remove.classList.add('popup');
    remove.style.fontSize = "25px";
    remove.id = "r" +commande.id;
    remove.style.color = '#d9534f';
    let popspan2 = document.createElement('span');
    popspan2.classList.add('popuptext');
    popspan2.appendChild(document.createTextNode('annuler'));
    remove.appendChild(popspan2);
    if(commande.etat === 0)
    {

    
        remove.addEventListener('mouseover',(e)=> 
        {
            e.target.style.transform ='scale(1.5, 1.5)';
            e.target.firstChild.classList.toggle("show");
            e.target.firstChild.style.fontSize="10px";
        }
        
        );
        remove.addEventListener('mouseout',(e)=> 
        {
            e.target.style.transform ='scale(1, 1)';
            e.target.firstChild.classList.toggle("show");
            
        }
        
        );
        remove.addEventListener('click',(e)=> deleteCommande(e.target));
    }
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
    buttonTd.appendChild(button);
    modifierTd.appendChild(modifier);
    removeTd.appendChild(remove);if(commande.etat===1)
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
    buttonTd.appendChild(button);
    modifierTd.appendChild(modifier);
    removeTd.appendChild(remove);
    array.push(buttonTd);
    array.push(modifierTd);
    array.push(removeTd);

  
    

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
    xhr.open("GET","http://localhost:8000/Json/listCommandeVignette",true);
    xhr.send();

}
function addGuichet()
{
    for (let index = 1; index < cmbGuichet.children.length; index++) 
    {
        cmbGuichet.removeChild(cmbGuichet.children[index]);
    }
    let xhr=new XMLHttpRequest();
    xhr.onload=function ()
    {
        if(this.status == 200)
        {
            
            let tabgui = JSON.parse(this.responseText); 
            for (let index = 0; index < tabgui.length; index++) 
            {
                let option = document.createElement('option');
                let optionContent = document.createTextNode(tabgui[index].nom);
                option.appendChild(optionContent);
                cmbGuichet.appendChild(option);
            }
            
        }
    }
    xhr.open("GET","http://localhost:8000/json/guichet/",true);
    xhr.send();
    
}

function updateTab()
{
    //let idGuichet = cmbGuichets[selectedrow].options[cmbGuichets[selectedrow].selectedIndex].id;
    //alert(cmbGuichet.options[cmbGuichet.selectedIndex].value);
  let guichetSelected = cmbGuichet.selectedIndex;
  /*let dateSelected = cmbDate.selectedIndex;*/
  let etatSelected = cmbEtat.selectedIndex;
  let tab1 = tab;
  if(guichetSelected ==0 && start.value == '' && end.value == '' && etatSelected ==0)
  {
    getAllCommande();
  }
  if(guichetSelected !=0)
  {
        tab1 = tab1.filter((value)=>
        {
            return cmbGuichet.options[cmbGuichet.selectedIndex].value ==value.guichet;
        })
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

function modifierCommande(element)
{
    let id = element.id;
    swal("Nombre de billet a commander:", 
    {
        content: "input",
    })
    .then((value) => 
    {
        let xhr = new XMLHttpRequest();
        xhr.onload = function()
        {
            if(this.status == 200)
            {
                swal({
                    icon: "success",
                  });
            }
        }
        xhr.open("GET",`http://localhost:8000/commande/vignette/modifier/${id}/${value}`,true);
        xhr.send();
        getAllCommande();
        updateTab();
    });
}
function deleteCommande(element)
{
    let id = element.id;
    id = id.substr(1);
    swal("Nombre de billet a commander:", 
    {
        title: "Etes vous sûr ?",
        text: "souhaitez-vous supprimer ces commandes",
        icon: "warning",
        buttons: true,
    })
    .then((willDelete) => 
    {
        if(willDelete)
        {

        
            let xhr = new XMLHttpRequest();
            xhr.onload = function()
            {
                if(this.status == 200)
                {
                    swal({
                        icon: "success",
                    });
                }
            }
            xhr.open("GET",`http://localhost:8000/commande/vignette/delete/${id}`,true);
            xhr.send();
            getAllCommande();
            updateTab();
        }    
    });
}
getAllCommande();